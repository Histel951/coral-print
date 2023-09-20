<?php

namespace App\Orchid\Fields;

use Orchid\Screen\Actions\ModalToggle;

/**
 * @method self mainurl(string $value = true)
 */
class ModalToggleTurbo extends ModalToggle
{
    protected $attributes = [
        'class'      => 'btn btn-link',
        'modal'      => null,
        'method'     => null,
        'modalTitle' => null,
        'icon'       => null,
        'action'     => null,
        'mainurl'    => '',
        'async'      => false,
        'open'       => false,
        'parameters' => [],
    ];

    public function __construct()
    {
        parent::__construct();

        $this->addBeforeRender(function () {
            $url = $this->get('mainurl') ?: request()->header('ORCHID-ASYNC-REFERER', url()->current());

            $query = http_build_query($this->get('parameters'));

            $action = rtrim("{$url}/{$this->get('method')}?{$query}", '/?');
            $this->set('action', $action);
        });
    }
}
