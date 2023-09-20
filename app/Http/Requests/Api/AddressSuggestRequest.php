<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddressSuggestRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'query' => 'required|string|min:3',
            'region' => 'required|string',
            'restricted' => 'boolean',
            'limit' => 'int',
        ];
    }
}
