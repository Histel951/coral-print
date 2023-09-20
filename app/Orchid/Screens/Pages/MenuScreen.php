<?php

namespace App\Orchid\Screens\Pages;

use App\Services\MenuService;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class MenuScreen extends Screen
{
    public function __construct(
        private readonly MenuService $service
    ) {
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Меню';
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
                ->method('createMenuItem')
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
        return [
            Layout::view('main-menu', [
                'items' => $this->service->getMenuItemsTree(),
            ])
        ];
    }

    public function createMenuItem(): RedirectResponse
    {
        return redirect()->route('platform.menu.edit', ['parent_id' => $this->service::ROOT_ID]);
    }
}
