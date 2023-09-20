<?php

namespace App\Orchid\Screens;

use App\Models\Review;
use App\Orchid\Layouts\ReviewSelection;
use App\Orchid\Layouts\ReviewTabel;
use App\Services\PromocodeService;
use App\Services\ReviewService;
use App\Services\SendMailService;
use Orchid\Screen\Screen;

class ReviewScreen extends Screen
{
    protected PromocodeService $promocodeService;
    protected SendMailService $sendMailService;
    protected ReviewService $reviewService;

    /**
     * @param PromocodeService $promocodeService
     * @param SendMailService $sendMailService
     */
    public function __construct(
        PromocodeService $promocodeService,
        SendMailService $sendMailService,
        ReviewService $reviewService,
    ) {
        $this->promocodeService = $promocodeService;
        $this->sendMailService = $sendMailService;
        $this->reviewService = $reviewService;
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'table' => Review::with(['avatar'])
                ->filtersApplySelection(ReviewSelection::class)
                ->filters()
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Отзывы';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [ReviewSelection::class, ReviewTabel::class];
    }
}
