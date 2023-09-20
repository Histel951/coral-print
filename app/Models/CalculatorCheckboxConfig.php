<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CalculatorCheckboxConfig extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $fillable = ['value'];

    protected $casts = [
        'value' => 'array',
    ];

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(
            Calculator::class,
            'pivot_calculator_checkbox_configs',
            'calculator_checkbox_config_id',
        );
    }
}
