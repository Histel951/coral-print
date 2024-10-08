<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCalculatorBlockSelectFields extends Model
{
    use HasFactory;

    protected $fillable = ['block_select_field_config_id', 'form_field_id'];
}
