<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class WorkAdditionalPrice extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'list_meters',
        'circulation',
        'price',
        'fixed_sum',
        'percent',
        'charge',
        'work_additional_id',
    ];

    protected array $allowedFilters = [
        'id',
        'list_meters',
        'circulation',
        'price',
        'fixed_sum',
        'percent',
        'charge',
        'work_additional_id',
        'created_at',
        'updated_at',
    ];

    protected array $allowedSorts = [
        'id',
        'list_meters',
        'circulation',
        'price',
        'fixed_sum',
        'percent',
        'charge',
        'work_additional_id',
        'created_at',
        'updated_at',
    ];

    public function workAdditional(): BelongsToMany
    {
        return $this->belongsToMany(
            WorkAdditional::class,
            'pivot_work_additional_prices',
            'work_additional_price_id',
            'work_additional_id',
        );
    }
}
