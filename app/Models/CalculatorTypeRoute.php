<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CalculatorTypeRoute extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'route', 'params', 'services', 'deps'];

    protected $casts = [
        'services' => 'array',
        'deps' => 'array',
        'params' => 'array',
    ];

    public function props(): HasMany
    {
        return $this->hasMany(CalculatorRouteProps::class);
    }

    public function calculatorType(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class, 'calculator_type_id', 'id');
    }

    public function scopeWhereCalculatorType(Builder $query, int $id): Builder
    {
        return $query->where('calculator_type_id', $id);
    }
}
