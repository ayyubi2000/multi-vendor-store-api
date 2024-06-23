<?php

namespace App\Http\Controllers;

use App\Dtos\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\ApiAuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private ApiAuthService $service;

    public function __construct(ApiAuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->service->login($request->validated());
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->service->register($request->validated());
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->service->resetPassword($request->validated());
    }

    public function logout(): JsonResponse
    {
        return ApiResponse::success($this->service->logout());
    }

    public function checkUserToken(): JsonResponse
    {
        $success = Auth()->user();

        return ApiResponse::success($success);
    }
}
