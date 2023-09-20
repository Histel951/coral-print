<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCalculatorChecks extends Model
{
    use HasFactory;

    protected $fillable = ['calculator_id', 'check_id'];
}
