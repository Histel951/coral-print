<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCalculatorSpecieType extends Model
{
    use HasFactory;

    protected $fillable = [
        'calculator_id',
        'specie_type_id',
        'print_id',
        'is_duplex',
        'is_white_print',
        'calculator_sub_id',
    ];
}
