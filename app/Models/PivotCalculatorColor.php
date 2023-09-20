<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCalculatorColor extends Model
{
    use HasFactory;

    protected $fillable = ['color_id', 'calculator_id', 'calculator_sub_id'];
}
