<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CalculatorModelTextDataMessage extends Pivot
{
    protected $fillable = ['model_field', 'model_text_data_message_id', 'calculator_id', 'is_int', 'print_form_id'];
}
