<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailVerificationCode extends BaseModel
{
    use HasFactory;

    public array $translatable = [];

    protected $casts = [];

    protected $hidden = [
        'code',
    ];
}
