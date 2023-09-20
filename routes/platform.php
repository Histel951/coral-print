<?php

declare(strict_types=1);

use App\Orchid\Screens\Calculators\CalculatorCreateScreen;
use App\Orchid\Screens\Calculators\CalculatorEditScreen;
use App\Orchid\Screens\Calculators\CalculatorListScreen;
use App\Orchid\Screens\Calculators\CalculatorTypeCreateScreen;
use App\Orchid\Screens\Calculators\CalculatorTypeEditScreen;
use App\Orchid\Screens\Calculators\CalculatorTypeListScreen;
use App\Orchid\Screens\CallScreen;
use App\Orchid\Screens\CommonSettingsScreen;
use App\Orchid\Screens\DepartmentSettingsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\ExchangeRatesScreen;
use App\Orchid\Screens\FileManagerScreen;
use App\Orchid\Screens\Flex\Color\ColorChangePaintsScreen;
use App\Orchid\Screens\Flex\Color\ColorPaintCreateScreen;
use App\Orchid\Screens\Flex\Color\ColorPaintEditScreen;
use App\Orchid\Screens\Flex\Color\ColorPaintScreen;
use App\Orchid\Screens\Gallery\GalleryCreateScreen;
use App\Orchid\Screens\Gallery\GalleryEditScreen;
use App\Orchid\Screens\Gallery\GalleryScreen;
use App\Orchid\Screens\GalleryCategoriesListScreen;
use App\Orchid\Screens\Material\MaterialCategoryEditScreen;
use App\Orchid\Screens\Material\MaterialCategoryListScreen;
use App\Orchid\Screens\Material\MaterialCreateScreen;
use App\Orchid\Screens\Material\MaterialEditScreen;
use App\Orchid\Screens\Material\MaterialListScreen;
use App\Orchid\Screens\Material\MaterialSubTypesCreateScreen;
use App\Orchid\Screens\Material\MaterialSubTypesEditScreen;
use App\Orchid\Screens\Material\MaterialSubTypesListScreen;
use App\Orchid\Screens\Material\MaterialTypeCreateScreen;
use App\Orchid\Screens\Material\MaterialTypeEditScreen;
use App\Orchid\Screens\Material\MaterialTypeListScreen;
use App\Orchid\Screens\OrderScreen;
use App\Orchid\Screens\Pages\BlockEditScreen;
use App\Orchid\Screens\Pages\BlockScreen;
use App\Orchid\Screens\Pages\ContentEdit;
use App\Orchid\Screens\Pages\ContentScreen;
use App\Orchid\Screens\Pages\MenuEditScreen;
use App\Orchid\Screens\Pages\MenuScreen;
use App\Orchid\Screens\Pages\TemplateEditScreen;
use App\Orchid\Screens\Pages\TemplateScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Preview\PreviewCreateScreen;
use App\Orchid\Screens\Preview\PreviewEditScreen;
use App\Orchid\Screens\Preview\PreviewListScreen;
use App\Orchid\Screens\Print\PrintCreateScreen;
use App\Orchid\Screens\Print\PrintEditScreen;
use App\Orchid\Screens\Print\Species\PrintSpeciesCreateScreen;
use App\Orchid\Screens\Print\Species\PrintSpeciesEditScreen;
use App\Orchid\Screens\Print\Species\PrintSpeciesListScreen;
use App\Orchid\Screens\Print\SpecieTypeCreateScreen;
use App\Orchid\Screens\Print\SpecieTypeEditScreen;
use App\Orchid\Screens\Print\SpecieTypeListScreen;
use App\Orchid\Screens\Print\Type\PrintTypeCreateScreen;
use App\Orchid\Screens\Print\Type\PrintTypeEditScreen;
use App\Orchid\Screens\Print\Type\PrintTypeListScreen;
use App\Orchid\Screens\PrintModule\FlexScreen;
use App\Orchid\Screens\PrintModule\PrintMaterialColorScreen;
use App\Orchid\Screens\PrintModule\PrintsMaterialScreen;
use App\Orchid\Screens\PrintTypeMaterialCreateScreen;
use App\Orchid\Screens\PromocodeCreateScreen;
use App\Orchid\Screens\PromocodeEditScreen;
use App\Orchid\Screens\PromocodeMailTemplateEditScreen;
use App\Orchid\Screens\PromocodeScreen;
use App\Orchid\Screens\Rapport\RapportKnifesScreen;
use App\Orchid\Screens\ReviewEditScreen;
use App\Orchid\Screens\ReviewScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\TooltipCreateScreen;
use App\Orchid\Screens\TooltipEditScreen;
use App\Orchid\Screens\TooltipScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\Work\WorkAdditionalCreateScreen;
use App\Orchid\Screens\Work\WorkAdditionalEditScreen;
use App\Orchid\Screens\Work\WorkAdditionalListScreen;
use App\Orchid\Screens\Work\WorkAdditionalPriceCreateScreen;
use App\Orchid\Screens\Work\WorkAdditionalPriceEditScreen;
use App\Orchid\Screens\Work\WorkAdditionalPriceListScreen;
use App\Orchid\Screens\Work\WorkAdditionalTypeCreateScreen;
use App\Orchid\Screens\Work\WorkAdditionalTypeEditScreen;
use App\Orchid\Screens\Work\WorkAdditionalTypeListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Example screen');
    });

Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');

