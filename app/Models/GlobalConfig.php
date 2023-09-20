<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalConfig extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    public function scopeGetByName(Builder $query, string $configName): self|Builder|null
    {
        return $query->where('name', $configName)->first();
    }
}
