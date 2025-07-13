<?php

namespace YukataRm\Laravel\Repository\Entity;

use Carbon\Carbon;

/**
 * Updated At Entity Trait
 *
 * @package YukataRm\Laravel\Repository\Entity
 *
 * @method \Carbon\Carbon carbon(string $key)
 */
trait UpdatedAt
{
    /**
     * updated_at
     *
     * @var \Carbon\Carbon
     */
    public Carbon $updatedAt;

    /**
     * set updated_at
     *
     * @return void
     */
    protected function setUpdatedAt(): void
    {
        $this->updatedAt = $this->carbon("updated_at");
    }
}
