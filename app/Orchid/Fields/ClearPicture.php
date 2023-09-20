<?php

namespace App\Orchid\Fields;

use App\Orchid\Traits\Methodtable;
use Orchid\Screen\Fields\Picture;

/**
 * @method self changeable(bool $value = true)
 * @method self mainurl(string $value = true)
 * @method self requestMethod(string $value = true)
 * @method self urlChange(string $value = true)
 * @method self field(string $value = true)
 * @method self issmall(bool $value = true)
 */
class ClearPicture extends Picture
{
    use Methodtable;

    protected $view = 'orchid.fields.clear-picture';

    protected $attributes = [
        'value' => null,
        'target' => 'url',
        'url' => null,
        'maxFileSize' => null,
        'acceptedFiles' => 'image/*',
        'changeable' => null,
        'requestMethod' => 'post',
        'mainurl' => '',
        'urlChange' => '',
        'field' => '',
        'issmall' => false,
    ];

    public function __construct()
    {
        // Set max file size
        $this->addBeforeRender(function () {
            $value = $this->get('value');

            if (blank($value)) {
                $this->set('url', null);
            }

            $this->attributes = array_merge($this->attributes, [
                'changeable' => true,
                'width' => '',
            ]);

            $url = $this->get('mainurl') ?: request()->header('ORCHID-ASYNC-REFERER', url()->current());

            $query = http_build_query($this->get('parameters', []));

            $action = rtrim("{$url}/{$this->get('method')}?{$query}", '/?');
            $this->set('action', $action);

            if ($action) {
                $this->set('urlChange', $action);
            }
        });

        parent::__construct();
    }
}
