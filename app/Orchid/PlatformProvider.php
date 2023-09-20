<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\Call;
use App\Models\Order;
use App\Orchid\Layouts\AsyncModalLayout;
use Closure;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\LayoutFactory;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        LayoutFactory::macro('asyncModal', function (string $key, Closure $layoutsBuilder): AsyncModalLayout {
            return new AsyncModalLayout($key, $layoutsBuilder);
        });
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make('Страницы')
                ->title('Main')
                ->icon('layers')
                ->list([
                    Menu::make('Контент')->route('platform.content'),
                    Menu::make('Главное меню')->route('platform.menu'),
                    Menu::make('Шаблоны')->route('platform.templates'),
                    Menu::make('Блоки')->route('platform.blocks'),
                ]),

            Menu::make('Лояльность')
                ->icon('book-open')
                ->list([
                    Menu::make('Отзывы')->route('platform.reviews'),
                    Menu::make('Промокоды')->route('platform.promocodes'),
                    Menu::make('Шаблон e-mail')->route('platform.promocodes.template'),
                ]),

            Menu::make('Заказы')
                ->icon('modules')
                ->route('platform.orders')
                ->badge(function () {
                    return Order::isNew()->count() ?: null;
                }),

            Menu::make('Звонки')
                ->icon('call-out')
                ->route('platform.calls')
                ->badge(function () {
                    return Call::isNew()->count() ?: null;
                }),

            Menu::make('Галереи')
                ->icon('picture')
                ->route('platform.galleries'),

            Menu::make('Подсказки')
                ->icon('bulb')
                ->route('platform.tooltips'),

            Menu::make('Дизайн')
                ->icon('energy')
                ->route('platform.designs'),

            Menu::make('Настройки')
                ->icon('settings')
                ->list([
                    Menu::make('Общие')->route('platform.settings'),

                    Menu::make('Отделения')->route('platform.department.settings'),

                    Menu::make('Валюта')->route('platform.exchange.rates'),
                ]),

            Menu::make('Файловый менеджер')
                ->icon('save')
                ->route('platform.module.file.manager'),

            Menu::make('Типы печати')
                ->title('Модуль Print')
                ->route('platform.module.print.types'),

            Menu::make('Флекса')->route('platform.flex'),

            Menu::make('Типы доп. работ')->route('platform.print.works.additional.types'),

            Menu::make('Типы калькуляторов')
                ->title('Calculators')
                ->route('platform.calculator.types'),

            Menu::make('Калькуляторы')->route('platform.calculators'),

            //            Menu::make('Типы материалов')
            //                ->title('Materials')
            //                ->route('platform.material.types'),
            //
            //            Menu::make('Материалы')
            //                ->route('platform.materials'),
            //
            //            Menu::make('Категории материалов')
            //                ->route('platform.material.categories'),
            //
            //            Menu::make('Подтипы материалов')
            //                ->route('platform.material.sub.types'),
            //
            //            Menu::make('Типы печати')
            //                ->title('Print')
            //                ->route('platform.print.types'),
            //
            //            Menu::make('Разновидности печати')
            //                ->route('platform.print.species'),
            //
            //            Menu::make('Печати')
            //                ->route('platform.prints'),
            //
            //            Menu::make('Цены печати')
            //                ->route('platform.print.specie.type.prices'),
            //
            //            Menu::make('Типа ламинации')
            //                ->title('Lamination')
            //                ->route('platform.lamination.types'),
            //
            //            Menu::make('Ламинации')
            //                ->route('platform.laminations'),
            //
            //            Menu::make('Фольга')
            //                ->title('Foiling')
            //                ->route('platform.foilings'),
            //
            //            Menu::make('Цвета фольги')
            //                ->route('platform.foiling.colors'),
            //
            //            Menu::make('Типы нарезок')
            //                ->title('Cuttings')
            //                ->route('platform.cutting.types'),
            //
            //            Menu::make('Нарезки')
            //                ->route('platform.cuttings'),
            //

            //            Menu::make('Цены дизайна')
            //                ->route('platform.design.prices'),
            //
            //            Menu::make('Категории дизайна')
            //                ->route('platform.design.categories'),
            //
            //            Menu::make('Подкатегории дизайна')
            //                ->route('platform.design.subcategories'),
            //
            //            Menu::make('Калькулятор/Материалы')
            //                ->title('Связи')
            //                ->route('platform.pivot.calculator.material'),
            //
            //            Menu::make('Калькулятор/Ламинации')
            //                ->route('platform.pivot.calculator.laminations'),
            //
            //            Menu::make('Калькулятор/Печать')
            //                ->route('platform.pivot.calculator.prints'),
            //
            //            Menu::make('Калькулятор/Нарезки')
            //                ->route('platform.pivot.calculator.cuttings'),

            //            Menu::make('Доп работы')
            //                ->title('Work additionals')
            //                ->route('platform.works.additionals'),
            //
            //            Menu::make('Типы доп работ')
            //                ->route('platform.works.additional.types'),
            //
            //            Menu::make('Цены доп. работ')
            //                ->route('platform.works.additional.prices'),
            /*
            Menu::make('Example screen')
                ->icon('monitor')
                ->route('platform.example')
                ->title('Navigation')
                ->badge(function () {
                    return 6;
                }),

            Menu::make('Dropdown menu')
                ->icon('code')
                ->list([
                    Menu::make('Sub element item 1')->icon('bag'),
                    Menu::make('Sub element item 2')->icon('heart'),
                ]),

            Menu::make('Basic Elements')
                ->title('Form controls')
                ->icon('note')
                ->route('platform.example.fields'),

            Menu::make('Advanced Elements')
                ->icon('briefcase')
                ->route('platform.example.advanced'),

            Menu::make('Text Editors')
                ->icon('list')
                ->route('platform.example.editors'),

            Menu::make('Overview layouts')
                ->title('Layouts')
                ->icon('layers')
                ->route('platform.example.layouts'),

            Menu::make('Chart tools')
                ->icon('bar-chart')
                ->route('platform.example.charts'),

            Menu::make('Cards')
                ->icon('grid')
                ->route('platform.example.cards')
                ->divider(),

            Menu::make('Documentation')
                ->title('Docs')
                ->icon('docs')
                ->url('https://orchid.software/en/docs'),

            Menu::make('Changelog')
                ->icon('shuffle')
                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
                ->target('_blank')
                ->badge(function () {
                    return Dashboard::version();
                }, Color::DARK()),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),*/
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
