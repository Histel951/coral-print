<?php

namespace App\Orchid\Screens\Design;

use App\Models\DesignCategory;
use App\Models\DesignSubcategory;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DesignSubcategoryCreateScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создать подкатегорию';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Сохранить')->method('save')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::columns([
                Layout::rows([
                    Input::make('design_subcategory.name')
                        ->title('Название')
                        ->placeholder('stickers..'),

                    Relation::make('design_subcategory.design_category_id')
                        ->title('Категория дизайна')
                        ->fromModel(DesignCategory::class, 'name', 'id'),
                ]),
            ]),
        ];
    }

    public function save(DesignSubcategory $designSubcategory, Request $request): void
    {
        if ($designSubcategory->fill($request->get('design_subcategory'))->save()) {
            Alert::success('Подкатегория успешно создана!');
        } else {
            Alert::warning('Подкатегория не создана.');
        }
    }
}
