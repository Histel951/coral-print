<?php

namespace App\Orchid\Layouts;

use App\Models\Promocode;
use App\Orchid\Custom\CustomTable;
use App\Orchid\Custom\CustomTD;
use App\Services\PromocodeService;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class PromocodeTable extends CustomTable
{
    public PromocodeService $promocodeService;

    public function __construct(PromocodeService $promocodeService)
    {
        $this->promocodeService = $promocodeService;
    }

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'table';

    protected $customTDView = 'partials.orchid.promocode_td';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            CustomTD::make('id', 'ID')
                ->sort()
                ->render(function (Promocode $model) {
                    return $model->id;
                }),
            CustomTD::make('updated_at', 'Дата')
                ->sort()
                ->width('auto')
                ->sort()
                ->noWrap()
                ->alignCenter()
                ->render(function (Promocode $model) {
                    return date('d.m.Y', strtotime($model->updated_at));
                }),
            CustomTD::make('email', 'e-mail')
                ->sort()
                ->noWrap()
                ->render(function (Promocode $model) {
                    return $model->email;
                }),
            CustomTD::make('discount', 'Скидка')
                ->noWrap()
                ->render(function (Promocode $model) {
                    return $model->discount;
                }),
            CustomTD::make('value', 'Промокод')
                ->sort()
                ->noWrap()
                ->render(function (Promocode $model) {
                    return $model->value;
                }),
            CustomTD::make('is_active', 'Статус')
                ->sort()
                ->noWrap()
                ->sort()
                ->render(function (Promocode $model) {
                    return $model->is_active ? 'Активен' : 'Использован';
                }),
            CustomTD::make('source', 'Источник')
                ->sort()
                ->noWrap()
                ->render(function (Promocode $model) {
                    return $this->promocodeService->getSourceText($model->source);
                }),
            CustomTD::make('category', 'Раздел')
                ->sort()
                ->noWrap()
                ->render(function (Promocode $model) {
                    return $model->calculatorType->name;
                }),
            CustomTD::make('action', 'Редактировать')->render(function (Promocode $model) {
                return Link::make('Редактировать')->route('platform.promocode.edit', $model);
            }),
        ];
    }
}
