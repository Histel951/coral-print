<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculatorStandardList extends Model
{
    use HasFactory;

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }
}
