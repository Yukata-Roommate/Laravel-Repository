<?php

namespace YukataRm\Laravel\Repository\Entity;

use Carbon\Carbon;

/**
 * Created At Entity Trait
 *
 * @package YukataRm\Laravel\Repository\Entity
 *
 * @method \Carbon\Carbon carbon(string $key)
 */
trait CreatedAt
{
    /**
     * created_at
     *
     * @var \Carbon\Carbon
     */
    public Carbon $createdAt;

    /**
     * set created_at
     *
     * @return void
     */
    protected function setCreatedAt(): void
    {
        $this->createdAt = $this->carbon("created_at");
    }
}
