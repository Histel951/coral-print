<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCalculatorFoiling extends Model
{
    use HasFactory;

    protected $fillable = ['calculator_id', 'calculator_sub_id', 'foiling_id', 'print_id', 'is_face'];
}
