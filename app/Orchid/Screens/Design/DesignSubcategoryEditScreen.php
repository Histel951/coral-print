<?php

namespace App\Orchid\Screens\Design;

use App\Models\DesignCategory;
use App\Models\DesignSubcategory;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DesignSubcategoryEditScreen extends EditScreen
{
    public DesignSubcategory $designSubcategory;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(DesignSubcategory $designSubcategory): iterable
    {
        return [
            'designSubcategory' => $designSubcategory,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return sprintf(
            'Редактирование подкатегории дизайна "%s" [%s]',
            $this->designSubcategory->name,
            $this->designSubcategory->id,
        );
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
                    Input::make('designSubcategory.name')
                        ->title('Название')
                        ->placeholder('Название..'),

                    Select::make('designSubcategory.design_category_id')
                        ->title('Категория')
                        ->fromModel(DesignCategory::class, 'name', 'id'),
                ]),
            ]),
        ];
    }

    public function edit(Request $request, DesignSubcategory $designSubcategory)
    {
        if ($designSubcategory->fill($request->get('designSubcategory'))->save()) {
            Alert::success('Подкатегория дизайна успешно обновлена!');
        } else {
            Alert::warning('Подкатегория дизайна не обновлена.');
        }
    }

    public function delete(DesignSubcategory $designSubcategory): RedirectResponse
    {
        $designSubcategory->delete();

        return redirect()->route('platform.design.subcategories');
    }
}
