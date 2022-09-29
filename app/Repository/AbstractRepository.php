<?php

namespace App\Repository;

use App\Repository\Interfaces\AbstractRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractRepository implements AbstractRepositoryInterface
{

    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected function resolveModel(): mixed
    {
        return app($this->model);
    }

    public function all():Collection
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * @param int $id
     * @return Model
     */
    public function find(int $id):Model
    {
        return $this->model->find($id);
    }

    /**
     * @param array $attributes
     * @return Collection
     */
    public function findBy(array $attributes):Collection
    {
        return $this->model->where($attributes)->get();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes):Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return Model
     */
    public function update(int $id, array $attributes): Model
    {
        $model = $this->find($id);
        $model->fill($attributes);
        $model->save();
        return $this->find($id);
    }

    public function delete(int $id): bool
    {
        $model = $this->model->find($id);
        if($model != null){
            $model->delete();
            return true;
        }
        return false;
    }

}
