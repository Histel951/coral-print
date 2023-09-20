<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCalculatorSub extends Model
{
    use HasFactory;

    protected $fillable = ['calculator_id', 'calculator_sub_id'];

    protected $casts = [
        'parameters' => 'object',
    ];
}
