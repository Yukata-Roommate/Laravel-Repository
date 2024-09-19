<?php

namespace YukataRm\Laravel\Repository;

use YukataRm\Laravel\Repository\Interface\EntityInterface;
use YukataRm\Laravel\Repository\Interface\ModelInterface;

use YukataRm\Entity\ObjectEntity;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Carbon\Carbon;

/**
 * Base Entity
 * 
 * @package YukataRm\Laravel\Repository
 */
abstract class BaseEntity extends ObjectEntity implements EntityInterface
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
     * @param \YukataRm\Laravel\Repository\Interface\ModelInterface $model
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
     * get property as nullable enum
     * 
     * @param string $name
     * @param string $enumClass
     * @return \UnitEnum|null
     */
    #[\Override]
    public function nullableEnum(string $name, string $enumClass): \UnitEnum|null
    {
        $property = $this->get($name);

        return enum_exists($enumClass) && $property::class === $enumClass ? $property : null;
    }

    /**
     * get property as nullable Carbon
     * 
     * @param string $name
     * @return \Carbon\Carbon|null
     */
    public function nullableTimestamp(string $name): Carbon|null
    {
        $property = $this->get($name);

        if (is_null($property)) return null;

        try {
            return new Carbon($property);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * get property as Carbon
     * 
     * @param string $name
     * @return \Carbon\Carbon
     */
    public function timestamp(string $name): Carbon
    {
        $property = $this->nullableTimestamp($name);

        if (is_null($property)) $this->throwRequiredException($name);

        return $property;
    }

    /**
     * get property as nullable Model
     * 
     * @param string $name
     * @return \YukataRm\Laravel\Repository\Interface\ModelInterface|null
     */
    public function nullableModel(string $name): ModelInterface|null
    {
        $property = $this->get($name);

        return $property instanceof ModelInterface ? $property : null;
    }

    /**
     * get property as Model
     * 
     * @param string $name
     * @return \YukataRm\Laravel\Repository\Interface\ModelInterface
     */
    public function model(string $name): ModelInterface
    {
        $property = $this->nullableModel($name);

        if (is_null($property)) $this->throwRequiredException($name);

        return $property;
    }

    /**
     * get property as nullable Model Collection
     * 
     * @param string $name
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interface\ModelInterface>|null
     */
    public function nullableModels(string $name): Collection|null
    {
        $property = $this->get($name);

        if (is_array($property)) $property = collect($property);

        if ($property instanceof EloquentCollection) $property = $property->toBase();

        if (!$property instanceof Collection) return null;

        $collection = $property->filter(function (mixed $model) {
            return $model instanceof ModelInterface;
        });

        return $collection->isEmpty() ? null : $collection;
    }

    /**
     * get property as Model Collection
     * 
     * @param string $name
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interface\ModelInterface>
     */
    public function models(string $name): Collection
    {
        $property = $this->nullableModels($name);

        if (is_null($property)) $this->throwRequiredException($name);

        return $property;
    }

    /**
     * get property as nullable Entity
     * 
     * @param string $name
     * @return \YukataRm\Laravel\Repository\Interface\EntityInterface|null
     */
    public function nullableEntity(string $name): EntityInterface|null
    {
        $property = $this->nullableModel($name);

        return is_null($property) ? null : $property->toEntity();
    }

    /**
     * get property as Entity
     * 
     * @param string $name
     * @return \YukataRm\Laravel\Repository\Interface\EntityInterface
     */
    public function entity(string $name): EntityInterface
    {
        return $this->model($name)->toEntity();
    }

    /**
     * get property as nullable Entity Collection
     * 
     * @param string $name
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interface\EntityInterface>|null
     */
    public function nullableEntities(string $name): Collection|null
    {
        $property = $this->nullableModels($name);

        if (is_null($property)) return null;

        return $property->map(function (ModelInterface $model) {
            return $model->toEntity();
        });
    }

    /**
     * get property as Entity Collection
     * 
     * @param string $name
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interface\EntityInterface>
     */
    public function entities(string $name): Collection
    {
        return $this->models($name)->map(function (ModelInterface $model) {
            return $model->toEntity();
        });
    }
}
