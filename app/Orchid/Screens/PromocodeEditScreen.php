<?php

namespace App\Orchid\Screens;

use App\Http\Requests\PromocodeRequest;
use App\Models\CalculatorType;
use App\Models\Promocode;
use App\Orchid\Helpers\HAlert;
use App\Services\ContentService;
use App\Services\PromocodeService;
use App\Services\SendMailService;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PromocodeEditScreen extends EditScreen
{
    public PromocodeService $promocodeService;
    public ContentService $contentService;
    protected SendMailService $sendMailService;
    public Promocode $promocode;

    public function __construct(
        PromocodeService $promocodeService,
        ContentService $contentService,
        Promocode $promocode,
        SendMailService $sendMailService,
    ) {
        $this->promocodeService = $promocodeService;
        $this->contentService = $contentService;
        $this->sendMailService = $sendMailService;
        $this->promocode = $promocode;
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Promocode $promocode): iterable
    {
        return [
            'promocode' => $promocode,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование';
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

                Input::make('promocode.discount')->title('Скидка'),

                Input::make('promocode.value')
                    ->id('code')
                    ->required()
                    ->title('Промокод'),

                Select::make('promocode.is_active')
                    ->title('Статус')
                    ->options(['Использован', 'Активен']),

                Select::make('promocode.source')
                    ->title('Источник')
                    ->id('source')
                    ->options(
                        $this->promocode->source == PromocodeService::SOURCE_SITE
                            ? [
                                PromocodeService::SOURCE_SITE => $this->promocodeService->getSourceText(
                                    PromocodeService::SOURCE_SITE,
                                ),
                            ]
                            : $this->promocodeService->getAvailibleSources(),
                    ),
                Select::make('promocode.calculator_type_id')
                    ->title('Раздел')
                    ->id('category')
                    ->empty()
                    ->fromModel(CalculatorType::class, 'name'),

                CheckBox::make('send')
                    ->title('Отправить')
                    ->sendTrueOrFalse(),
            ]),
            Layout::view('orchid.promocode_select'),
        ];
    }

    public function edit(PromocodeRequest $request, Promocode $promocode)
    {
        if ($this->promocodeService->getPromocodeCount($request->input('promocode.value')) > 1) {
            Alert::error('Промокод ' . strtoupper($request->input('promocode.value')) . ' уже существует');

            return redirect()->back();
        }

        if (!$promocode->fill($request->get('promocode'))->save()) {
            Alert::error(HAlert::ERROR_MSG);

            return redirect()->back();
        }

        if ($request->input('send')) {
            $this->sendMailService->sendPromocodeMessage($promocode, $request->input('promocode.email'));
        }
        Toast::success(HAlert::SUCCESS_MSG);

        return redirect()->route('platform.promocodes');
    }

    public function delete(Promocode $promocode)
    {
        $success = $promocode->delete();
        HAlert::alert($success);

        return redirect()->route('platform.promocodes');
    }
}
