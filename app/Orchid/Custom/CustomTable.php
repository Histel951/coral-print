<?php

declare(strict_types=1);

namespace App\Orchid\Custom;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;

abstract class CustomTable extends Table
{
    protected $customTDView;

    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (!$this->isSee()) {
            return;
        }

        $columns = collect($this->columns())->filter(static function (TD $column) {
            return $column->isSee();
        });

        if ($this->customTDView) {
            foreach ($columns as &$column) {
                $column->setView($this->customTDView);
            }
        }

        $total = collect($this->total())->filter(static function (TD $column) {
            return $column->isSee();
        });

        $rows = $repository->getContent($this->target);
        $rows = is_array($rows) ? collect($rows) : $rows;

        return view($this->template, [
            'repository' => $repository,
            'rows' => $rows,
            'columns' => $columns,
            'total' => $total,
            'iconNotFound' => $this->iconNotFound(),
            'textNotFound' => $this->textNotFound(),
            'subNotFound' => $this->subNotFound(),
            'striped' => $this->striped(),
            'compact' => $this->compact(),
            'bordered' => $this->bordered(),
            'hoverable' => $this->hoverable(),
            'slug' => $this->getSlug(),
            'onEachSide' => $this->onEachSide(),
            'title' => $this->title,
        ]);
    }
}
