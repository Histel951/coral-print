<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SprintPosition extends Model
{
    use HasFactory;

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_sprint_positions', 'sprint_position_id');
    }

    public function calculatorSub(): BelongsToMany
    {
        return $this->belongsToMany(CalculatorSub::class, 'pivot_calculator_sprint_positions', 'sprint_position_id');
    }
}
