<?php

namespace App\Orchid\Custom;

use Orchid\Screen\TD;

class MinTD extends TD
{
    /**
     * @var string
     */
    protected string $style = '';

    /**
     * @var string
     */
    protected string $viewTd = 'orchid.partials.layouts.min-td';

    /**
     * @var string
     */
    protected string $viewTh = 'orchid.partials.layouts.min-th';

    public function style(string $value): self
    {
        $this->style = $value;

        return $this;
    }

    public function buildTd($repository, ?object $loop = null)
    {
        $value = $this->render ? $this->handler($repository, $loop) : $repository->getContent($this->name);

        return view($this->viewTd, [
            'align'   => $this->align,
            'value'   => $value,
            'render'  => $this->render,
            'slug'    => $this->sluggable(),
            'width'   => $this->width,
            'colspan' => $this->colspan,
            'style'   => $this->style
        ]);
    }

    public function buildTh()
    {
        return view($this->viewTh, [
            'width'        => $this->width,
            'align'        => $this->align,
            'sort'         => $this->sort,
            'sortUrl'      => $this->buildSortUrl(),
            'column'       => $this->column,
            'title'        => $this->title,
            'filter'       => $this->buildFilter(),
            'filterString' => $this->buildFilterString(),
            'slug'         => $this->sluggable(),
            'popover'      => $this->popover,
        ]);
    }
}