Route::screen('settings', CommonSettingsScreen::class)
    ->name('platform.settings')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Настройки');
    });

Route::screen('departments', DepartmentSettingsScreen::class)
    ->name('platform.department.settings')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Отделения');
    });

Route::screen('rates', ExchangeRatesScreen::class)
    ->name('platform.exchange.rates')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Exchange rates');
    });

Route::screen('promocodes', PromocodeScreen::class)
    ->name('platform.promocodes')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Промокоды', \route('platform.promocodes'));
    });

Route::screen('promocode/create', PromocodeCreateScreen::class)
    ->name('platform.promocode.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.promocodes')
            ->push('Создание');
    });
Route::screen('promocode/edit/{tooltip?}', PromocodeEditScreen::class)
    ->name('platform.promocode.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.promocodes')
            ->push('Редактирование');
    });

Route::screen('promocode/mail', PromocodeMailTemplateEditScreen::class)
    ->name('platform.promocodes.template')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.promocodes')
            ->push('Шаблон письма');
    });

Route::screen('galleries/list', GalleryCategoriesListScreen::class)
    ->name('platform.galleries')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Список', \route('platform.galleries'));
    });

Route::screen('gallery/{content?}', GalleryScreen::class)
    ->name('platform.gallery')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.galleries')
            ->push('Галерея');
    });

Route::screen('gallery/create/{id}', GalleryCreateScreen::class)
    ->name('platform.gallery.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.gallery')
            ->push('Создание', \route('platform.gallery'));
    });
Route::screen('gallery/edit/{calculator_type_id?}/{gallery_id?}', GalleryEditScreen::class)
    ->name('platform.gallery.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.gallery')
            ->push('Редактирование', \route('platform.gallery'));
    });

Route::screen('gallery/saveGalleryCategory', GalleryScreen::class)->name('platform.galleries.saveGalleryCategory');
Route::screen('gallery/attachGalleryCategory', GalleryScreen::class)->name('platform.galleries.attachGalleryCategory');
Route::screen('gallery/detachGallery', GalleryScreen::class)->name('platform.galleries.detachGallery');
Route::screen('gallery/deleteGalleryCategory', GalleryScreen::class)->name('platform.galleries.deleteGalleryCategory');

Route::screen('gallery/fileEdit', GalleryEditScreen::class)->name('platform.galleries.file.edit');
Route::screen('gallery/fileDelete', GalleryEditScreen::class)->name('platform.galleries.file.delete');

