<?php

namespace YukataRm\Laravel\Repository;

use YukataRm\Laravel\Repository\Interface\ModelInterface;

use YukataRm\StaticProxy\StaticProxy;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * Base Repository
 * 
 * @package YukataRm\Laravel\Repository
 * 
 * @method \YukataRm\Laravel\Repository\Interface\ModelInterface first(int $id, array $columns = ["*"])
 * @method \Illuminate\Database\Eloquent\Collection<\YukataRm\Laravel\Repository\Interface\ModelInterface> get(array $columns = ["*"])
 * 
 * @method \Illuminate\Contracts\Pagination\LengthAwarePaginator paginate(int $perPage = null, array $columns = ["*"], string $pageName = "page", int|null $page = null)
 * @method bool exists()
 * @method bool doesntExist()
 * @method int count(string $columns = "*")
 * @method int min(string $column)
 * @method int max(string $column)
 * @method int sum(string $column)
 * @method int avg(string $column)
 * 
 * @method static select(array $columns = ["*"])
 * @method static addSelect(array|string $column)
 * 
 * @method static join(string $table, string $first, string $operator = null, string $second = null, string $type = "inner", bool $where = false)
 * @method static leftJoin(string $table, string $first, string $operator = null, string $second = null)
 * @method static rightJoin(string $table, string $first, string $operator = null, string $second = null)
 * @method static crossJoin(string $table, string $first = null, string $operator = null, string $second = null)
 * 
 * @method static where(\Closure|string|array $column, mixed $operator = null, mixed $value = null, string $boolean = "and")
 * @method static orWhere(\Closure|string|array $column, mixed $operator = null, mixed $value = null)
 * @method static whereNot(\Closure|string|array $column, mixed $operator = null, mixed $value = null, string $boolean = "and")
 * @method static orWhereNot(\Closure|string|array $column, mixed $operator = null, mixed $value = null)
 * @method static whereAny(array $columns, mixed $operator, mixed $value = null, string $boolean = "and")
 * @method static orWhereAny(array $columns, mixed $operator, mixed $value = null)
 * @method static whereAll(array $columns, mixed $operator, mixed $value = null, string $boolean = "and")
 * @method static orWhereAll(array $columns, mixed $operator, mixed $value = null)
 * 
 * @method static whereJsonContains(string $column, mixed $value, string $boolean = "and")
 * @method static orWhereJsonContains(string $column, mixed $value)
 * @method static whereJsonDoesntContain(string $column, mixed $value, string $boolean = "and")
 * @method static orWhereJsonDoesntContain(string $column, mixed $value)
 * @method static whereJsonContainsKey(string $column, string $key, string $boolean = "and")
 * @method static orWhereJsonContainsKey(string $column, string $key)
 * @method static whereJsonDoesntContainKey(string $column, string $key, string $boolean = "and")
 * @method static orWhereJsonDoesntContainKey(string $column, string $key)
 * @method static whereJsonLength(string $column, mixed $operator, mixed $value = null, string $boolean = "and")
 * @method static orWhereJsonLength(string $column, mixed $operator, mixed $value = null)
 * @method static whereBetween(string $column, array $values, string $boolean = "and", bool $not = false)
 * @method static orWhereBetween(string $column, array $values)
 * @method static whereNotBetween(string $column, array $values, string $boolean = "and")
 * @method static orWhereNotBetween(string $column, array $values)
 * @method static whereBetweenColumns(array $columns, string $boolean = "and", bool $not = false)
 * @method static orWhereBetweenColumns(array $columns)
 * @method static whereNotBetweenColumns(array $columns, string $boolean = "and")
 * @method static orWhereNotBetweenColumns(array $columns)
 * @method static whereIn(string $column, mixed $values, string $boolean = "and", bool $not = false)
 * @method static orWhereIn(string $column, mixed $values)
 * @method static whereNotIn(string $column, mixed $values, string $boolean = "and")
 * @method static orWhereNotIn(string $column, mixed $values)
 * @method static whereNull(string $column, string $boolean = "and", bool $not = false)
 * @method static orWhereNull(string $column)
 * @method static whereNotNull(string $column, string $boolean = "and")
 * @method static orWhereNotNull(string $column)
 * @method static whereDate(string $column, string $operator, mixed $value = null, string $boolean = "and")
 * @method static orWhereDate(string $column, string $operator, mixed $value = null)
 * @method static whereTime(string $column, string $operator, mixed $value = null, string $boolean = "and")
 * @method static orWhereTime(string $column, string $operator, mixed $value = null)
 * @method static whereDay(string $column, string $operator, mixed $value = null, string $boolean = "and")
 * @method static orWhereDay(string $column, string $operator, mixed $value = null)
 * @method static whereMonth(string $column, string $operator, mixed $value = null, string $boolean = "and")
 * @method static orWhereMonth(string $column, string $operator, mixed $value = null)
 * @method static whereYear(string $column, string $operator, mixed $value = null, string $boolean = "and")
 * @method static orWhereYear(string $column, string $operator, mixed $value = null)
 * @method static whereColumn(string|array $first, mixed $operator = null, mixed $second = null, string $boolean = "and")
 * @method static orWhereColumn(string|array $first, mixed $operator = null, mixed $second = null)
 * 
 * @method static orderBy(string $column, string $direction = "asc")
 * @method static latest(string $column = "created_at")
 * @method static oldest(string $column = "created_at")
 * @method static inRandomOrder(string $seed = "")
 * @method static groupBy(array|string $groups)
 * @method static having(string $column, string $operator = null, mixed $value = null, string $boolean = "and")
 * @method static orHaving(string $column, string $operator = null, mixed $value = null)
 * @method static havingNull(string $column, string $boolean = "and", bool $not = false)
 * @method static orHavingNull(string $column)
 * @method static havingNotNull(string $column, string $boolean = "and")
 * @method static orHavingNotNull(string $column)
 * @method static havingBetween(string $column, array $values, string $boolean = "and", bool $not = false)

 * @method static offset(int $value)
 * @method static limit(int $value)
 * @method static forPage(int $page, int $perPage = 15)
 * 
 * @method static selectRaw(string $expression, array $bindings = [])
 * @method static whereRaw(string $sql, array $bindings = [], string $boolean = "and")
 * @method static orWhereRaw(string $sql, array $bindings = [])
 * @method static havingRaw(string $sql, array $bindings = [], string $boolean = "and")
 * @method static orHavingRaw(string $sql, array $bindings = [])
 * @method static orderByRaw(string $sql, array $bindings = [])
 * @method static groupByRaw(string $sql, array $bindings = [])
 * 
 * @see \Illuminate\Database\Eloquent\Builder
 * @see \Illuminate\Database\Query\Builder
 */
