@extends('layouts.layout')
@section('main')
    <div class="hidden visible-md hidden-lg visible-xl">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="#">Главная</a></li>
                <li><a href="#">Продукция</a></li>
                @isset($content)
                    <li><a href="{{URL::to($content->url)}}">{{$content->page_title}}</a></li>
                @endisset
                <li>Отзывы</li>
            </ul>
        </div>
    </div>
    <div class="hidden-md visible-lg hidden-xl">
        <div class="container">
            <ul class="breadcrumbs">
                @isset($content)
                    <li><a href="{{URL::to($content->url)}}">← {{$content->page_title}}</a></li>
                @endisset
            </ul>
        </div>
    </div>
    <div class="container container_reviews-intro">
        <div class="reviews-intro">
            <div class="reviews-intro__message">
                <p>Оставьте свой отзыв ♡ и получите <span class="text-green">скидку&nbsp;{{\App\Models\CommonSetting::first()->discount_value}}%</span> на следующий
                    заказ!</p>
            </div>
            <div class="reviews-intro__btn">
                <button class="btn btn_bg" data-micromodal-trigger="add-review"><span class="text-underline-fff">Написать отзыв</span></button>
            </div>
        </div>
    </div>
    <section class="section-inner">
        <div class="container">
            <h1 class="page-title page-title_center page-title_inner3">Отзывы о
                @if($reviewTitle)
                    <a href={{ \Illuminate\Support\Facades\URL::to($content->url) }}> {{$reviewTitle}} </a>
                @else
                продукции
                @endif
            </h1>
            <div class="reviews-stat reviews-stat_page">
                <div class="reviews-stat__item">
                    <div class="reviews-stat__num">{{count($reviews)}}</div>
                    <div class="reviews-stat__label">Отзыва от клиентов</div>
                </div>
                <div class="reviews-stat__item">
                    <div class="reviews-stat__num">{{$reviewAvgRate}} / 5</div>
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
            <div class="reviews-soc-stat">
                <div class="reviews-soc-stat__item">
                    <div class="reviews-soc-stat__label">
                        <img src="/images/logo/logo-google-big.svg" alt="" class="reviews-soc-stat__logo">
                        <a href="#" class="reviews-soc-stat__reviews-num">89 отзывов</a>
                    </div>
                    <div class="reviews-soc-stat__content">
                        <div class="reviews-soc-stat__num">5</div>
                        <div class="rate rate_center reviews-soc-stat__rate">
                            <i class="icon-star star_yellow"></i>
                            <i class="icon-star star_yellow"></i>
                            <i class="icon-star star_yellow"></i>
                            <i class="icon-star star_yellow"></i>
                            <i class="icon-star star_yellow"></i>
                        </div>
                    </div>
                </div>

                <div style="width:300px;height:130px;overflow:hidden;position:relative;">
                    <iframe
                        style="width:100%;height:100%;border:1px solid #e6e6e6;border-radius:8px;box-sizing:border-box"
                        src="https://yandex.ru/maps-reviews-widget/232507004696?comments"></iframe>

                </div>
            </div>
            <div>
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
                                    <div class="p-review__date">{{Str::replace('после', 'назад', \Illuminate\Support\Carbon::now()->locale('ru')->diffForHumans(\Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $review['created_at'])))}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="p-review__text">
                            <p>{{$review->comment}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
