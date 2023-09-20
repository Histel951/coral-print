<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PivotCalculatorEmbossing extends Model
{
    use HasFactory;

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class, 'calculator_id', 'id');
    }

    public function embossing(): BelongsTo
    {
        return $this->belongsTo(EmbossingType::class, 'embossing_id', 'id');
    }
}
