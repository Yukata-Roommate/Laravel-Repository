<?php

namespace YukataRm\Laravel\Repository\Interface;

/**
 * Entity Interface
 * 
 * @package YukataRm\Laravel\Repository\Interface
 */
interface EntityInterface
{
    /*----------------------------------------*
     * Isset
     *----------------------------------------*/

    /**
     * whether the property is set
     * 
     * @return bool
     */
    public function issetProperty(): bool;
}
