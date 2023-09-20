<?php

namespace App\Orchid\Screens\Material;

use App\Models\MaterialCategory;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class MaterialCategoryEditScreen extends EditScreen
{
    public MaterialCategory $materialCategory;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(MaterialCategory $materialCategory): iterable
    {
        return [
            'materialCategory' => $materialCategory,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование категории материала \"{$this->materialCategory->name}\" [{$this->materialCategory->id}]";
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
                    Input::make('materialCategory.name')
                        ->title('Название')
                        ->required(),
                ]),
            ]),
        ];
    }

    public function edit(MaterialCategory $materialCategory, Request $request)
    {
        if ($materialCategory->fill($request->get('materialCategory'))->save()) {
            Alert::success('Категория успешно обновлена!');
        } else {
            Alert::warning('Категория не обновлена');
        }
    }

    public function delete(MaterialCategory $materialCategory): RedirectResponse
    {
        $materialCategory->delete();

        return redirect()->route('platform.material.categories');
    }
}
