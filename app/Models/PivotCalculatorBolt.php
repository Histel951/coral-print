<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCalculatorBolt extends Model
{
    use HasFactory;

    protected $fillable = ['bolt_id', 'calculator_id', 'calculator_sub_id'];
}
