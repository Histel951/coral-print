<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CalculatorTypePreviewOption extends Model
{
    use HasFactory;

    protected $fillable = ['parameters_type'];

    public function calculatorTypes(): HasMany
    {
        return $this->hasMany(CalculatorType::class, 'calculator_type_preview_option_id', 'id');
    }
}
