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
     * @param \YukataRm\Laravel\Repository\Interface\ModelInterface|null $model
     * @return void
     */
    function __construct(ModelInterface|null $model)
    {
        if (is_null($model)) return;

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
     * whether the property is set
     * 
     * @return bool
     */
    final public function issetProperty(): bool
    {
        return !empty($this->properties);
    }

    /*----------------------------------------*
     * Bind Properties
     *----------------------------------------*/

    /**
     * whether the key is set in properties
     * 
     * @param string $key
     * @return bool
     */
    final protected function issetKey(string $key): bool
    {
        return array_key_exists($key, $this->properties);
    }

    /**
     * get value from properties
     * 
     * @param string $key
     * @return mixed
     */
    final protected function value(string $key): mixed
    {
        return $this->issetKey($key) ? $this->properties[$key] : null;
    }

    /**
     * get value as string from properties
     * if the key is not set or the value is null, return default
     * 
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    final protected function stringValue(string $key, string|null $default = null): string|null
    {
        $value = $this->value($key);

        return is_string($value) ? $value : $default;
    }

    /**
     * get value as int from properties
     * if the key is not set or the value is null, return default
     * 
     * @param string $key
     * @param int|null $default
     * @return int|null
     */
    final protected function intValue(string $key, int|null $default = null): int|null
    {
        $value = $this->value($key);

        return is_numeric($value) ? intval($value) : $default;
    }

    /**
     * get value as float from properties
     * if the key is not set or the value is null, return default
     * 
     * @param string $key
     * @param float|null $default
     * @return float|null
     */
    final protected function floatValue(string $key, float|null $default = null): float|null
    {
        $value = $this->value($key);

        return is_numeric($value) ? floatval($value) : $default;
    }

    /**
     * get value as bool from properties
     * if the key is not set or the value is null, return default
     * 
     * @param string $key
     * @param bool|null $default
     * @return bool|null
     */
    final protected function boolValue(string $key, bool|null $default = null): bool|null
    {
        $value = $this->value($key);

        if (intval($value) === 1 || intval($value) === 0) $value = boolval($value);

        return is_bool($value) ? $value : $default;
    }

    /**
     * get value as array from properties
     * if the key is not set or the value is null, return default
     * 
     * @param string $key
     * @param array|null $default
     * @return array|null
     */
    final protected function arrayValue(string $key, array|null $default = null): array|null
    {
        $value = $this->value($key);

        return is_array($value) ? $value : $default;
    }

    /**
     * get value as Carbon instance from properties
     * if the key is not set or the value is null, return default
     * 
     * @param string $key
     * @param \Carbon\Carbon|null $default
     * @return \Carbon\Carbon|null
     */
    final protected function timestampValue(string $key, Carbon|null $default = null): Carbon|null
    {
        $value = $this->value($key);

        if (is_null($value)) return $default;

        try {
            return new Carbon($value);
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * get value as UnitEnum instance from properties
     * if the key is not set or the value is null, return default
     * 
     * @param string $key
     * @param \UnitEnum|null $default
     * @return \UnitEnum|null
     */
    final protected function unitEnumValue(string $key, UnitEnum|null $default = null): UnitEnum|null
    {
        $value = $this->value($key);

        return $value instanceof UnitEnum ? $value : $default;
    }

    /**
     * get value as entityType instance from properties
     * if the key is not set or the value is not Model, return empty entityType instance
     * 
     * @param string $key
     * @param string $entityType
     * @return \YukataRm\Laravel\Repository\Interface\EntityInterface
     */
    final protected function entityValue(string $key, string $entityType): EntityInterface
    {
        $value = $this->value($key);

        return $value instanceof ModelInterface ? new $entityType($value) : new $entityType(null);
    }
}
