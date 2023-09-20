<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculatorTypeConfig extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(CalculatorType::class);
    }
}
