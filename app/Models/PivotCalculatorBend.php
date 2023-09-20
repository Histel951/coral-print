<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCalculatorBend extends Model
{
    use HasFactory;

    protected $fillable = ['calculator_id', 'bend_id'];
}
