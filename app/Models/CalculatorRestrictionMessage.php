<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculatorRestrictionMessage extends Model
{
    use HasFactory;

    protected $fillable = ['error_fields', 'text', 'calculator_restriction_id', 'is_print_restrict', 'is_extra'];

    protected $casts = [
        'error_fields' => 'array',
    ];

    public function restriction(): BelongsTo
    {
        return $this->belongsTo(CalculatorRestriction::class, 'calculator_restriction_id', 'id');
    }
}
