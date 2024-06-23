<?php

namespace App\Repositories;

use App\Enum\Pagination;
use App\Interfaces\IBaseRepository;
use App\Models\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class BaseRepository implements IBaseRepository
{
    protected BaseModel $modelClass;

    public function __construct(BaseModel $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * @throws Throwable
     */
    protected function query(): Builder|BaseModel
    {
        /** @var BaseModel $class */
        $query = $this->getBaseModel()->query();

        if (! is_null(auth()->user()) && auth()->user()->museum_id && method_exists($this->getBaseModel(), 'scopeRole')) {
            $query->role(auth()->user());
        }

        return $query->orderByDesc('id');
    }

    /**
     * @throws Throwable
     */
    protected function getBaseModel(): BaseModel
    {
        return $this->modelClass;
    }

    /**
     * @throws Throwable
     */
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

    public function getAllList($data = [], array|string|null $with = null): Collection
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

    /**
     * @return BaseModel|BaseModel[]|Builder|Builder[]|Collection|null
     *
     * @throws Throwable
     */
    public function create($data): array|Collection|Builder|BaseModel|null
    {
        $model = $this->getBaseModel();
        foreach ($data as $item => $value) {
            if (! in_array($item, $model->translatable)) {
                $model->{$item} = $value;

                continue;
            }
            if (is_array($value)) {
                foreach ($value as $name => $itemValue) {
                    app()->setLocale($name);
                    $model->{$item} = $itemValue;
                }
            } else {
                $model->{$item} = $value;
            }
        }
        $model->save();

        return $model;
    }

    /**
     * @return BaseModel|BaseModel[]|Builder|Builder[]|Collection|null
     *
     * @throws Throwable
     */
    public function update($data, $id): BaseModel|array|Collection|Builder|null
    {
        $model = $this->findById($id);
        foreach ($data as $item => $value) {
            if (! in_array($item, $model->translatable)) {
                $model->{$item} = $value;

                continue;
            }
            if (is_array($value)) {
                foreach ($value as $name => $itemValue) {
                    app()->setLocale($name);
                    $model->{$item} = $itemValue;
                }
            } else {
                $model->{$item} = $value;
            }
        }
        $model->save();

        return $model;
    }

    /**
     * @return BaseModel|BaseModel[]|Builder|Builder[]|Collection|null
     *
     * @throws Throwable
     */
    public function findById($id, $relations = []): BaseModel|array|Collection|Builder|null
    {
        if (! empty($relations)) {
            return $this->query()->with($relations)->findOrFail($id);
        }

        return $this->query()->findOrFail($id);
    }

    /**
     * @return array|Builder|Builder[]|Collection|BaseModel|BaseModel[]
     *
     * @throws Throwable
     */
    public function delete($id): array|Builder|Collection|BaseModel
    {
        $model = $this->findById($id);
        $model->delete();

        return $model;
    }
}
