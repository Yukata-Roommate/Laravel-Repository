<?php

namespace YukataRm\Laravel\Repository\Entity;

use YukataRm\Laravel\Repository\Interfaces\EntityInterface;
use YukataRm\Laravel\Repository\Interfaces\ModelInterface;

use YukataRm\Entity\BaseEntity as PHPBaseEntity;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

/**
 * Base Entity
 *
 * @package YukataRm\Laravel\Repository\Entity
 */
abstract class BaseEntity extends PHPBaseEntity implements EntityInterface
{
    /**
     * whether data flushed
     *
     * @var bool
     */
    protected bool $isFlushed;

    /**
     * constructor
     *
     * @param \YukataRm\Laravel\Repository\Interfaces\ModelInterface $model
     */
    public function __construct(ModelInterface $model)
    {
        $this->setData($model);

        $this->prepare();

        $this->bind();

        $this->passed();

        if ($this->isFlushed()) $this->flush();
    }

    /**
     * prepare bind Model properties
     *
     * @return void
     */
    protected function prepare(): void {}

    /**
     * bind Model properties
     *
     * @return void
     */
    abstract protected function bind(): void;

    /**
     * passed bind Model properties
     *
     * @return void
     */
    protected function passed(): void {}

    /**
     * whether data flushed
     *
     * @return bool
     */
    public function isFlushed(): bool
    {
        return isset($this->isFlushed) ? $this->isFlushed : true;
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * get property as Carbon
     *
     * @param string $name
     * @return \Carbon\Carbon
     */
    public function carbon(string $name): Carbon
    {
        $value = $this->get($name);

        if (is_null($value)) throw $this->requiredException($name);

        return $value instanceof Carbon ? $value : new Carbon($value);
    }

    /**
     * get property as nullable Carbon
     *
     * @param string $name
     * @return \Carbon\Carbon|null
     */
    public function nullableCarbon(string $name): Carbon|null
    {
        return $this->makeNullable(fn() => $this->carbon($name));
    }

    /**
     * get property as CarbonImmutable
     *
     * @param string $name
     * @return \Carbon\CarbonImmutable
     */
    public function carbonImmutable(string $name): CarbonImmutable
    {
        $value = $this->get($name);

        if (is_null($value)) throw $this->requiredException($name);

        return $value instanceof CarbonImmutable ? $value : new CarbonImmutable($value);
    }

    /**
     * get property as nullable CarbonImmutable
     *
     * @param string $name
     * @return \Carbon\CarbonImmutable|null
     */
    public function nullableCarbonImmutable(string $name): CarbonImmutable|null
    {
        return $this->makeNullable(fn() => $this->carbonImmutable($name));
    }

    /**
     * get property as Model
     *
     * @param string $name
     * @return \YukataRm\Laravel\Repository\Interfaces\ModelInterface
     */
    public function model(string $name): ModelInterface
    {
        return $this->validated($name, null, fn($value) => is_object($value) && $value instanceof ModelInterface);
    }

    /**
     * get property as nullable Model
     *
     * @param string $name
     * @return \YukataRm\Laravel\Repository\Interfaces\ModelInterface|null
     */
    public function nullableModel(string $name): ModelInterface|null
    {
        return $this->makeNullable(fn() => $this->model($name));
    }

    /**
     * get property as Model Collection
     *
     * @param string $name
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interfaces\ModelInterface>
     */
    public function models(string $name): Collection
    {
        $value = $this->get($name);

        if (is_null($value)) throw $this->requiredException($name);

        if (is_array($value)) $value = collect($value);

        if ($value instanceof EloquentCollection) $value = $value->toBase();

        if (!$value instanceof Collection) throw $this->unexpectedValueTypeException($name, $value, Collection::class);

        $collection = $value->filter(function (mixed $model) {
            return $model instanceof ModelInterface;
        });

        if ($collection->isEmpty()) throw $this->requiredException($name);

        return $collection;
    }

    /**
     * get property as nullable Model Collection
     *
     * @param string $name
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interfaces\ModelInterface>|null
     */
    public function nullableModels(string $name): Collection|null
    {
        return $this->makeNullable(fn() => $this->models($name));
    }

    /**
     * get property as Entity
     *
     * @param string $name
     * @return \YukataRm\Laravel\Repository\Interfaces\EntityInterface
     */
    public function entity(string $name): EntityInterface
    {
        return $this->model($name)->toEntity();
    }

    /**
     * get property as nullable Entity
     *
     * @param string $name
     * @return \YukataRm\Laravel\Repository\Interfaces\EntityInterface|null
     */
    public function nullableEntity(string $name): EntityInterface|null
    {
        return $this->makeNullable(fn() => $this->entity($name));
    }

    /**
     * get property as Entity Collection
     *
     * @param string $name
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interfaces\EntityInterface>
     */
    public function entities(string $name): Collection
    {
        return $this->models($name)->map(function (ModelInterface $model) {
            return $model->toEntity();
        });
    }

    /**
     * get property as nullable Entity Collection
     *
     * @param string $name
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interfaces\EntityInterface>|null
     */
    public function nullableEntities(string $name): Collection|null
    {
        return $this->makeNullable(fn() => $this->entities($name));
    }

    /**
     * whether is trashed
     *
     * @param string $name
     * @return bool
     */
    public function isTrashed(string $name = "deleted_at"): bool
    {
        return !is_null($this->get($name));
    }
}
