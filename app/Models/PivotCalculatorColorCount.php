<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PivotCalculatorColorCount extends Model
{
    use HasFactory;

    protected $fillable = ['calculator_id', 'color_count_id'];

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class, 'calculator_id', 'id');
    }

    public function colorCounts(): BelongsTo
    {
        return $this->belongsTo(ColorCount::class, 'color_count_id', 'id');
    }
}
