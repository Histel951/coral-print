<?php

namespace App\Orchid\Screens;

use App\Helpers\SyncDetaching;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

/**
 * @method edit()
 * @method delete()
 */
abstract class EditScreen extends Screen
{
    use SyncDetaching;

    protected string $name = '';

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')->method('edit'),
            Button::make('Удалить')
                ->type(Color::DANGER())
                ->method('delete'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [];
    }
}
