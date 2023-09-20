<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 */
class CalculatorFieldsConfig extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'value', 'type', 'sequence'];

    protected $casts = [
        'value' => 'array',
    ];

    protected $guarded = false;

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(
            Calculator::class,
            'pivot_calculator_fields_configs',
            'calculator_fields_config_id',
        );
    }
}
