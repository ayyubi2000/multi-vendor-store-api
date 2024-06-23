<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): object
    {
        return $this->belongsTo(User::class);
    }
}
