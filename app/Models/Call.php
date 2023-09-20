<?php

namespace App\Models;

use App\Services\CallService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;

class Call extends Model
{
    use HasFactory;
    use Filterable;

    protected $guarded = false;

    public function scopeIsNew(Builder $query): Builder
    {
        return $query->where('status', CallService::STATUS_NEW);
    }
}
