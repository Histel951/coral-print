<?php

namespace App\Orchid\Actions;

use Orchid\Screen\Action;

/**
 * @method self action(string $value = true)
 * @method self url(string $url = true)
 * @method self mainurl(string $url = true)
 * @method self requestmethod(string $method = true)
 * @method self icon(string $value = true)
 * @method self disabled(bool $value = true)
 */
class TurboButton extends Action
{
    protected $view = 'orchid.action.turbo-button';

    protected $attributes = [
        'class' => 'btn btn-link',
        'method' => 'post',
        'parameters' => [],
        'action' => null,
        'mainurl' => '',
        'url' => '',
        'requestmethod' => 'post',
        'icon' => null,
        'disabled' => false,
    ];

    public function __construct()
    {
        $this->addBeforeRender(function () {
            if ($this->get('action') !== null) {
                return;
            }

            $url = $this->get('mainurl') ?: request()->header('ORCHID-ASYNC-REFERER', url()->current());

            $query = http_build_query($this->get('parameters'));

            $action = rtrim("{$url}/{$this->get('method')}?{$query}", '/?');
            $this->set('action', $action);

            if ($action) {
                $this->set('url', $action);
            }

            $this->set('data-turbo-action', 'post');
        });
    }

    /**
     * Меняет шаблон экшена
     * @param string $template
     * @return $this
     */
    public function typeForm(string $template = 'platform::partials.fields.clear'): self
    {
        $this->typeForm = $template;

        return $this;
    }

    public function method(string $name, array $parameters = []): self
    {
        return $this->set('method', $name)->when(!empty($parameters), function () use ($parameters) {
            $this->set('parameters', $parameters);
        });
    }
}
