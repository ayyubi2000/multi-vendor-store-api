<?php

namespace App\Http\Controllers;

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

    public function sendEmailVerification(StoreEmailVerificationCodeRequest $request): array|Builder|Collection|EmailVerificationCode
    {
        return $this->service->createModel($request->validated('data'));
    }

    public function checkEmailVerification(CheckEmailVerificationCodeRequest $request)
    {
        return $this->service->checkVerificationCode($request->validated('data'));
    }
}
