<?php

namespace App\Orchid\Screens;

use App\Http\Requests\CommonSettingsRequest;
use App\Models\CommonSetting;
use App\Orchid\Helpers\HAlert;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class CommonSettingsScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [...CommonSetting::first()->toArray()];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Общие настройки';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->method('saveData')
                ->icon('save-alt')
                ->type(Color::SUCCESS()),
        ];
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
                    Input::make('email')->title('Email сайта'),

                    Input::make('email_complain')->title('Email для жалоб'),

                    Input::make('phone')
                        ->title('Телефон')
                        ->mask('+7 999 999-99-99'),

                    Input::make('discount_value')
                        ->title('Размер скидки за отзыв')
                        ->value(0),

                    Input::make('yandex_review_link')
                        ->title('Ссылка для отзывов для Яндекса')
                        ->value('https://yandex.ru/profile/'),

                    Input::make('google_review_link')
                        ->title('Ссылка для отзывов для Google')
                        ->value('https://www.google.com/maps/place/'),

                    Input::make('instagram_review_link')
                        ->title('Ссылка для отзывов для Instagram')
                        ->value('https://www.instagram.com/'),

                    Input::make('instagram_link')
                        ->title('Инстаграм')
                        ->value('https://www.instagram.com/'),

                    Input::make('vk_link')
                        ->title('VK')
                        ->value('https://vk.com/'),
                ]),
                Layout::rows([SimpleMDE::make('bank_details')->title('Банковские реквизиты')]),
            ]),
        ];
    }

    public function saveData(CommonSettingsRequest $request): void
    {
        $request->validated();

        if ($model = CommonSetting::first()) {
            $success = $model->update($request->all());
        } else {
            $success = CommonSetting::create($request->all());
        }

        HAlert::alert($success);
    }
}
