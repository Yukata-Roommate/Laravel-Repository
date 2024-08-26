<?php

namespace YukataRm\Laravel\Repository;

use YukataRm\Laravel\Repository\Interface\EntityInterface;
use YukataRm\Laravel\Repository\Interface\ModelInterface;

use UnitEnum;
use Carbon\Carbon;

/**
 * Base Entity
 * 
 * @package YukataRm\Laravel\Repository
 */
abstract class BaseEntity implements EntityInterface
{
    /**
     * Model properties
     * 
     * @var array<string, mixed>
     */
    protected array $properties = [];

    /**
     * constructor
     * 
     * @param \YukataRm\Laravel\Repository\Interface\ModelInterface $model
     */
    public function __construct(ModelInterface $model)
    {
        $this->properties = $model->toArray();

        $this->bindProperties();
    }

    /**
     * bind Model properties
     * 
     * @return void
     */
    abstract protected function bindProperties(): void;

    /**
     * whether property is set
     * 
     * @return bool
     */
    final public function isEmpty(): bool
    {
        return !empty($this->properties);
    }

    /*----------------------------------------*
     * Bind Properties
     *----------------------------------------*/

    /**
     * whether key is set in properties
     * 
     * @param string $key
     * @return bool
     */
    final protected function issetProperty(string $key): bool
    {
        return isset($this->properties[$key]);
    }

    /**
     * get data from properties
     * 
     * @param string $key
     * @return mixed
     */
    final protected function bind(string $key): mixed
    {
        return $this->issetProperty($key) ? $this->properties[$key] : null;
    }

    /**
     * get data as nullable string by key
     * 
     * @param string $key
     * @return string|null
     */
    protected function bindNullableString(string $key): string|null
    {
        $bind = $this->bind($key);

        return is_string($bind) ? strval($bind) : null;
    }

    /**
     * get data as string by key
     * 
     * @param string $key
     * @return string
     */
    protected function bindString(string $key): string
    {
        $bind = $this->bindNullableString($key);

        if (is_null($bind)) throw $this->requiredException($key);

        return $bind;
    }

    /**
     * get data as nullable int by key
     * 
     * @param string $key
     * @return int|null
     */
    protected function bindNullableInt(string $key): int|null
    {
        $bind = $this->bind($key);

        return is_numeric($bind) ? intval($bind) : null;
    }

    /**
     * get data as int by key
     * 
     * @param string $key
     * @return int
     */
    protected function bindInt(string $key): int
    {
        $bind = $this->bindNullableInt($key);

        if (is_null($bind)) throw $this->requiredException($key);

        return $bind;
    }

    /**
     * get data as nullable float by key
     * 
     * @param string $key
     * @return float|null
     */
    protected function bindNullableFloat(string $key): float|null
    {
        $bind = $this->bind($key);

        return is_numeric($bind) ? floatval($bind) : null;
    }

    /**
     * get data as float by key
     * 
     * @param string $key
     * @return float
     */
    protected function bindFloat(string $key): float
    {
        $bind = $this->bindNullableFloat($key);

        if (is_null($bind)) throw $this->requiredException($key);

        return $bind;
    }

    /**
     * get data as nullable bool by key
     * 
     * @param string $key
     * @return bool|null
     */
    protected function bindNullableBool(string $key): bool|null
    {
        $bind = $this->bind($key);

        if (intval($bind) === 1 || intval($bind) === 0) $bind = boolval($bind);

        return is_bool($bind) ? boolval($bind) : null;
    }

    /**
     * get data as bool by key
     * 
     * @param string $key
     * @return bool
     */
    protected function bindBool(string $key): bool
    {
        $bind = $this->bindNullableBool($key);

        if (is_null($bind)) throw $this->requiredException($key);

        return $bind;
    }

    /**
     * get data as nullable array by key
     * 
     * @param string $key
     * @return array|null
     */
    protected function bindNullableArray(string $key): array|null
    {
        $bind = $this->bind($key);

        return is_array($bind) ? $bind : null;
    }

    /**
     * get data as array by key
     * 
     * @param string $key
     * @return array
     */
    protected function bindArray(string $key): array
    {
        $bind = $this->bindNullableArray($key);

        if (is_null($bind)) throw $this->requiredException($key);

        return $bind;
    }

    /**
     * get data as nullable Carbon by key
     * 
     * @param string $key
     * @return \Carbon\Carbon|null
     */
    final protected function bindNullableTimestamp(string $key): Carbon|null
    {
        $bind = $this->bind($key);

        if (is_null($bind)) return null;

        try {
            return new Carbon($bind);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * get data as Carbon by key
     * 
     * @param string $key
     * @return \Carbon\Carbon
     */
    final protected function bindTimestamp(string $key): Carbon
    {
        $bind = $this->bindNullableTimestamp($key);

        if (is_null($bind)) throw $this->requiredException($key);

        return $bind;
    }

    /**
     * get data as nullable UnitEnum by key
     * 
     * @param string $key
     * @return \UnitEnum|null
     */
    final protected function bindNullableEnum(string $key): UnitEnum|null
    {
        $bind = $this->bind($key);

        return $bind instanceof UnitEnum ? $bind : null;
    }

    /**
     * get data as UnitEnum by key
     * 
     * @param string $key
     * @return \UnitEnum
     */
    final protected function bindEnum(string $key): UnitEnum
    {
        $bind = $this->bindNullableEnum($key);

        if (is_null($bind)) throw $this->requiredException($key);

        return $bind;
    }

    /**
     * get data as nullable Entity by key
     * 
     * @param string $key
     * @param string $entityType
     * @return \YukataRm\Laravel\Repository\Interface\EntityInterface|null
     */
    final protected function bindNullableEntity(string $key, string $entityType): EntityInterface|null
    {
        $bind = $this->bind($key);

        return $bind instanceof ModelInterface ? new $entityType($bind) : null;
    }

    /**
     * get data as Entity by key
     * 
     * @param string $key
     * @param string $entityType
     * @return \YukataRm\Laravel\Repository\Interface\EntityInterface
     */
    final protected function bindEntity(string $key, string $entityType): EntityInterface
    {
        $bind = $this->bindNullableEntity($key, $entityType);

        if (is_null($bind)) throw $this->requiredException($key);

        return $bind;
    }

    /**
     * get required exception
     * 
     * @param string $key
     * @return \Throwable
     */
    protected function requiredException(string $key): \Throwable
    {
        return new \RuntimeException("{$key} is required.");
    }
}
