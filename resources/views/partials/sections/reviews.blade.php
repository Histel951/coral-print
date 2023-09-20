<div class="container">
    <h2 class="block-title block-title_center block-title_dark">
        Отзывы о {{$reviewTitle ?? 'продукции'}}
    </h2>
    <div class="reviews-stat reviews-stat_page">
        <div class="reviews-stat__item">
            <div class="reviews-stat__num">{{$reviewsCount}}</div>
            <div class="reviews-stat__label">Отзыва от клиентов</div>
        </div>
        <div class="reviews-stat__item">
            <div class="reviews-stat__num">{{ $reviewAvgRate }} / 5</div>
            <div class="rate rate_center reviews-soc-stat__rate">
                @for($i = 0; $i < 5; $i++)
                    <i class="icon-star
                     @if ($i < round($reviewAvgRate))
                        star_yellow
                     @else
                        star_grey
                     @endif"></i>
                @endfor
            </div>
        </div>
    </div>

    </div>

@if($reviews->count())
    <div class="reviews-list">
        @foreach($reviews as $review)
            <div class="p-review">
                <div class="p-review__top">
                    @isset($review->avatar)
                    <img src="{{\Illuminate\Support\Facades\URL::to('storage/'.$review->avatar->path)}}" alt="" class="p-review__avatar">
                    @else
                        <img src="/images/examples/2.jpg" alt="" class="p-review__avatar">
                    @endisset
                    <div class="p-review__top-content">
                        <div class="p-review__head">
                            <div class="rate p-review__rate">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="icon-star
                                     @if ($i < $review->rate)
                                        star_yellow
                                     @else
                                        star_grey
                                     @endif"></i>
                                @endfor
                            </div>
                            <div class="p-review__title">{{$review->title}}</div>
                        </div>
                        <div class="p-review__info">
                            <div class="p-review__author">{{$review->name}}</div>
                            <div

                                class="p-review__date">
                                {{Str::replace('после', 'назад', \Illuminate\Support\Carbon::now()->locale('ru')->diffForHumans(\Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $review->created_at))) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-review__text">
                    <p>{{$review->comment}}</p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="reviews-list__all-link">
        <a href="{{route('reviews', $content->content_id)}}">Смотреть все отзывы →</a>
    </div>
@endif
    <div class="reviews-list__message">
        <p>Оставьте свой отзыв ♡ и получите <span class="text-green">скидку {{\App\Models\CommonSetting::first()->discount_value}}%</span> на следующий заказ!</p>
    </div>
    <div class="reviews-list__btn">
        <button class="btn btn_bg btn_lg" data-micromodal-trigger="add-review"><span class="text-underline-fff">Написать отзыв</span></button>
    </div>
