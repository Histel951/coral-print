<?php

namespace App\Orchid\Layouts\Flex\Rapport;

use App\Models\Rapport;
use App\Orchid\Fields\ModalToggleTurbo;
use App\Orchid\Fields\Span;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class RapportLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'rapports';

    protected string $trItemId = 'tr-item-rapport-{id}';

    protected string $tBodyId = 'table-tbody-rapport';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название')
                ->render(fn (Rapport $rapport) =>
                    Span::make()->changeField(
                        method: 'changeRapportField',
                        field: 'name',
                        model: $rapport,
                        mainUrl: route('platform.flex')
                    )),
            TD::make('rapport_length', 'Длина')
                ->render(fn (Rapport $rapport) =>
                    Span::make()->changeField(
                        method: 'changeRapportField',
                        field: 'rapport_length',
                        model: $rapport,
                        mainUrl: route('platform.flex')
                    )),
            TD::make('Ножи')->render(fn (Rapport $rapport) =>
                 Link::make('Перейти')->route('platform.flex.rapport.knifes', [
                    'rapport' => $rapport
                ])),
            TD::make('actions', ' ')
                ->render(function (Rapport $rapport) {
                    return ModalToggleTurbo::make()
                        ->mainurl(route('platform.flex'))
                        ->modalTitle('Удаление раппорта')
                        ->modal('confirmDeleteRapport')
                        ->method('deleteRapport')
                        ->asyncParameters([
                            'id' => $rapport->id
                        ])
                        ->type(Color::DANGER())
                        ->icon('admin.trash');
                })
        ];
    }

    protected function viewData(Repository $repository): array
    {
        return [
            'addItemRequestData' => [
                'method' => 'addNewRapport'
            ]
        ];
    }
}
