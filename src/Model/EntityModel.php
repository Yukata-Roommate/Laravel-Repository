<?php

namespace YukataRm\Laravel\Repository\Model;

use YukataRm\Laravel\Model\BaseModel;

use YukataRm\Laravel\Repository\Interfaces\ModelInterface;
use YukataRm\Laravel\Repository\Interfaces\EntityInterface;

/**
 * Entity Model
 *
 * @package YukataRm\Laravel\Repository\Model
 */
abstract class EntityModel extends BaseModel implements ModelInterface
{
    /**
     * convert to Entity
     *
     * @return \YukataRm\Laravel\Repository\Interfaces\EntityInterface
     */
    abstract public function toEntity(): EntityInterface;
}