Route::screen('tooltips', TooltipScreen::class)
    ->name('platform.tooltips')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Подсказки', \route('platform.tooltips'));
    });
Route::screen('tooltip/create', TooltipCreateScreen::class)
    ->name('platform.tooltip.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.tooltips')
            ->push('Создание');
    });
Route::screen('tooltip/edit/{tooltip?}', TooltipEditScreen::class)
    ->name('platform.tooltip.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.tooltips')
            ->push('Редактирование');
    });
//CalculatorRoute::screen('idea', Idea::class, 'platform.screens.idea');

Route::prefix('pages')->group(function () {
    Route::screen('content', ContentScreen::class)
        ->name('platform.content')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Контент');
        });
    Route::screen('content/edit', ContentEdit::class)->name('platform.content.edit');

    Route::screen('templates', TemplateScreen::class)
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Шаблоны'))
        ->name('platform.templates');
    Route::screen('templates/edit', TemplateEditScreen::class)->name('platform.templates.edit');

    Route::screen('menu', MenuScreen::class)
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Меню'))
        ->name('platform.menu');
    Route::screen('menu/edit', MenuEditScreen::class)->name('platform.menu.edit');

    Route::screen('blocks', BlockScreen::class)
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Блоки'))
        ->name('platform.blocks');
    Route::screen('blocks/edit', BlockEditScreen::class)->name('platform.blocks.edit');
});

Route::screen('reviews', ReviewScreen::class)
    ->name('platform.reviews')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Отзывы', \route('platform.reviews'));
    });
Route::screen('review/edit/{review?}', ReviewEditScreen::class)
    ->name('platform.review.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.reviews')
            ->push('Редактирование');
    });

Route::screen('calls', CallScreen::class)
    ->name('platform.calls')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Звонки');
    });

Route::screen('orders', OrderScreen::class)
    ->name('platform.orders')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Заказы');
    });

Route::screen('calculator/types', CalculatorTypeListScreen::class)
    ->name('platform.calculator.types')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Типы калькуляторов', \route('platform.calculator.types'));
    });

Route::screen('calculator/type/edit/{calculatorType?}', CalculatorTypeEditScreen::class)
    ->name('platform.calculator.type.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.calculator.types')
            ->push('Редактирование', \route('platform.calculator.type.edit'));
    });

Route::screen('calculator/type/create', CalculatorTypeCreateScreen::class)
    ->name('platform.calculator.type.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.calculator.types')
            ->push('Создание', \route('platform.calculator.type.create'));
    });

Route::screen('calculators', CalculatorListScreen::class)
    ->name('platform.calculators')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.calculator.types')
            ->push('Калькуляторы', \route('platform.calculators'));
    });

Route::screen('calculator/edit/{calculator?}', CalculatorEditScreen::class)
    ->name('platform.calculator.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.calculators')
            ->push('Редактирование', \route('platform.calculator.edit'));
    });

Route::screen('calculator/create', CalculatorCreateScreen::class)
    ->name('platform.calculator.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.calculators')
            ->push('Редактирование', \route('platform.calculator.create'));
    });

Route::screen('material/types', MaterialTypeListScreen::class)
    ->name('platform.material.types')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Типы материалов', \route('platform.material.types'));
    });

Route::screen('material/type/edit/{materialType?}', MaterialTypeEditScreen::class)
    ->name('platform.material.type.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.material.types')
            ->push('Редактирование', \route('platform.material.type.edit'));
    });

Route::screen('material/type/create', MaterialTypeCreateScreen::class)
    ->name('platform.material.type.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.material.types')
            ->push('Создание', \route('platform.material.type.create'));
    });

Route::screen('materials', MaterialListScreen::class)
    ->name('platform.materials')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Материалы', \route('platform.materials'));
    });

