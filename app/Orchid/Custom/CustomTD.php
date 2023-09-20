<?php

namespace App\Orchid\Custom;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\TD;

/**
 * @method self optionButtons(string $editRoute, Model $model)
 */
class CustomTD extends TD
{
    protected $view = 'platform::partials.layouts.td';

    protected $textWrap = true;

    public function buildTd($repository, ?object $loop = null)
    {
        $value = $this->render ? $this->handler($repository, $loop) : $repository->getContent($this->name);

        return view($this->view, [
            'align' => $this->align,
            'value' => $value,
            'render' => $this->render,
            'slug' => $this->sluggable(),
            'width' => $this->width,
            'colspan' => $this->colspan,
            'wrap' => $this->textWrap,
            'repository' => $repository,
        ]);
    }

    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    public function noWrap()
    {
        $this->textWrap = false;

        return $this;
    }
}
