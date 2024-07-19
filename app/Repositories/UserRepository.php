<?php

namespace App\Repositories;

use Throwable;
use App\Models\User;
use App\Models\UserRoles;
use App\Enum\GeneralStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function create($data): array|Collection|Builder|Model|null
    {
        /**
         * @var $model User
         */
        $model = $this->getBaseModel();
        $model->fill($data);
        $model->save();
        if (isset($data['roles'])) {
            foreach ($data['roles'] as $role) {
                UserRoles::create([
                    'user_id' => $model->id,
                    'role_code' => $role['role_code'],
                    'status' => $role['status'] ? GeneralStatus::STATUS_ACTIVE : GeneralStatus::STATUS_NOT_ACTIVE,
                ]);
            }
        }

        return $model;
    }

    public function update($data, $id): Model|array|Collection|Builder|null
    {
        /**
         * @var $model User
         */
        $model = $this->findById($id);
        $model->fill($data);
        $model->save();
        $model->roles()->delete();
        foreach ($data['roles'] as $role) {
            UserRoles::create([
                'user_id' => $model->id,
                'role_code' => $role['role_code'],
                'status' => $role['status'] ? GeneralStatus::STATUS_ACTIVE : GeneralStatus::STATUS_NOT_ACTIVE,
            ]);
        }

        return $model;
    }

    /**
     * @throws Throwable
     */
    public function findByEmail($email)
    {
        $model = $this->getBaseModel();

        return $model::query()
            ->where('email', '=', $email)
            ->first();
    }

    /**
     * @throws Throwable
     */
    public function createToken(string $email): string
    {

        $model = $this->findByEmail($email);

        return $model->createToken('auth_token')->plainTextToken;
    }

    /**
     * @param  string|User  $username
     *
     * @throws Throwable
     */
    public function removeToken(string|User $email): int
    {
        if (is_string($email)) {
            $model = $this->findByEmail($email);
        } else {
            $model = $email;
        }

        return $model->tokens()->delete();
    }
}