Route::screen('material/create', MaterialCreateScreen::class)
    ->name('platform.material.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.materials')
            ->push('Создание материала', \route('platform.material.create'));
    });

Route::screen('material/categories', MaterialCategoryListScreen::class)
    ->name('platform.material.categories')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.materials')
            ->push('Категории', \route('platform.material.categories'));
    });

Route::screen('material/category/edit/{materialCategory?}', MaterialCategoryEditScreen::class)
    ->name('platform.material.category.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.material.categories')
            ->push('Редактирование', \route('platform.material.category.edit'));
    });

Route::screen('material/sub/types', MaterialSubTypesListScreen::class)
    ->name('platform.material.sub.types')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Подтипы материалов', \route('platform.material.sub.types'));
    });

Route::screen('material/sub/types/create', MaterialSubTypesCreateScreen::class)
    ->name('platform.material.sub.type.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.material.sub.types')
            ->push('Создание');
    });

Route::screen('print/types', PrintTypeListScreen::class)
    ->name('platform.print.types')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Типы печати', \route('platform.print.types'));
    });

Route::screen('print/type/edit/{printType?}', PrintTypeEditScreen::class)
    ->name('platform.print.type.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.print.types')
            ->push('Редактирование');
    });

Route::screen('print/type/create', PrintTypeCreateScreen::class)
    ->name('platform.print.type.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.print.types')
            ->push('Создание');
    });

Route::screen('print/edit/{print?}', PrintEditScreen::class)
    ->name('platform.print.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.prints')
            ->push('Редактирование');
    });

Route::screen('print/create', PrintCreateScreen::class)
    ->name('platform.print.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.prints')
            ->push('Создание');
    });

Route::screen('works/additional', WorkAdditionalListScreen::class)
    ->name('platform.works.additionals')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Доп работы', \route('platform.works.additionals'));
    });

Route::screen('works/additional/edit/{additionalWork?}', WorkAdditionalEditScreen::class)
    ->name('platform.works.additional.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.works.additionals')
            ->push('Редактирование');
    });

Route::screen('works/additional/create', WorkAdditionalCreateScreen::class)
    ->name('platform.works.additional.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.works.additionals')
            ->push('Создание');
    });

Route::screen('work/additional/types', WorkAdditionalTypeListScreen::class)
    ->name('platform.works.additional.types')
    ->breadcrumbs(
        function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Типы доп. работ', \route('platform.works.additional.types'));
        }
    );

Route::screen('work/additional/type/edit/{workAdditionalType?}', WorkAdditionalTypeEditScreen::class)
    ->name('platform.works.additional.type.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.works.additional.types')
            ->push('Редактирование');
    });

Route::screen('print/species', PrintSpeciesListScreen::class)
    ->name('platform.print.species')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.print.types')
            ->push('Разновидность печати', \route('platform.print.species'));
    });

Route::screen('print/specie/edit/{printSpecie?}', PrintSpeciesEditScreen::class)
    ->name('platform.print.specie.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.print.species')
            ->push('Редактировать');
    });

Route::screen('print/specie/create', PrintSpeciesCreateScreen::class)
    ->name('platform.print.specie.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.print.species')
            ->push('Создание');
    });

Route::screen('work/additional/type/create', WorkAdditionalTypeCreateScreen::class)
    ->name('platform.works.additional.type.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.works.additional.types')
            ->push('Создание');
    });

Route::screen('work/additional/prices', WorkAdditionalPriceListScreen::class)
    ->name('platform.works.additional.prices')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Цены доп работ', \route('platform.works.additional.prices'));
    });

Route::screen('work/additional/price/edit/{workAdditionalPrice?}', WorkAdditionalPriceEditScreen::class)
    ->name('platform.works.additional.price.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.works.additional.prices')
            ->push('Редактирование');
    });

Route::screen('work/additional/price/create', WorkAdditionalPriceCreateScreen::class)
    ->name('platform.works.additional.price.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.works.additional.prices')
            ->push('Создание');
    });

