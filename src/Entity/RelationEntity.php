<?php

namespace YukataRm\Laravel\Repository\Entity;

use YukataRm\Laravel\Repository\Interfaces\EntityInterface;

use YukataRm\Laravel\Repository\Entity\BaseEntity;

use Illuminate\Support\Collection;

/**
 * Relation Entity
 *
 * @package YukataRm\Laravel\Repository\Entity
 */
abstract class RelationEntity extends BaseEntity implements EntityInterface
{
    /**
     * whether data flushed
     *
     * @var bool
     */
    protected bool $isFlushed = false;

    /**
     * get relations
     *
     * @param string $relation
     * @return \Illuminate\Support\Collection
     */
    protected function relations(string $relation): Collection
    {
        $relations = $this->nullableEntities($relation);

        return is_null($relations) ? collect() : $relations;
    }

    /**
     * get pluck of relations
     *
     * @param string $relation
     * @param string $column
     * @return \Illuminate\Support\Collection<mixed>
     */
    protected function relationIds(string $relation, string $column = "id"): Collection
    {
        $relations = $this->nullableEntities($relation);

        return is_null($relations) ? collect() : $relations->pluck($column);
    }

    /**
     * get count of relations
     *
     * @param string $relation
     * @return int
     */
    protected function relationCount(string $relation): int
    {
        $relations = $this->nullableModels($relation);

        return is_null($relations) ? 0 : $relations->count();
    }
}
