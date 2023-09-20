<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotPrintRestriction extends Model
{
    use HasFactory;

    protected $fillable = ['calculator_id', 'print_restriction_id', 'specie_type_id'];
}
