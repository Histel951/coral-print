<?php

namespace App\Orchid\Layouts\Pages;

use App\Models\Pages\Block;
use App\Orchid\Custom\CustomTable;
use App\Orchid\Custom\CustomTD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;

class BlockTable extends CustomTable
{
    protected $target = 'table';

    protected function columns(): iterable
    {
        return [
            CustomTD::make('id', 'ID')->render(fn (Block $block) => $block->id),

            CustomTD::make('name', 'Алиас')->render(fn (Block $block) => $block->alias),

            CustomTD::make('action', 'Действие')->render(
                fn (Block $block) => Group::make([
                    Link::make('Редактировать')->route('platform.blocks.edit', ['id' => $block->id]),
                ]),
            ),
        ];
    }
}
