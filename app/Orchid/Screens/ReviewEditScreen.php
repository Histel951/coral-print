<?php

namespace App\Orchid\Screens;

use App\Models\Promocode;
use App\Models\Review;
use App\Orchid\Helpers\HAlert;
use App\Services\PromocodeService;
use App\Services\ReviewService;
use App\Services\SendMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ReviewEditScreen extends EditScreen
{
    protected PromocodeService $promocodeService;
    protected SendMailService $sendMailService;
    protected ReviewService $reviewService;
    protected Review $review;

    /**
     * @param PromocodeService $promocodeService
     * @param SendMailService $sendMailService
     */
    public function __construct(
        ReviewService $reviewService,
        PromocodeService $promocodeService,
        SendMailService $sendMailService,
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
    public function query(Review $review): iterable
    {
        $this->review = $review;
        return [
            'review' => $review,
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
                Input::make('review.name')->title('Имя'),
                Input::make('review.email')->title('E-mail'),
                Select::make('review.rate')
                    ->title('Оценка')
                    ->options([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5]),
                Link::make($this->review->avatar?->path ? 'Открыть' : 'Отсутствует')
                    ->title('Аватар')
                    ->href($this->review->avatar?->path ? URL::to('storage/' . $this->review->avatar?->path) : ''),
                TextArea::make('review.title')
                    ->title('Заголовок')
                    ->rows(5),
                TextArea::make('review.comment')
                    ->title('Текст')
                    ->rows(10),
                Select::make('review.status')
                    ->title('Статус')
                    ->disabled(!is_null($this->review->promocode->id))
                    ->options($this->reviewService->getStatuses()),
                CheckBox::make('send')
                    ->title('Сформировать промокод и отправить')
                    ->disabled(!is_null($this->review->promocode->id))
                    ->sendTrueOrFalse(),
            ]),
        ];
    }

    public function edit(Request $request, Review $review)
    {
        if (!$review->fill($request->get('review'))->save()) {
            Alert::error(HAlert::ERROR_MSG);

            return redirect()->back();
        }

        if ($request->input('review.status') == ReviewService::STATUS_APPROVED && $request->input('send')) {
            $promocode = Promocode::query()->create([
                'value' => $this->promocodeService->getNewCode(),
                'discount' => PromocodeService::DEFAULT_DISCOUNT,
                'email' => $request->input('review.email'),
                'source' => PromocodeService::SOURCE_SITE,
                'is_active' => true,
                'calculator_type_id' => $review->calculator_type_id,
                'review_id' => $review->id,
            ]);
            $this->sendMailService->sendPromocodeMessage(
                Promocode::find($promocode->id),
                $request->input('review.email'),
            );
        }
        Toast::success(HAlert::SUCCESS_MSG);

        return redirect()->route('platform.reviews');
    }

    public function delete(Review $review)
    {
        $success = $review->delete();
        HAlert::alert($success);

        return redirect()->route('platform.reviews');
    }
}
