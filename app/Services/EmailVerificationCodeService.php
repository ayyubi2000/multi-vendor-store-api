<?php

namespace App\Services;

use App\Dtos\ApiResponse;
use App\Mail\VerificationMail;
use App\Repositories\EmailVerificationCodeRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class EmailVerificationCodeService extends BaseService
{
    public function __construct(EmailVerificationCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Model|Model[]|Builder|Builder[]|Collection|null
     *
     * @throws Throwable
     */
    public function createModel($data): array|Collection|Builder|Model|null
    {
        $randomCode = random_int(100000, 999999);
        $mailMessage = [
            'to' => $data['email'],
            'subject' => 'Email Verfification Code',
            'code' => $randomCode,
        ];

        $isSending = Mail::send(new VerificationMail($mailMessage));

        if ($isSending) {
            $data = [
                'email' => $data['email'],
                'code' => bcrypt($randomCode),
            ];

            return $this->repository->create($data);
        }
    }

    /**
     * checkEmailVerificationCode
     *
     * @param  mixed  $data
     * @return void
     */
    public function checkVerificationCode($data)
    {
        $model = $this->repository->findByEmail($data['email']);
        if ($model and Hash::check($data['code'], $model->code)) {
            return ApiResponse::success([
                'email' => $data['email'],
            ]);
        } else {
            return ApiResponse::error('The provided code  is incorrect.', Response::HTTP_UNAUTHORIZED);
        }

    }
}
