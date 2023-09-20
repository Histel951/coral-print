<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PromocodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required|string',
        ];
    }
}
