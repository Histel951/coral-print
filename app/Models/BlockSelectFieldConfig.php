<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property BlockSelectFieldConfigTypes $type
 */
class BlockSelectFieldConfig extends Model
{
    use HasFactory;

    protected $fillable = ['active', 'calculator_sub_id', 'calculator_id', 'block_select_field_config_type_id'];

    public function type(): BelongsTo
    {
        return $this->belongsTo(BlockSelectFieldConfigTypes::class, 'block_select_field_config_type_id', 'id');
    }

    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(
            FormField::class,
            'pivot_calculator_block_select_fields',
            'block_select_field_config_id',
        );
    }

    public function calculatorSub(): BelongsTo
    {
        return $this->belongsTo(CalculatorSub::class, 'calculator_sub_id', 'id');
    }

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class, 'calculator_id', 'id');
    }
}
