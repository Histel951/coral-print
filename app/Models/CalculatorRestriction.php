<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CalculatorRestriction extends Model
{
    use HasFactory;

    protected $fillable = ['max_size', 'min_size', 'extra_max_size', 'extra_min_size', 'calculator_id'];

    public function messages(): HasMany
    {
        return $this->hasMany(CalculatorRestrictionMessage::class, 'calculator_restriction_id', 'id');
    }
}
