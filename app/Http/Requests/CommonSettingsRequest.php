<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommonSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'nullable|email',
            'email_complain' => 'nullable|email',
            'phone' => 'nullable|string',
            'phone_link' => 'nullable|string',
            'discount_value' => 'nullable|numeric|min:0|max:100',
            'yandex_review_link' => 'nullable|url',
            'yandex_review_rate' => 'nullable|numeric|min:0|max:5',
            'yandex_review_quantity' => 'nullable|numeric',
            'google_review_link' => 'nullable|url',
            'google_review_rate' => 'nullable|numeric|min:0|max:5',
            'google_review_quantity' => 'nullable|numeric',
            'instagram_review_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'vk_link' => 'nullable|url',
            'bank_details' => 'nullable|string',
        ];
    }
}
