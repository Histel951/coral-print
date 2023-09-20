<?php

namespace App\Orchid\Screens\Design;

use App\Models\DesignCategory;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DesignCategoryEditScreen extends EditScreen
{
    public DesignCategory $designCategory;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(DesignCategory $designCategory): iterable
    {
        return [
            'designCategory' => $designCategory,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование категории дизайна \"{$this->designCategory->name}\" [{$this->designCategory->id}]";
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
                    Input::make('designCategory.name')
                        ->title('Название')
                        ->placeholder('Название..'),
                ]),
            ]),
        ];
    }

    public function edit(Request $request, DesignCategory $designCategory)
    {
        if ($designCategory->fill($request->get('designCategory'))->save()) {
            Alert::success('Категория дизайна успешно обновлена!');
        } else {
            Alert::success('Категория дизайна не обновлена.');
        }
    }

    public function delete(DesignCategory $designCategory): RedirectResponse
    {
        $designCategory->delete();

        return redirect()->route('platform.design.categories');
    }
}
