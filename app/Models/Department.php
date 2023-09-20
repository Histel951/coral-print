<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Department extends Model
{
    use HasFactory;

    protected $model;
    protected $fillable = [
        'name',
        'metro',
        'address',
        'address_link',
        'address_route_link',
        'work_time',
        'text_route',
        'city',
    ];

    public function images(): MorphMany
    {
        return $this->morphMany(FileUpload::class, 'fileable');
    }
}
