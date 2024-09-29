<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Category extends BaseModel
{
    use NodeTrait, HasFactory, SoftDeletes;

    protected array $translatable = ['name'];

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'image',
        'coefficient',
        'is_active',
        'sort',
    ];
}
