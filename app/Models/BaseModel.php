<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BaseModel extends Model
{
    use HasTranslations;

    protected array $translatable;
}
