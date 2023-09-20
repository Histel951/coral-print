<?php

namespace App\Orchid\Screens\Pages;

use App\Models\Pages\MenuItem;
use App\Orchid\Helpers\HAlert;
use App\Services\MenuService;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class MenuEditScreen extends Screen
{
    public MenuItem $menuItem;

    public function __construct(
        protected readonly MenuService $service
    ) {
    }

    /**
     * Query data.
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function query(): array
    {
        $id = request()->get('id');

        if ($id) {
            return [
                'menuItem' => MenuItem::find($id),
            ];
        }

        return [
            'menuItem' => MenuItem::make([
                'parent_id' => request()->get('parent_id'),
            ]),
        ];
    }

    public function name(): ?string
    {
        return $this->menuItem->id ? 'Редактирование пункта меню' : 'Создание пункта меню';
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Save')
                ->method(
                    'saveMenuItem',
                    [
                        'parentId' => $this->menuItem->parent_id,
                        'id' => $this->menuItem->id ?? null,
                    ]
                )
                ->type(Color::SUCCESS())
                ->icon('cursor'),

            Button::make('Delete')
                ->method('deleteMenuItem', ['id' => $this->menuItem->id])
                ->icon('cross')
                ->type(Color::DANGER())
                ->canSee(boolval($this->menuItem->id))
                ->confirm('Вы хотите удалить пункт меню?'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('menuItem.name')
                    ->title('Название')
                    ->autocomplete(false)
                    ->required(),
                Input::make('menuItem.url')
                    ->title('URL')
                    ->autocomplete(false),
                Select::make('menuItem.order')
                    ->title('Порядок (выберите пункт меню, после которого нужно вставить текущий)')
                    ->options($this->orderOptions())
                    ->required(),
                CheckBox::make('menuItem.is_visible')
                    ->title('Видимый')
                    ->sendTrueOrFalse(),
            ]),
        ];
    }

    /**
     * @param int $parentId
     * @param int|null $id
     * @param MenuService $service
     * @return RedirectResponse
     */
    public function saveMenuItem(int $parentId, ?int $id, MenuService $service): RedirectResponse
    {
        $data = request()->all();

        try {
            $service->handle(array_merge($data['menuItem'], ['parent_id' => $parentId]), $id);

            Toast::success(HAlert::SUCCESS_MSG);
        } catch (\Exception $e) {
            Toast::error(HAlert::ERROR_MSG);
        }

        return redirect()->route('platform.menu');
    }

    /**
     * @param int $id
     * @param MenuService $service
     * @return RedirectResponse
     */
    public function deleteMenuItem(int $id, MenuService $service): RedirectResponse
    {
        try {
            $service->deleteMenuItem($id);

            Toast::success(HAlert::SUCCESS_MSG);
        } catch (\Exception $e) {
            Toast::error(HAlert::ERROR_MSG);
        }

        return redirect()->route('platform.menu');
    }

    /**
     * Validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'menu.id' => 'int',
            'menu.parent_id' => 'int|nullable',
            'menu.name' => 'required|string',
            'menu.url' => 'required|string',
            'menu.order' => 'required|int',
            'menu.is_visible' => 'required|bool',
        ];
    }

    private function orderOptions(): array
    {
        if (null === $this->menuItem->parent_id) {
            $items = MenuItem::whereNull('parent_id')
                ->orderBy('order')
                ->get();
        } else {
            $items = MenuItem::where('parent_id', $this->menuItem->parent_id)
                ->orderBy('order')
                ->get();
        }

        $namesOrder = [];

        $namesOrder[0] = "Добавить в начало";

        $items->each(function ($item) use (&$namesOrder) {
            $namesOrder[$item->order] = "$item->order - $item->name";
        });

        return $namesOrder;
    }
}
