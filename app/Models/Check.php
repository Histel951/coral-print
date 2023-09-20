<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Check extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'checks', 'identifiers', 'data'];

    protected $casts = [
        'checks' => 'array',
        'identifiers' => 'array',
        'data' => 'array',
    ];

    public function calculators(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class, 'pivot_calculator_checks', 'check_id');
    }
}
