<div class="container">
    <h1 class="page-title page-title_center">
        Привет! Давайте печатать
        <i class="icon-cp-stickers"></i>
    </h1>
    <div class="pure-g pure-g-preview" data-id="preview">
        @foreach($mainChildItems as $item)
            @if($item->show_in_main)
                <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                    <a href="/{{$item->url}}" class="preview">
                        <div class="preview__img">
                            <img src=
                             @isset($item->imageFile)
                                 "{{asset($item->imageFile->path)}}"
                            @else
                                "{{asset('images/icon/icon-preview.svg')}}"
                            @endisset
                            alt="icon preview">
                        </div>
                        <span class="preview__name">{{$item->page_title}}</span>
                        @isset($item->min_price)
                            <span class="preview__price">от {{$item->min_price}} ₽</span>
                        @endisset
                    </a>
                </div>
            @endif
        @endforeach
    </div>

    <button class="show-more" type="button" data-btn="show-more">
        Показать все категории
    </button>

    <!-- Slider main container -->
    <div class="swiper-container swiper-mobile">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide">
                <div class="examples">
                    <a class="examples__link" href="">
                        <div class="examples__content">
                            <div class="examples__title">НОВИНКА!</div>
                            <div class="examples__text">Печать этикеток  на рулоне&nbsp;→</div>
                        </div>
                        <img src="{{asset('images/examples/3.jpg')}}" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="examples">
                    <a class="examples__link" href="">
                        <div class="examples__content">
                            <div class="examples__text">Печать на радужной пленке «Хром бензин»&nbsp;→</div>
                        </div>
                        <img src="{{asset('images/examples/3.jpg')}}" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="examples">
                    <a class="examples__link" href="">
                        <div class="examples__content">
                            <div class="examples__text">Скидка  на второй заказ&nbsp;→</div>
                        </div>
                        <div class="examples__promo-text">-10%</div>
                        <img src="{{asset('images/examples/2.jpg')}}" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="examples">
                    <a class="examples__link" href="">
                        <div class="examples__content">
                            <div class="examples__title">Печать фольгой</div>
                            <div class="examples__text">Больше 20-ти цветов  для нанесения&nbsp;→</div>
                        </div>
                        <img src="{{asset('images/examples/1.jpg')}}" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="examples">
                    <a class="examples__link" href="">
                        <div class="examples__content">
                            <div class="examples__text">Конструктор макетов&nbsp;→</div>
                        </div>
                        <img src="{{asset('images/examples/2.jpg')}}" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>
