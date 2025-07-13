<?php

namespace YukataRm\Laravel\Repository\Interfaces;

use YukataRm\Laravel\Repository\Interfaces\EntityInterface;

/**
 * Model Interface
 *
 * @package YukataRm\Laravel\Repository\Interfaces
 */
interface ModelInterface
{
    /**
     * convert to Entity
     *
     * @return \YukataRm\Laravel\Repository\Interfaces\EntityInterface
     */
    public function toEntity(): EntityInterface;

    /*----------------------------------------*
     * Default
     *----------------------------------------*/

    /**
     * get Eloquent Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery();

    /**
     * convert properties to array
     *
     * @return array<string, mixed>
     */
    public function toArray();

    /**
     * get primary key
     *
     * @return string|array<string>
     */
    public function getKeyName();
}
