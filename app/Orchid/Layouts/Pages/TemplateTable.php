<?php

namespace App\Orchid\Layouts\Pages;

use App\Models\Pages\PageTemplate;
use App\Orchid\Custom\CustomTable;
use App\Orchid\Custom\CustomTD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;

class TemplateTable extends CustomTable
{
    protected $target = 'table';

    protected function columns(): iterable
    {
        return [
            CustomTD::make('id', 'ID')->render(fn (PageTemplate $template) => $template->id),

            CustomTD::make('name', 'Название')->render(fn (PageTemplate $template) => $template->name),

            CustomTD::make('alias', 'Алиас')->render(fn (PageTemplate $template) => $template->alias),

            CustomTD::make('action', 'Действие')->render(
                fn (PageTemplate $template) => Group::make([
                    Link::make('Редактировать')->route('platform.templates.edit', ['id' => $template->id]),
                ]),
            ),
        ];
    }
}
