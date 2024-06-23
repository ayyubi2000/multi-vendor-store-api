<?php

namespace App\Services;

use App\Interfaces\IBaseService;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class BaseService implements IBaseService
{
    protected ?BaseRepository $repository = null;

    /**
     * @param  array  $data
     * @return LengthAwarePaginator
     *
     * @throws Throwable
     */
    public function paginatedList($data = [], $all = false): LengthAwarePaginator|Collection
    {
        if ($all) {
            return $this->repository->getAllList($data);
        }

        return $this->repository->paginatedList($data);
    }

    /**
     * @return Model|Model[]|Builder|Builder[]|Collection|null
     *
     * @throws Throwable
     */
    public function createModel($data): array|Collection|Builder|Model|null
    {
        return $this->getRepository()->create($data);
    }

    /**
     * @throws Throwable
     */
    protected function getRepository(): BaseRepository
    {
        throw_if(! $this->repository, get_class($this).' repository property not implemented');

        return $this->repository;
    }

    /**
     * @return Model|Model[]|Builder|Builder[]|Collection|null
     *
     * @throws Throwable
     */
    public function updateModel($data, $id): array|Collection|Builder|Model|null
    {
        return $this->getRepository()->update($data, $id);
    }

    /**
     * @return array|Builder|Builder[]|Collection|Model|Model[]
     *
     * @throws Throwable
     */
    public function deleteModel($id): array|Builder|Collection|Model
    {
        return $this->getRepository()->delete($id);
    }

    /**
     * @return Model|Model[]|Builder|Builder[]|Collection|null
     *
     * @throws Throwable
     */
    public function getModelById($id): Model|array|Collection|Builder|null
    {
        return $this->getRepository()->findById($id);
    }
}
