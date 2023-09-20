<?php

namespace App\Orchid\Screens;

use App\Http\Requests\PromocodeRequest;
use App\Models\Promocode;
use App\Orchid\Helpers\HAlert;
use App\Services\PromocodeService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PromocodeCreateScreen extends Screen
{
    public PromocodeService $promocodeService;

    public function __construct(PromocodeService $promocodeService)
    {
        $this->promocodeService = $promocodeService;
    }

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
        return 'Создание';
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
            Layout::rows([
                Input::make('promocode.email')->title('E-mail'),

                Input::make('promocode.discount')
                    ->value('10')
                    ->title('Скидка'),

                Input::make('promocode.value')
                    ->required()
                    ->value($this->promocodeService->getNewCode())
                    ->title('Промокод'),

                Select::make('promocode.source')
                    ->title('Источник')
                    ->options($this->promocodeService->getAvailibleSources()),

                CheckBox::make('send')
                    ->title('Отправить')
                    ->sendTrueOrFalse(),
            ]),
        ];
    }

    public function save(PromocodeRequest $request, Promocode $promocode)
    {
        if ($this->promocodeService->getPromocodeCount($request->input('promocode.value'))) {
            Alert::error('Промокод ' . strtoupper($request->input('promocode.value')) . ' уже существует');

            return redirect()->back();
        }

        if (!$promocode->fill([...$request->get('promocode'), 'is_active' => true])->save()) {
            Alert::error(HAlert::ERROR_MSG);

            return redirect()->back();
        }

        Toast::success(HAlert::SUCCESS_MSG);

        return redirect()->route('platform.promocodes');
    }
}