abstract class BaseRepository extends StaticProxy
{
    /*----------------------------------------*
     * Static Proxy
     *----------------------------------------*/

    /** 
     * get class name calling dynamic method
     * 
     * @return string 
     */
    protected static function getCallableClassName(): string
    {
        return static::class;
    }

    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Builder
     * 
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected Builder $builder;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->resetQuery();
    }

    /**
     * reset Builder
     * 
     * @return void
     */
    protected function resetQuery(): void
    {
        $this->builder = $this->model()->newQuery();
    }

    /**
     * get Model
     * 
     * @return \YukataRm\Laravel\Repository\Interface\ModelInterface
     */
    abstract protected function model(): ModelInterface;

    /*----------------------------------------*
     * Collection
     *----------------------------------------*/

    /**
     * convert Model to Entity in Collection
     * 
     * @param \Illuminate\Database\Eloquent\Collection<\YukataRm\Laravel\Repository\Interface\ModelInterface> | \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interface\ModelInterface> $collection
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interface\EntityInterface>
     */
    protected function toEntities(EloquentCollection|SupportCollection $collection): SupportCollection
    {
        return $collection->map(function (ModelInterface $model) {
            return $model->toEntity();
        });
    }

    /**
     * convert Eloquent Collection to Support Collection
     * 
     * @param \Illuminate\Database\Eloquent\Collection<\YukataRm\Laravel\Repository\Interface\ModelInterface> $collection
     * @return \Illuminate\Support\Collection<\YukataRm\Laravel\Repository\Interface\ModelInterface>
     */
    protected function toSupportCollection(EloquentCollection $collection): SupportCollection
    {
        return $collection->toBase();
    }

    /*----------------------------------------*
     * Magic Method
     *----------------------------------------*/

    /**
     * call Builder method
     * 
     * @param string $name
     * @param array<mixed> $arguments
     * @return static
     */
    public function __call(string $name, array $arguments): static
    {
        if (!method_exists($this->builder, $name)) throw new \BadMethodCallException("call to undefined method {$name}");

        $this->builder = $this->builder->$name(...$arguments);

        return $this;
    }
}
