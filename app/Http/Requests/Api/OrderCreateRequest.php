<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'contacts.fio' => 'required|string',
            'contacts.phone' => 'required|string',
            'contacts.email' => 'required|email',

            'delivery.city' => 'required|string',
            'delivery.city_department' => 'nullable|int',
            'delivery.type' => 'required|int',
            'delivery.price' => 'required|numeric',

            'delivery_address' => 'nullable|string',

            'discount' => 'required|int',

            'payment.id' => 'required|int',
            'payment.company_name' => 'nullable|string',
            'payment.company_inn' => 'nullable|string|size:10',
            'payment.files' => 'nullable|array',
            'payment.files.*.file_name' => 'required_with:payment.files.*.id|string',
            'payment.files.*.id' => 'required_with:payment.files.*.file_name|int',

            'order.items' => 'required|array',

            'order_price' => 'required|numeric',
        ];
    }
}
