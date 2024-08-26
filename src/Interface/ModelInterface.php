<?php

namespace YukataRm\Laravel\Repository\Interface;

use YukataRm\Laravel\Repository\Interface\EntityInterface;

/**
 * Model Interface
 * 
 * @package YukataRm\Laravel\Repository\Interface
 */
interface ModelInterface
{
    /**
     * convert to Entity
     * 
     * @return \YukataRm\Laravel\Repository\Interface\EntityInterface
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
}
