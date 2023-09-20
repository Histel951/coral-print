<?php

namespace App\Orchid\Screens\Pages;

use App\Models\Pages\PageTemplate;
use App\Orchid\Layouts\Pages\TemplateTable;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class TemplateScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'table' => PageTemplate::paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Шаблоны';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать')
                ->method('createTemplate')
                ->icon('new-doc')
                ->type(Color::PRIMARY()),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return iterable
     */
    public function layout(): iterable
    {
        return [TemplateTable::class];
    }

    public function createTemplate(): RedirectResponse
    {
        return redirect()->route('platform.templates.edit');
    }
}
