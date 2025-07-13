<?php

namespace YukataRm\Laravel\Repository\Entity;

use YukataRm\Laravel\Repository\Entity\CreatedAt;
use YukataRm\Laravel\Repository\Entity\UpdatedAt;

/**
 * Timestamps Entity Trait
 *
 * @package YukataRm\Laravel\Repository\Entity
 */
trait Timestamps
{
    use CreatedAt, UpdatedAt;

    /**
     * set timestamps
     *
     * @return void
     */
    protected function setTimestamps(): void
    {
        $this->setCreatedAt();
        $this->setUpdatedAt();
    }
}
