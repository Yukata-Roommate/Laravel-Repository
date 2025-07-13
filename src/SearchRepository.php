<?php

namespace YukataRm\Laravel\Repository;

use YukataRm\Laravel\Repository\StandardRepository;

use Illuminate\Support\Collection;

/**
 * Search Repository
 *
 * @package YukataRm\Laravel\Repository
 */
abstract class SearchRepository extends StandardRepository
{
    /*----------------------------------------*
     * Search
     *----------------------------------------*/

    /**
     * search query
     *
     * @param array<string, mixed> $search
     * @return static
     */
    abstract protected function searchQuery(array $search): static;

    /**
     * search raw records
     *
     * @param array<string, mixed> $search
     * @param int|null $limit
     * @param int|null $offset
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interfaces\ModelInterface>
     */
    protected function searchRawRecords(array $search, int|null $limit = null, int|null $offset = null): Collection
    {
        $query = $this->searchQuery($search);

        if (!is_null($limit)) $query->limit($limit);

        if (!is_null($offset)) $query->offset($offset);

        return $query->get();
    }

    /**
     * search records
     *
     * @param array<string, mixed> $search
     * @param int|null $limit
     * @param int|null $offset
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interfaces\EntityInterface>
     */
    protected function searchRecords(array $search, int|null $limit = null, int|null $offset = null): Collection
    {
        $models = $this->searchRawRecords($search, $limit, $offset);

        return $this->toEntities($models);
    }

    /**
     * search count
     *
     * @param array<string, mixed> $search
     * @return int
     */
    public function searchCount(array $search): int
    {
        return $this->searchQuery($search)->count();
    }
}
