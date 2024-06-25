<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckEmailVerificationCodeRequest;
use App\Http\Requests\StoreEmailVerificationCodeRequest;
use App\Models\EmailVerificationCode;
use App\Services\EmailVerificationCodeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EmailVerificationCodeController extends Controller
{
    private EmailVerificationCodeService $service;

    public function __construct(EmailVerificationCodeService $service)
    {
        $this->service = $service;
    }

    /**
     * @unauthenticated
     */
    public function sendEmailVerification(StoreEmailVerificationCodeRequest $request): array|Builder|Collection|EmailVerificationCode
    {
        return $this->service->createModel($request->validated());
    }

    /**
     * @unauthenticated
     */
    public function checkEmailVerification(CheckEmailVerificationCodeRequest $request)
    {
        return $this->service->checkVerificationCode($request->validated());
    }
}
