<?php

namespace App\Orchid\Layouts\Gallery;

use App\Models\Gallery\Gallery;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

class GalleriesColumnLayout extends Layout
{
    /**
     * @var string
     */
    protected $template = 'orchid.layouts.galleries-column-layout';

    protected $title = 'Галереи';

    protected $target = 'galleries';

    protected function action()
    {
        return fn (Gallery $gallery) => Link::make($gallery->name)
            ->class('list-group-item list-group-item-action')
            ->route('platform.gallery.edit', [
                'calculator_type_id' => $gallery->calculator_type_id,
                'gallery_id' => $gallery->id,
            ]);
    }

    public function build(Repository $repository)
    {
        $this->query = $repository;

        $rows = $repository->getContent($this->target);
        $rows = is_array($rows) ? collect($rows) : $rows;

        return view($this->template, [
            'repository' => $repository,
            'rows' => $rows,
            'action' => $this->action(),
            'slug' => $this->getSlug(),
            'title' => $this->title,
        ]);
    }
}
