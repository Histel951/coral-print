<?php

namespace App\Orchid\Screens\Pages;

use App\Models\Pages\Block;
use App\Orchid\Layouts\Pages\BlockTable;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class BlockScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'table' => Block::paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Блоки';
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
                ->method('createBlock')
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
        return [BlockTable::class];
    }

    public function createBlock(): RedirectResponse
    {
        return redirect()->route('platform.blocks.edit');
    }
}
