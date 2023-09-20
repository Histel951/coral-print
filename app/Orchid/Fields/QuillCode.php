<?php

namespace App\Orchid\Fields;

use Orchid\Screen\Fields\Quill;

/**
 * @method QuillCode toolbar(array $tools)
 * @method QuillCode height($value = '300px')
 * @method QuillCode base64(bool $value = true)
 * @method QuillCode class($value = true)
 * @method QuillCode language($value = 'js')
 * @method QuillCode defaultTheme($value = true)
 * @method QuillCode value($value = null)
 */
class QuillCode extends Quill
{
    protected $view = 'orchid.fields.quill-code';

    protected $attributes = [
        'value' => null,
        'toolbar' => ['media'],
        'height' => '300px',
        'base64' => false,
        'class' => 'form-control',
        'language' => 'js',
        'defaultTheme' => true,
    ];
}
