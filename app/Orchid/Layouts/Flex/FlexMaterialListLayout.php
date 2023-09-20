<?php

namespace App\Orchid\Layouts\Flex;

use App\Models\Material;
use App\Models\MaterialVarieties;
use App\Orchid\Fields\CheckBoxChangeable;
use App\Orchid\Fields\ModalToggleTurbo;
use App\Orchid\Fields\SelectTable;
use App\Orchid\Fields\Span;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class FlexMaterialListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'materials';

    protected string $trItemId = 'tr-item-flex-material-{id}';

    protected string $tBodyId = 'table-tbody-flex-material';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('variety.name', 'Тип')
                ->render(
                    fn (Material $material) => SelectTable::make()
                        ->method('changeMaterialField', [
                            'id' => $material->id
                        ])
                        ->field('material_variety_id')
                        ->mainurl(route('platform.flex'))
                        ->default($material->variety?->id)
                        ->itemId($material->id)
                        ->fromModel(MaterialVarieties::class, 'name', 'id')
                        ->value($material->variety?->id)
                        ->empty()
                )
                ->sort(),
            $this->changeableTD('name', 'Название')->sort(),
            $this->changeableTD('article', 'Артикул')->sort(),
            $this->changeableTD('min_meters', 'Мин')->sort(),
            $this->changeableTD('weight', 'Плотн.(г/м2)')->sort(),
            $this->changeableTD('volume', 'Объём')->sort(),
            $this->changeableTD('price', 'Себес. (€)')->sort(),
            $this->changeableTD('price_percent', '%')->sort(),

            TD::make('is_show', 'Показывать')
                ->render(function (Material $material) {
                    return CheckBoxChangeable::make($material->is_show)
                        ->method('changeMaterialField', [
                            'id' => $material->id
                        ])
                        ->mainurl(route('platform.flex'))
                        ->field('is_show')
                        ->checked($material->is_show);
                }),

            $this->changeableTD('sequence', 'Порядок')->sort(),
            TD::make('actions', ' ')
                ->render(function (Material $material) {
                    return ModalToggleTurbo::make()
                        ->mainurl(route('platform.flex'))
                        ->modalTitle('Удаление материала')
                        ->modal('confirmDeleteMaterial')
                        ->method('deleteFlexMaterial')
                        ->asyncParameters([
                            'id' => $material->id
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
                'method' => 'addMaterial'
            ]
        ];
    }

    /**
     * @param string $name
     * @param string $title
     * @return TD
     */
    private function changeableTD(string $name, string $title): TD
    {
        return TD::make($name, $title)->render(
            fn (Material $material) => Span::make()->changeField(
                method: 'changeMaterialField',
                field: $name,
                model: $material,
                mainUrl: route('platform.flex')
            )
        );
    }
}
