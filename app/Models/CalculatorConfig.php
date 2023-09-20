<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculatorConfig extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'calculator_id'];

    protected $casts = [
        'value' => 'array',
    ];

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }
}
