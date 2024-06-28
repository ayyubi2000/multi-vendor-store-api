<?php

namespace App\Services;

use App\Dtos\ApiResponse;
use App\Repositories\EmailVerificationCodeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ApiAuthService extends BaseService
{
    private $EmailVerificationCodeRepository;

    public function __construct(UserRepository $repository, EmailVerificationCodeRepository $emailVerificationCodeRepository)
    {
        $this->repository = $repository;
        $this->EmailVerificationCodeRepository = $emailVerificationCodeRepository;
    }

    /**
     * @throws Throwable
     */
    public function login(array $data): JsonResponse
    {
        /*@var $model User */
        $model = $this->repository->findByEmail($data['email']);
        if ($model and Hash::check($data['password'], $model->password)) {
            return ApiResponse::success([
                'type' => 'Bearer',
                'token' => $this->repository->createToken($data['email']),
                'user' => $model,
            ]);
        } else {
            return ApiResponse::error('The provided username or password is incorrect.', Response::HTTP_UNAUTHORIZED);
        }
    }

    public function register(array $data): JsonResponse
    {
        $emailVerification = $this->EmailVerificationCodeRepository->findByEmail($data['email']);

        if ($emailVerification and Hash::check($data['code'], $emailVerification->code)) {
            $data['password'] = bcrypt($data['password']);
            $data['email_verified_at'] = date('Y-m-d');
            $user = parent::createModel($data);
            $emailVerification->delete();

            return ApiResponse::success([
                'type' => 'Bearer',
                'token' => $this->repository->createToken($data['email']),
                'user' => $user,
            ]);
        } else {
            return ApiResponse::error('The email is not verified , please repeat again ', Response::HTTP_UNAUTHORIZED);
        }
    }

    public function resetPassword(array $data): JsonResponse
    {
        $emailVerification = $this->EmailVerificationCodeRepository->findByEmail($data['email']);

        if ($emailVerification and Hash::check($data['code'], $emailVerification->code)) {
            $user = $this->repository->findByEmail($data['email']);
            $user->password = bcrypt($data['password']);
            $user->save();
            $emailVerification->delete();

            return ApiResponse::success([
                'type' => 'Bearer',
                'token' => $this->repository->createToken($data['email']),
                'user' => $user,
            ]);
        } else {
            return ApiResponse::error('The email is not verified , please repeat again ', Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * @throws Throwable
     */
    public function logout(): int
    {
        return $this->repository->removeToken(auth()->user());
    }
}
