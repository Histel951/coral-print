<?php

namespace App\Orchid\Layouts;

use App\Models\Review;
use App\Orchid\Custom\CustomTable;
use App\Orchid\Custom\CustomTD;
use App\Services\ReviewService;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class ReviewTabel extends CustomTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'table';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */

    protected $customTDView = 'partials.orchid.review_td';

    protected ReviewService $reviewService;

    /**
     * @param ReviewService $reviewService
     */
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    protected function columns(): iterable
    {
        $cols = [
            CustomTD::make('id', 'ID')
                ->width('auto')
                ->noWrap()
                ->alignCenter()
                ->render(function (Review $model) {
                    return $model->id;
                })
                ->sort(),

            CustomTD::make('updated_at', 'Дата')
                ->sort()
                ->width('auto')
                ->noWrap()
                ->alignCenter()
                ->render(function (Review $model) {
                    return date('d.m.Y', strtotime($model->updated_at));
                }),

            CustomTD::make('name', 'Имя')
                ->width('auto')
                ->noWrap()
                ->alignCenter()
                ->render(function (Review $model) {
                    return $model->name;
                }),

            CustomTD::make('email', 'e-mail')
                ->sort()
                ->width('auto')
                ->noWrap()
                ->alignCenter()
                ->render(function (Review $model) {
                    return $model->email;
                }),

            CustomTD::make('rate', 'Оценка')
                ->sort()
                ->width('auto')
                ->sort()
                ->render(function (Review $model) {
                    return $model->rate;
                }),

            CustomTD::make('title', 'Заголовок')
                ->width('auto')
                ->render(function (Review $model) {
                    return $model->title;
                }),

            CustomTD::make('category', 'Раздел')
                ->sort()
                ->noWrap()
                ->width('auto')
                ->render(function (Review $model) {
                    return $model->calculatorType->name ?? 'Нет';
                }),

            CustomTD::make('status', 'Статус')
                ->sort()
                ->width('auto')
                ->noWrap()
                ->render(function (Review $model) {
                    return $this->reviewService->getStatusText($model->status);
                }),

            CustomTD::make('promocode', 'ID промо')
                ->width('auto')
                ->noWrap()
                ->render(function (Review $model) {
                    return $model->promocode->id;
                }),

            CustomTD::make('action', 'Редактировать')
                ->width('100px')
                ->alignCenter()
                ->render(function (Review $model) {
                    return Link::make('Редактировать')->route('platform.review.edit', $model);
                }),
        ];

        return $cols;
    }

    protected function compact(): bool
    {
        return false;
    }

    protected function hoverable(): bool
    {
        return false;
    }
}
