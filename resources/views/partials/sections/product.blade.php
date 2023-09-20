<div class="container">
    <div class="need-labels" data-block="need-labels">
        <a href="#" class="need-labels__link">
            <div class="need-labels__text">
                <span class="need-labels__title">Нужны этикетки?</span>
                <span class="need-labels__title link_arrows">Это здесь</span>
            </div>
            <div class="need-labels__img">
                <img src="{{asset('images/icon/icon-labels.svg')}}" alt="icon-labels">
            </div>
        </a>
        <button class="need-labels__close " type="button" aria-label="Close" data-close="need-labels">
            <span class="plus"></span>
        </button>
    </div>
    <h1 class="page-title-product page-title_inner">{{$content->title}}</h1>
    <!-- Swiper -->
    <div class="swiper-container swiper-product">
        <div class="swiper-wrapper">
            @foreach($currentChildItems as $item)
                <div class="swiper-slide">
                    <a href="/{{$item->url}}" class="preview">
                        <div class="preview__img">
                            <img src="{{asset('images/icon/icon-preview.svg')}}" alt="icon preview">
                        </div>
                        <span class="preview__name">{{$item->title}}</span>
                        @isset($item->min_price)
                            <span class="preview__price">от {{$item->min_price}} ₽</span>
                        @endisset
                    </a>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>

</div>
<!-- Calculator -->
<div class="calculator">
    <div class="container">
        <div class="calculator__content"></div>
    </div>
</div>
