@extends('layouts.layout')
@section('main')
    <section class="section-inner">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/">Главная</a></li>
                <li>Контакты</li>
            </ul>
        </div>

        <div class="container">
            <h1 class="page-title page-title_center page-title_inner3">Контакты</h1>
            <div class="pure-g contacts-page">
                <div class="pure-u-1 pure-u-md-1-2">
                    <div class="contacts-page__part">
                        <div class="contacts-page__links">

                            <p><a href="tel:{{$settings->phone}}" class="link link_phone">{{$settings->phone}}</a></p>
                            <p><a href="mailto:{{$settings->email}}" class="link link_email">{{$settings->email}}</a>
                            </p>
                        </div>
                        <ul class="social-links social-links_contacts">
                            <li class="social__item">
                                <a href="{{$settings->instagram_link}}">
                                    <i class="icon-cp-instagram"></i>
                                </a>
                            </li>
                            <li class="social__item">
                                <a href="{{$settings->vk_link}}">
                                    <i class="icon-cp-vkontakte"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="your-thoughts">
                            <h2 class="your-thoughts__title">Нам, правда, очень важно ваше мнение</h2>
                            <div class="your-thoughts__item">
                                <p>Дарим скидку {{$settings->discount_value}}% на второй заказ за&nbsp;♡&nbsp;отзыв.</p>
                                <div class="your-thoughts__btn">
                                    <button data-micromodal-trigger="action-modal" class="btn btn_bg">
                                        <i class="icon-cp-heart"></i> <span class="text-underline-fff">Оставить отзыв</span>
                                    </button>
                                </div>
                            </div>
                            <div class="your-thoughts__item">
                                <p>Что-то не так с качеством или сервисом? Пожаловаться можно напрямую нашему директору.
                                    Да,
                                    он действительно сам читает каждый отзыв:).</p>
                                <div class="your-thoughts__btn">
                                    <a href="mailto:{{$settings->email_complain}}" class="btn btn_border"><i
                                            class="icon-cp-bad"></i> Пожаловаться главному</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="pure-u-1 pure-u-md-1-2">
                    <div class="contacts-page__part">
                        @foreach($departments as $department)
                            <div class="place">
                                <div class="place__ico">
                                    @if($loop->first)
                                        <i class="icon-cp-gear"></i>
                                    @else
                                        <i class="icon-cp-up-point"></i>
                                    @endif
                                </div>
                                <h2 class="place__title">{{$department->name}}</h2>
                                <p class="place__address">{{$department->address}}
                                    @isset($department->metro)
                                        <i class="icon-metro"></i> {{$department->metro}}
                                    @endisset
                                </p>
                                <p class="place__links">
                                    <a href="{{$department->address_route_link}}">Посмотреть на карте ↗</a>
                                    <a href="#" data-micromodal-trigger="address-modal-{{$department->id}}" class="text-underline">Схема
                                        проезда </a>
                                </p>
                                <p class="place__work-time"><b>Режим работы:</b> {{$department->work_time}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('additional_modals')
    <div class="modal modal_wide" id="action-modal" aria-hidden="true">
        <div tabindex="-1" class="modal__overlay" data-micromodal-close>
            <div class="modal__holder modal__holder_wide" role="dialog" aria-modal="true">
                <div class="modal__content">
                    <h2 class="modal__title modal__title_left">Условия акции</h2>
                    <div class="review-action">
                        <div class="review-action__left">
                            <h3 class="review-action__title review-action__title_left">Отзывы на Яндексе и Google</h3>
                            <ol>
                                <li>Разместите положительный отзыв.</li>
                                <li>После модерации сделайте скрин вашего отзыва.</li>
                                <li>Отправьте скрин вашего отзыва и номер прошлого заказа на почту <a
                                        href="mailto:{{$settings->email}}">{{$settings->email}}</a>.
                                </li>
                                <li>Мы вышлем вам промокод на скидку.</li>
                            </ol>
                            <h3 class="review-action__title  review-action__title_left">Отзывы в Инстаграм</h3>
                            <ol>
                                <li>Подпишитесь на <a href="{{$settings->instagram_link}}">наш аккаунт в Инстаграм</a>
                                </li>
                                <li>После получения заказа оставьте фото-отзыв с отметкой <a href="#">@coral_print</a>
                                    на своей странице и в stories.
                                </li>
                                <li>Мы вышлем вам промокод на скидку в direct.</li>
                            </ol>
                        </div>
                        <div class="review-action__right">
                            <h3 class="review-action__title">Ограничения</h3>
                            <p>Отзывы не суммируются. Здесь еще будет текст, который описывает ограничения немного
                                подробнее.</p>
                            <h3 class="review-action__title">Отзовитесь, пожалуйста:</h3>
                            <div class="review-action__soc">
                                <a href="{{$settings->google_review_link}}"><img
                                        src="{{asset('images/logo/logo-google.svg')}}" alt=""></a>
                                <a href="{{$settings->yandex_review_link}}"><img
                                        src="{{asset('images/logo/logo-yandex.svg')}}" alt=""></a>
                                <a href="{{$settings->instagram_review_link}}"><img
                                        src="{{asset('images/logo/logo-instagram.svg')}}" alt=""></a>
                            </div>
                            <p>И спасибо вам.</p>
                        </div>
                    </div>
                </div>
                <div class="modal__close" data-micromodal-close><i class="icon-close"></i></div>
            </div>
        </div>
    </div>
    @foreach($departments as $department)
        <div class="modal modal_wide" id="address-modal-{{$department->id}}" aria-hidden="true">
            <div tabindex="-1" class="modal__overlay" data-micromodal-close>
                <div class="modal__holder modal__holder_wide modal__holder_address" role="dialog" aria-modal="true">
                    <div class="modal__content">
                        <h2 class="modal__title modal__title_left">Как добраться до "{{$department->name}}"</h2>
                        <div class="address-details">
                            <div class="address-details__gallery">
                                <!-- Slider main container -->
                                <div class="swiper-container address-slider">
                                    <!-- Additional required wrapper -->
                                    <div class="swiper-wrapper">
                                        <!-- Slides -->
                                    @foreach($department->images as $image)
                                            <div class="swiper-slide">
                                                <img src={{\Illuminate\Support\Facades\URL::to('storage/'.$image->path)}} alt="">
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- If we need pagination -->
                                    <div class="address-slider__pagination"></div>
                                </div>
                            </div>
                            <div class="address-details__content">
                                {!! $department->text_route !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal__close" data-micromodal-close><i class="icon-close"></i></div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
