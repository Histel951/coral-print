<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class WorkAdditional extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $casts = [
        'properties' => 'array',
    ];

    protected $fillable = [
        'name',
        'formula_id',
        'type_name',
        'color',
        'code',
        'weight',
        'volume',
        'times',
        'work_additional_type_id',
    ];

    protected array $allowedFilters = [
        'id',
        'name',
        'type_name',
        'color',
        'code',
        'weight',
        'volume',
        'times',
        'work_additional_type_id',
        'created_at',
        'updated_at',
    ];

    protected array $allowedSorts = [
        'id',
        'name',
        'type_name',
        'color',
        'code',
        'weight',
        'volume',
        'times',
        'work_additional_type_id',
        'created_at',
        'updated_at',
    ];

    public function formula(): BelongsTo
    {
        return $this->belongsTo(Formula::class, 'formula_id', 'id');
    }

    public function prices(): BelongsToMany
    {
        return $this->belongsToMany(WorkAdditionalPrice::class, 'pivot_work_additional_prices', 'work_additional_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(WorkAdditionalType::class, 'work_additional_type_id', 'id');
    }

    public function pivot(): BelongsToMany
    {
        return $this->belongsToMany(PivotWorkAdditional::class, 'pivot_work_additional', 'additional_work_id');
    }

    public function calculatorType(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class);
    }

    public function hole(): BelongsTo
    {
        return $this->belongsTo(Hole::class);
    }

    public function lamination(): BelongsTo
    {
        return $this->belongsTo(Lamination::class);
    }

    public function foiling(): BelongsTo
    {
        return $this->belongsTo(Foiling::class);
    }
}
