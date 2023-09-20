<?php

namespace App\Orchid\Fields;

use App\Orchid\Traits\Methodtable;
use Orchid\Screen\Fields\CheckBox;

/**
 * @method self requestmethod(string $value = true)
 * @method self field(string $value = true)
 * @method self mainurl(string $value = true)
 * @method self formstyle(string $value = true)
 */
class CheckBoxChangeable extends CheckBox
{
    use Methodtable;

    protected $view = 'partials.orchid.fields.checkbox-changeable';

    protected $attributes = [
        'method' => null,
        'text' => '',
        'url' => '',
        'mainurl' => '',
        'requestmethod' => 'post',
        'field' => null,
        'type' => 'checkbox',
        'class' => 'form-check-input',
        'value' => false,
        'novalue' => 0,
        'yesvalue' => 1,
        'indeterminate' => false,
        'formstyle' => '',
    ];

    public function __construct()
    {
        $this->addBeforeRender(function () {
            $url = $this->get('mainurl') ?: request()->header('ORCHID-ASYNC-REFERER', url()->current());

            $query = http_build_query($this->get('parameters', []));

            $action = rtrim("{$url}/{$this->get('method')}?{$query}", '/?');
            $this->set('action', $action);

            if ($action) {
                $this->set('url', $action);
            }
        });
    }
}
