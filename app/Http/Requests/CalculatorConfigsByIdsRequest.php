<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculatorConfigsByIdsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'calculators' => 'array|required',
            'calculators.*.id' => 'int|required',
            'calculators.*.print_type' => 'nullable|int',
            'calculators.*.white_print' => 'nullable|int',
        ];
    }
}
