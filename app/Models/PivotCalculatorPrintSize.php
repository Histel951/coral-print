<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCalculatorPrintSize extends Model
{
    use HasFactory;

    protected $fillable = ['calculator_id', 'print_size_id'];
}