Route::screen('module/print/types', PrintTypeListScreen::class)
    ->name('platform.module.print.types')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Типы печатей', \route('platform.module.print.types'))
    );

Route::screen('module/print/material', PrintsMaterialScreen::class)
    ->name('platform.module.print.materials')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
        ->parent('platform.module.print.types')
        ->push('Материалы печати')
    );

Route::screen('module/print/work/additional/types', WorkAdditionalTypeListScreen::class)
    ->name('platform.module.print.work.additional.types')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Доп работы', \route('platform.module.print.work.additional.types'))
    );

Route::screen('module/print/work/additionals', WorkAdditionalListScreen::class)
    ->name('platform.module.print.work.additionals')
    ->breadcrumbs(
        fn (Trail $trail, \App\Models\WorkAdditionalType $workAdditionalType) => $trail
        ->parent('platform.module.print.work.additional.types')
        ->push("{$workAdditionalType->name}", \route('platform.module.print.work.additionals'))
    );


Route::screen('module/print/specie/types', SpecieTypeListScreen::class)
    ->name('platform.print.specie.types')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Разновидности печати');
    });


Route::screen('module/print/specie/type/edit/{specieType?}', SpecieTypeEditScreen::class)
    ->name('platform.print.specie.type.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.module.print.materials')
            ->push('Редактировать');
    });

Route::screen('module/print/work/additional/types', WorkAdditionalTypeListScreen::class)
    ->name('platform.print.works.additional.types')
    ->breadcrumbs(
        function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Типы доп. работ', \route('platform.print.works.additional.types'));
        }
    );

Route::screen('module/print/work/additionals', WorkAdditionalListScreen::class)
    ->name('platform.print.works.additionals')
    ->breadcrumbs(
        function (Trail $trail) {
            return $trail
                ->parent('platform.print.works.additional.types')
                ->push('Доп. работы');
        }
    );

Route::screen('module/print/material/edit/{material?}', MaterialEditScreen::class)
    ->name('platform.print.material.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
        ->parent('platform.module.print.materials')
        ->push('Материалы печати')
    );

Route::screen('module/print/material/colors', PrintMaterialColorScreen::class)
    ->name('platform.print.material.colors')
    ->breadcrumbs(
        fn (Trail $trail) => $trail
        ->parent('platform.module.print.materials')
        ->push('Материалы печати')
    );

Route::screen('module/print/material/color/edit/{materialSubType?}', MaterialSubTypesEditScreen::class)
    ->name('platform.print.material.color.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.module.print.materials')
            ->push('Редактирование');
    });

Route::screen('material/sub/types/edit/{materialSubTypes?}', MaterialSubTypesEditScreen::class)
    ->name('platform.material.sub.type.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.module.print.materials')
            ->push('Редактирование');
    });

Route::screen('module/print/material/create', PrintTypeMaterialCreateScreen::class)
    ->name('platform.module.print.type.material.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.module.print.materials')
            ->push('Создание материала для печати');
    });

Route::screen('module/print/specie/type/create', SpecieTypeCreateScreen::class)
    ->name('platform.module.print.specie.type.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.module.print.materials')
            ->push('Создание печати');
    });

Route::screen('module/print/previews', PreviewListScreen::class)
    ->name('platform.previews')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Превью', \route('platform.previews'));
    });

Route::screen('module/print/preview/edit/{Preview?}', PreviewEditScreen::class)
    ->name('platform.preview.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.previews')
            ->push('Редактирование');
    });

Route::screen('module/print/preview/create', PreviewCreateScreen::class)
    ->name('platform.preview.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.previews')
            ->push('Создать');
    });

Route::screen('file-manager', FileManagerScreen::class)
    ->name('platform.module.file.manager');

Route::screen('module/print/flex', FlexScreen::class)
    ->name('platform.flex')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->push('Флекса');
    });

