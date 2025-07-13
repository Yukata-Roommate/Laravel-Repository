<?php

namespace YukataRm\Laravel\Repository\Entity;

/**
 * Id Entity Trait
 *
 * @package YukataRm\Laravel\Repository\Entity
 *
 * @method int int(string $key)
 */
trait Id
{
    /**
     * id
     *
     * @var int
     */
    public int $id;

    /**
     * set id
     *
     * @return void
     */
    protected function setId(): void
    {
        $this->id = $this->int("id");
    }
}
