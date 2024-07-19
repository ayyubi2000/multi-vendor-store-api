<?php

namespace App\Repositories;

use App\Enum\Pagination;
use App\Interfaces\IBaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IBaseRepository
{
    protected Model $modelClass;

    public function __construct(Model $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    protected function query(): Builder|Model
    {
        $query = $this->getBaseModel()->query();

        return $query->orderByDesc('id');
    }

    protected function getBaseModel(): Model
    {
        return $this->modelClass;
    }

    public function paginatedList($data = [], array|string|null $with = null): LengthAwarePaginator
    {
        $query = $this->query();
        if (method_exists($this->getBaseModel(), 'scopeFilter')) {
            $query->filter($data);
        }

        if (! is_null($with)) {
            $query->with($with);
        }

        return $query->paginate(Pagination::PerPage);
    }

    public function getCollection($data = [], array|string|null $with = null): Collection
    {
        $query = $this->query();
        if (method_exists($this->getBaseModel(), 'scopeFilter')) {
            $query->filter($data);
        }

        if (! is_null($with)) {
            $query->with($with);
        }

        return $query->get();
    }

    public function create($data): array|Collection|Builder|Model|null
    {
        $model = $this->getBaseModel();
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function update($data, $id): Model|array|Collection|Builder|null
    {
        $model = $this->findById($id);
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function findById($id, $relations = []): Model|array|Collection|Builder|null
    {
        if (! empty($relations)) {
            return $this->query()->with($relations)->findOrFail($id);
        }

        return $this->query()->findOrFail($id);
    }

    public function delete($id): array|Builder|Collection|Model
    {
        $model = $this->findById($id);
        $model->delete();

        return $model;
    }
}
