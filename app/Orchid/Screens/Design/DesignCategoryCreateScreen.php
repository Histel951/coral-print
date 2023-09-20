<?php

namespace App\Orchid\Screens\Design;

use App\Models\DesignCategory;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DesignCategoryCreateScreen extends Screen
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
        return 'Создать категорию дизайна';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Создать')->method('save')];
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
                    Input::make('design_category.name')
                        ->title('Название')
                        ->placeholder('stickers..'),
                ]),
            ]),
        ];
    }

    public function save(DesignCategory $designCategory, Request $request): void
    {
        if ($designCategory->fill($request->get('design_category'))->save()) {
            Alert::success('Категория дизайна успешно создана!');
        } else {
            Alert::warning('Категория дизайна не создана.');
        }
    }
}
