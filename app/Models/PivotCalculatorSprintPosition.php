<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCalculatorSprintPosition extends Model
{
    use HasFactory;

    protected $fillable = ['calculator_id', 'sprint_position_id'];
}
