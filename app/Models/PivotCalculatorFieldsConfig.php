<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PivotCalculatorFieldsConfig extends Model
{
    use HasFactory;

    protected $fillable = ['calculator_id', 'calculator_fields_config_id'];

    public function config(): BelongsTo
    {
        return $this->belongsTo(CalculatorFieldsConfig::class, 'calculator_fields_config_id', 'id');
    }
}
