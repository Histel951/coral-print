<?php

namespace App\Orchid\Fields;

use App\Orchid\Traits\Methodtable;
use Orchid\Screen\Fields\Select;

/**
 * @method self itemId(int $value = true)
 * @method self default(mixed $value = true)
 * @method self requestmethod(string $value = true)
 * @method self mainurl(string $value = true)
 * @method self field(string $value = true)
 */
class SelectTable extends Select
{
    use Methodtable;

    protected $view = 'orchid.fields.select-table';

    protected $attributes = [
        'allowEmpty'    => '',
        'allowAdd'      => false,
        'options'       => [],
        'isOptionList'  => false,
        'itemId'        => 0,
        'value'         => '',
        'default'       => '',
        'requestmethod' => 'post',
        'mainurl'       => '',
        'url'           => '',
        'action'        => '',
        'field'         => ''
    ];

    public function __construct()
    {
        parent::__construct();

        $this->addBeforeRender(function () {
            $url = $this->get('mainurl') ?: request()->header('ORCHID-ASYNC-REFERER', url()->current());

            $query = http_build_query($this->get('parameters'));

            $action = rtrim("{$url}/{$this->get('method')}?{$query}", '/?');
            $this->set('action', $action);

            if ($action) {
                $this->set('url', $action);
            }
        });
    }
}
