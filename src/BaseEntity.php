<?php

namespace YukataRm\Laravel\Repository;

use YukataRm\Laravel\Repository\Interface\EntityInterface;
use YukataRm\Laravel\Repository\Interface\ModelInterface;

use YukataRm\Entity\ObjectEntity;

use Carbon\Carbon;

/**
 * Base Entity
 * 
 * @package YukataRm\Laravel\Repository
 */
abstract class BaseEntity extends ObjectEntity implements EntityInterface
{
    /**
     * constructor
     * 
     * @param \YukataRm\Laravel\Repository\Interface\ModelInterface $model
     */
    public function __construct(ModelInterface $model)
    {
        $this->setData($model);

        $this->bind();

        $this->flush();
    }

    /**
     * bind Model properties
     * 
     * @return void
     */
    abstract protected function bind(): void;

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

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
     * get property as nullable Entity
     * 
     * @param string $name
     * @param string $entityType
     * @return \YukataRm\Laravel\Repository\Interface\EntityInterface|null
     */
    public function nullableEntity(string $name, string $entityType): EntityInterface|null
    {
        $property = $this->get($name);

        return $property instanceof ModelInterface ? new $entityType($property) : null;
    }

    /**
     * get property as Entity
     * 
     * @param string $name
     * @param string $entityType
     * @return \YukataRm\Laravel\Repository\Interface\EntityInterface
     */
    public function entity(string $name, string $entityType): EntityInterface
    {
        $property = $this->nullableEntity($name, $entityType);

        if (is_null($property)) $this->throwRequiredException($name);

        return $property;
    }
}
