<?php

namespace YukataRm\Laravel\Repository\Entity;

use Carbon\Carbon;

/**
 * Soft Deletes Entity Trait
 *
 * @package YukataRm\Laravel\Repository\Entity
 *
 * @method \Carbon\Carbon|null nullableCarbon(string $key)
 */
trait SoftDeletes
{
    /**
     * deleted_at
     *
     * @var \Carbon\Carbon|null
     */
    public Carbon|null $deletedAt;

    /**
     * whether is soft deleted
     *
     * @var bool
     */
    public bool $isDeleted;

    /**
     * set deleted_at
     *
     * @return void
     */
    protected function setSoftDeletes(): void
    {
        $this->deletedAt = $this->nullableCarbon("deleted_at");

        $this->isDeleted = !is_null($this->deletedAt);
    }
}
