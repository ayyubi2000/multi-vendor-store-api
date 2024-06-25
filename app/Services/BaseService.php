<?php

namespace App\Services;

use App\Interfaces\IBaseService;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseService implements IBaseService
{
    protected ?BaseRepository $repository = null;

    public function paginatedList($data = [], $all = false, $with = []): LengthAwarePaginator|Collection
    {
        /*  if $all is  true  return all collection  else return paginate list  */
        if ($all) {
            return $this->repository->getCollection($data, $with);
        }

        return $this->repository->paginatedList($data, $with);
    }

    public function createModel($data): array|Collection|Builder|Model|null
    {
        return $this->getRepository()->create($data);
    }

    protected function getRepository(): BaseRepository
    {
        throw_if(! $this->repository, get_class($this).' repository property not implemented');

        return $this->repository;
    }

    public function updateModel($data, $id): array|Collection|Builder|Model|null
    {
        return $this->getRepository()->update($data, $id);
    }

    public function deleteModel($id): array|Builder|Collection|Model
    {
        return $this->getRepository()->delete($id);
    }

    public function getModelById($id, $relations = []): Model|array|Collection|Builder|null
    {
        return $this->getRepository()->findById($id, $relations);
    }
}
