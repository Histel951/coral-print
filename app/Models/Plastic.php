<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plastic extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_plastics', 'plastic_id');
    }

    public function calculatorSub(): BelongsToMany
    {
        return $this->belongsToMany(CalculatorSub::class, 'pivot_calculator_plastics', 'plastic_id');
    }
}