Route::screen('module/print/flex/rapport/knifes/{rapport?}', RapportKnifesScreen::class)
    ->name('platform.flex.rapport.knifes')
    ->breadcrumbs(function (Trail $trail) {
        return $trail->push('Флекса')->parent('platform.flex');
    });

Route::screen('module/print/flex/color/category/paints/{colorCategory?}', ColorPaintScreen::class)
    ->name('platform.flex.color.paints')
    ->breadcrumbs(function (Trail $trail) {
        return $trail->push('Флекса')->parent('platform.flex');
    });

Route::screen('module/print/flex/color/category/paints/create/{colorCategory?}', ColorPaintCreateScreen::class)
    ->name('platform.flex.color.paint.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail->push('Флекса')->parent('platform.flex');
    });

Route::screen('module/print/flex/color/category/paints/edit/{colorPaint?}', ColorPaintEditScreen::class)
    ->name('platform.flex.color.paint.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail->push('Флекса')->parent('platform.flex');
    });

Route::screen('module/print/flex/color/paints/change/{color?}', ColorChangePaintsScreen::class)
    ->name('platform.flex.color.change.paints')
    ->breadcrumbs(function (Trail $trail) {
        return $trail->push('Флекса')->parent('platform.flex');
    });

Route::screen('designs', \App\Orchid\Screens\Design\DesignListScreen::class)
    ->name('platform.designs')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Дизайн', \route('platform.designs'));
    });

Route::screen('design/edit/{design?}', \App\Orchid\Screens\Design\DesignEditScreen::class)
    ->name('platform.design.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.designs')
            ->push('Редактирование');
    });

Route::screen('design/create', \App\Orchid\Screens\Design\DesignCreateScreen::class)
    ->name('platform.design.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.designs')
            ->push('Создание');
    });

Route::screen('design/categories', \App\Orchid\Screens\Design\DesignCategoryListScreen::class)
    ->name('platform.design.categories')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.designs')
            ->push('Категории дизайна', \route('platform.design.categories'));
    });

Route::screen('design/category/edit/{designCategory?}', \App\Orchid\Screens\Design\DesignCategoryEditScreen::class)
    ->name('platform.design.category.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.design.categories')
            ->push('Редактирование');
    });

Route::screen('design/category/create', \App\Orchid\Screens\Design\DesignCategoryCreateScreen::class)
    ->name('platform.design.category.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.design.categories')
            ->push('Создание');
    });

Route::screen('design/subcategories', \App\Orchid\Screens\Design\DesignSubcategoryListScreen::class)
    ->name('platform.design.subcategories')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.designs')
            ->push('Подкатегории дизайна', \route('platform.design.subcategories'));
    });

Route::screen('design/subcategory/edit/{designSubcategory?}', \App\Orchid\Screens\Design\DesignSubcategoryEditScreen::class)
    ->name('platform.design.subcategory.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.design.subcategories')
            ->push('Редактирование');
    });

Route::screen('design/subcategory/create', \App\Orchid\Screens\Design\DesignSubcategoryCreateScreen::class)
    ->name('platform.design.subcategory.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.design.subcategories')
            ->push('Создание');
    });

Route::screen('design/prices', \App\Orchid\Screens\Design\DesignPriceListScreen::class)
    ->name('platform.design.prices')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.designs')
            ->push('Цены на дизайн', \route('platform.design.prices'));
    });

Route::screen('design/price/edit/{designPrice?}', \App\Orchid\Screens\Design\DesignPriceEditScreen::class)
    ->name('platform.design.price.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.design.prices')
            ->push('Редактирование', \route('platform.design.price.edit'));
    });

Route::screen('design/price/create', \App\Orchid\Screens\Design\DesignPriceCreateScreen::class)
    ->name('platform.design.price.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.design.prices')
            ->push('Редактирование');
    });
