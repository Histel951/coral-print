<?php

namespace App\Orchid\Layouts\Rapport;

use App\Models\PrintForm;
use App\Models\RapportKnife;
use App\Orchid\Custom\MinTD;
use App\Orchid\Fields\CheckBoxChangeable;
use App\Orchid\Fields\ClearPicture;
use App\Orchid\Fields\ModalToggleTurbo;
use App\Orchid\Fields\SelectTable;
use App\Orchid\Fields\Span;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class RapportKnifesLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'rapportKnifes';

    protected bool $isAddRowUp = true;

    protected function standardColumns(): iterable
    {
        return [];
    }

    protected function columns(): iterable
    {
        return [
            MinTD::make('id', 'id')
                ->style('text-align: center')
                ->sort(),
            MinTD::make('print_form.name', 'Форма печати')
                ->render(function (RapportKnife $knife) {
                    return SelectTable::make()
                        ->method('changeKnifeField', [
                            'id' => $knife->id
                        ])
                        ->field('print_form_id')
                        ->mainurl(route('platform.flex.rapport.knifes', [
                            'rapport' => $knife->rapport->id
                        ]))
                        ->default($knife->print_form_id)
                        ->itemId($knife->id)
                        ->fromModel(PrintForm::class, 'name', 'id')
                        ->value($knife->print_form_id)
                        ->empty();
                })
                ->sort(),
            $this->changeableTD('height', 'Ширина')->sort(),
            $this->changeableTD('width', 'Длина')->sort(),
            $this->changeableTD('count_rows', 'Кол рядов')->sort(),
            $this->changeableTD('count_rapport', 'Кол рап')->sort(),
            $this->changeableTD('radius', 'Радиус')->sort(),
            $this->changeableTD('line_space', 'Межэтик расстояние')->sort(),
            $this->changeableTD('row_space', 'A1')->sort(),
            $this->changeableTD('print_height', 'Ширина печати')->sort(),
            $this->changeableTD('price', 'Стоим.')->sort(),
            $this->changeableTD('price_percent', 'Наценка')->sort(),
            $this->changeableTD('marking', 'Маркировка')->sort(),
            $this->changeableTD('knife_number', 'КВ', 'word-break: initial')->sort(),
            MinTD::make('isset_knife', 'Наличие')
                ->render(function (RapportKnife $knife) {
                    if ($knife->isset_knife && $knife->knife_number_summary) {
                        return Button::make('Создать')
                            ->disabled()->type(Color::SUCCESS());
                    }

                    return ModalToggleTurbo::make('Создать')
                        ->mainurl(route('platform.flex.rapport.knifes', [
                            'rapport' => $knife->rapport->id
                        ]))->method('createKnife')->asyncParameters([
                        'knife' => $knife->id
                        ])
                        ->modalTitle('Создание номера ножа')
                        ->modal('confirmAddKnifeNumber')
                        ->type(Color::SUCCESS())->id("isset-knife-$knife->id");
                }),
            MinTD::make('knife_number_summary', 'Номер ножа')
                ->render(
                    fn (RapportKnife $knife) => Span::make()->text($knife->knife_number_summary ?? '')
                        ->id("knife-number-$knife->id")->style('white-space: nowrap')
                )
                ->sort(),
            MinTD::make('dummy', 'Пустышка')->render(
                fn (RapportKnife $knife) => CheckBoxChangeable::make($knife->dummy)
                    ->formstyle('justify-content: center; display: flex;')
                    ->method('changeKnifeField', [
                        'id' => $knife->id
                    ])
                    ->mainurl(route('platform.flex.rapport.knifes', [
                        'rapport' => $knife->rapport->id
                    ]))
                    ->field('dummy')
                    ->checked((bool)$knife->dummy)
            ),
            MinTD::make('image_id', 'Превью')
                ->render(function (RapportKnife $knife) {
                    // data-picture-url, data-picture-value
                    return ClearPicture::make()->issmall()->changeable()->method('changeKnifeField', [
                        'id' => $knife->id
                    ])->mainurl(route('platform.flex.rapport.knifes', [
                        'rapport' => $knife->rapport->id
                    ]))->field('image_id')->value($knife->image?->id)->targetId();
                }),
            $this->changeableTD('description', 'Описание', 'max-width: 100px; white-space: initial; word-break: keep-all;')->sort(),
            MinTD::make('actions', ' ')
                ->render(function (RapportKnife $knife) {
                    return ModalToggleTurbo::make()
                        ->mainurl(route('platform.flex.rapport.knifes', [
                            'rapport' => $knife->rapport->id
                        ]))
                        ->modalTitle('Удаление ножа')
                        ->modal('confirmDeleteRapportKnife')
                        ->method('deleteRapportKnife')
                        ->asyncParameters([
                            'id' => $knife->id
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
                'data' => [
                    'rapport_id' => $repository->get('rapport')->id,
                ],
                'method' => 'addNewRapportKnife',
            ]
        ];
    }

    /**
     * @param string $name
     * @param string $title
     * @param string $style
     * @return TD
     */
    private function changeableTD(string $name, string $title, string $style = ''): TD
    {
        return MinTD::make($name, $title)->render(
            fn (RapportKnife $knife) => Span::make()
                ->style('padding: 4px !important; text-align: center; white-space: nowrap;' . $style)
                ->changeField(
                    method: 'changeKnifeField',
                    field: $name,
                    model: $knife,
                    mainUrl: route('platform.flex.rapport.knifes', [
                        'rapport' => $knife->rapport->id
                    ])
                )
        );
    }
}
