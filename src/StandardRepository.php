<?php

namespace YukataRm\Laravel\Repository;

use YukataRm\Laravel\Repository\BaseRepository;

use YukataRm\Laravel\Repository\Interfaces\ModelInterface;
use YukataRm\Laravel\Repository\Interfaces\EntityInterface;

use Illuminate\Support\Collection;

/**
 * Standard Repository
 *
 * @package YukataRm\Laravel\Repository
 */
abstract class StandardRepository extends BaseRepository
{
    /*----------------------------------------*
     * Common
     *----------------------------------------*/

    /**
     * common query
     *
     * @return static
     */
    abstract protected function commonQuery(): static;

    /**
     * get all records
     *
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interfaces\EntityInterface>
     */
    protected function allRecords(): Collection
    {
        $models = $this->commonQuery()->get();

        return $this->toEntities($models);
    }

    /**
     * find raw record by primary key
     *
     * @param int|string|array $primaryKey
     * @return \YukataRm\Laravel\Repository\Interfaces\ModelInterface|null
     */
    protected function findRecordRawByPrimaryKey(int|string|array $primaryKey): ModelInterface|null
    {
        return $this
            ->commonQuery()
            ->where($this->model()->getKeyName(), $primaryKey)
            ->first();
    }

    /**
     * find record by primary key
     *
     * @param int|string|array $primaryKey
     * @return \YukataRm\Laravel\Repository\Interfaces\EntityInterface|null
     */
    protected function findRecordByPrimaryKey(int|string|array $primaryKey): EntityInterface|null
    {
        $model = $this->findRecordRawByPrimaryKey($primaryKey);

        return is_null($model) ? null : $model->toEntity();
    }
}
