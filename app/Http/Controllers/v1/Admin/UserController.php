<?php

namespace App\Http\Controllers\v1\Admin;

use App\Dtos\ApiResponse;
use App\Enum\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(): LengthAwarePaginator
    {
        return $this->service->paginatedList();
    }

    public function store(StoreUserRequest $request): array|Builder|Collection|User
    {
        return $this->service->createModel($request->validated());

    }

    public function show($userId): array|Builder|Collection|User
    {
        return $this->service->getModelById($userId);
    }

    public function update(UpdateUserRequest $request, int $userId): array|User|Collection|Builder
    {
        return $this->service->updateModel($request->validated(), $userId);
    }

    public function destroy(int $userId): array|Builder|Collection|User
    {
        return $this->service->deleteModel($userId);
    }

    public function roles(): JsonResponse
    {
        $role = new UserRole();

        return ApiResponse::success($role->getRoleList());
    }
}
