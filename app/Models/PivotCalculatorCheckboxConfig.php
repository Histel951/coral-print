<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCalculatorCheckboxConfig extends Model
{
    use HasFactory;

    protected $fillable = ['calculator_id', 'calculator_checkbox_config_id'];

    protected $guarded = false;
}
