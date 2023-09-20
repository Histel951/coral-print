<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class GalleryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'gallery.name' => ['required', 'max:255', 'string'],
            'files' => ['array'],
            'files.*.id' => ['nullable'],
            'files.*.alt' => ['string', 'max:255'],
            'files.*.description' => ['string', 'max:1024'],
            'files.*.basename' => ['string'],
            'files.*.path' => ['string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function prepareForValidation()
    {
        $files = transform(
            $this->input('files', ''),
            fn ($value) => Str::isJson($value) ? json_decode($value, true) : [],
            [],
        );

        $this->merge([
            'files' => $files,
        ]);
    }
}
