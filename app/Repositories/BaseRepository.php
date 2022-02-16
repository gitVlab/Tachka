<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    /**
     * @param Model $model
     */
    public function __construct(
        protected Model $model
    ) {}

    /**
     * Save model instance in database.
     *
     * @param Model $instance
     *
     * @return bool Operation success.
     */
    public function save(Model $instance): bool
    {
        return DB::transaction(static fn () => $instance->save());
    }

    /**
     * Get all records.
     *
     * @return EloquentCollection
     */
    public function getAll(): EloquentCollection
    {
        $qb = $this->model->newQuery();

        return DB::transaction(static fn() => $qb->get());
    }

    /**
     * @param string $column
     * @param bool   $unique
     *
     * @return Collection
     */
    public function distinctColumn(string $column, bool $unique = true): Collection
    {
        $qb = $this->model->newModelQuery();

        if ($unique) {
            $qb->groupBy($column);
        }

        return DB::transaction(static fn () => $qb->pluck($column));
    }

    /**
     * @param int   $id
     * @param array $props
     *
     * @return int
     */
    public function updateOneById(int $id, array $props): int
    {
        $qb = $this->model->newQuery();

        $qb
            ->where('id', $id)
        ;

        return DB::transaction(static fn() => $qb->update($props));
    }

    /**
     * @param Model $instance
     *
     * @return bool
     */
    public function delete(Model $instance): bool
    {
        return DB::transaction(static fn() => $instance->delete());
    }

    /**
     * Get a record by id.
     *
     * @param int|string $id   Record id.
     * @param array      $with Related models.
     *
     * @return mixed|null
     */
    public function getById(int|string $id, array $with = []): mixed
    {
        $qb = $this->model->newQuery();

        if ([] !== $with) {
            $qb->with($with);
        }

        return DB::transaction(static fn() => $qb->find($id));
    }

    /**
     * Get a record by specific attribute.
     *
     * @param string     $column
     * @param string     $operator
     * @param mixed|null $value
     * @param array      $with Related models.
     *
     * @return Model|null record or null, if not found.
     */
    public function getByAttribute(
        string $column = 'id',
        string $operator = '=',
        mixed $value = null,
        array $with = []
    ): ?Model
    {
        $query = $this->model->newQuery();

        $query->where($column, $operator, $value);

        if ([] !== $with) {
            $query->with($with);
        }

        return DB::transaction(static fn() => $query->first());
    }

    /**
     * Get ordered records by specific attribute.
     *
     * @param string $column
     * @param string $operator
     * @param mixed|null $value
     * @param string $order
     * @param string $direction
     * @param array $with
     *
     * @return Enumerable|null
     */
    public function getManyByAttribute(
        string $column = 'id',
        string $operator = '=',
        mixed  $value = null,
        string $order = 'id',
        string $direction = 'desc',
        array  $with = []
    ): ?Enumerable
    {
        $query = $this->model->newQuery();
        $query->where($column, $operator, $value)->orderBy($order, $direction);

        if (! empty($with)) {
            $query->with($with);
        }

        return DB::transaction(function () use ($query) {
            return $query->get();
        });
    }

    /**
     * @param Collection   $params
     * @param Builder|null $qb
     *
     * @return Collection
     */
    public function getMany(Collection $params, Builder $qb = null): Enumerable
    {
        if (null === $qb) {
            $qb = $this->model->newQuery();
        }

        if (null !== ($search = $params->get('search'))) {
            $this->applySearch($qb, Arr::get($search, 'value'), Arr::get($search, 'fields'));
        }

        $this->applyOrders($qb, $params->get('sorting', []));

        return $this->getCertainPiece($params->get('start'), $params->get('length'), $qb);
    }

    /**
     * @param int          $offset
     * @param int          $limit
     * @param Builder|null $qb
     *
     * @return Collection
     */
    public function getCertainPiece(int $offset, int $limit, Builder $qb = null): Enumerable
    {
        if (null === $qb) {
            $qb = $this->model->newQuery();
        }

        return DB::transaction(static fn() => new Collection([
            'total'      => $qb->count(),
            'collection' => $qb->skip($offset)->take($limit)->get(),
        ]));
    }

    /**
     * @param Builder $qb
     * @param string  $search
     * @param array   $fields
     *
     * @return Builder
     */
    protected function applySearch(Builder $qb, string $search, array $fields): Builder
    {
        $qb->where(function (Builder $qb) use ($search, $fields) {
            foreach ($fields as $field) {
                $qb->orWhere($field, 'like', "%$search%");
            }
        });

        return $qb;
    }

    /**
     * @param Builder $qb
     * @param array   $orders
     *
     * @return Builder
     */
    protected function applyOrders(Builder $qb, array $orders): Builder
    {
        if ([] === $orders) {
            $this->applyOrder($qb);

            return $qb;
        }

        foreach ($orders as $order) {
            $this->applyOrder($qb, Arr::get($order, 'order_by'), Arr::get($order, 'order'));
        }

        return $qb;
    }

    /**
     * @param Builder $qb
     * @param string  $orderBy
     * @param string  $order
     *
     * @return Builder
     */
    protected function applyOrder(Builder $qb, string $orderBy = 'id', string $order = 'desc'): Builder
    {
        $qb->orderBy($orderBy, $order);

        return $qb;
    }
}
