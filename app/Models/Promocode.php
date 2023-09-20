<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;

class Promocode extends Model
{
    use HasFactory;
    use Filterable;

    protected $guarded = false;

    protected $allowedSorts = [
        'id',
        'discount',
        'email',
        'source',
        'is_active',
        'calculator_type_id',
        'review_id',
        'created_at',
        'updated_at',
        'value',
    ];
    protected $allowedFilters = [
        'id',
        'discount',
        'email',
        'source',
        'is_active',
        'calculator_type_id',
        'review_id',
        'created_at',
        'updated_at',
        'value',
    ];

    public function calculatorType()
    {
        return $this->belongsTo(CalculatorType::class)->withDefault();
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = strtoupper($value);
    }
}
