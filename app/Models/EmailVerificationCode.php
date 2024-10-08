<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailVerificationCode extends BaseModel
{
    use HasFactory;

    protected $casts = [];

    protected $hidden = [
        'code',
    ];

    protected $fillable = [
        'code',
        'email',
    ];
}
