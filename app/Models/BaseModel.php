<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;

class BaseModel extends Authenticatable
{
    use HasTranslations;

    public array $translatable;
}
