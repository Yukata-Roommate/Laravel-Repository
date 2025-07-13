<?php

namespace YukataRm\Laravel\Repository\Model;

use YukataRm\Laravel\Model\AuthenticatableModel;

use YukataRm\Laravel\Repository\Interfaces\ModelInterface;
use YukataRm\Laravel\Repository\Interfaces\EntityInterface;

/**
 * Authenticatable Entity Model
 *
 * @package YukataRm\Laravel\Repository\Model
 */
abstract class AuthenticatableEntityModel extends AuthenticatableModel implements ModelInterface
{
    /**
     * convert to Entity
     *
     * @return \YukataRm\Laravel\Repository\Interfaces\EntityInterface
     */
    abstract public function toEntity(): EntityInterface;
}
