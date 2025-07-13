<?php

namespace YukataRm\Laravel\Repository\Entity;

/**
 * Is Active Entity Trait
 *
 * @package YukataRm\Laravel\Repository\Entity
 *
 * @method bool bool(string $key)
 */
trait IsActive
{
    /**
     * is_active
     *
     * @var bool
     */
    public bool $isActive;

    /**
     * set is_active
     *
     * @return void
     */
    protected function setIsActive(): void
    {
        $this->isActive = $this->bool("is_active");
    }
}
