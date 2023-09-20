<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CalculatorConfigCondition extends Model
{
    use HasFactory;

    protected $casts = [
        'condition' => 'array',
    ];

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(
            Calculator::class,
            'pivot_calculator_config_conditions',
            'calculator_config_condition_id',
        );
    }
}
