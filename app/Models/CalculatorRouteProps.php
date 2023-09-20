<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculatorRouteProps extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'calculator_type_route_id', 'calculator_id'];

    protected $casts = [
        'value' => 'array',
    ];

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(CalculatorTypeRoute::class);
    }
}
