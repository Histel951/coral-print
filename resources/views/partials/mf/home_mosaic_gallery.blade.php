<div class="swiper-container swiper-mobile">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        @foreach($data as $item)
            <div class="swiper-slide">
                <div class="examples">
                    <a class="examples__link" href="@makeUrl($item['link'])">
                        <div class="examples__content">
                            @if(!empty($item['title']))
                                <div class="examples__title">{{$item['title']}}</div>
                            @endif
                            @if(!empty($item['arrow_title']))
                                <div class="examples__text">{{$item['arrow_title']}}&nbsp;→</div>
                            @endif
                        </div>
                        @if(!empty($item['promo']))
                            <div class="examples__promo-text">{{$item['promo']}}</div>
                        @endif
                        <img src="{{$item['image']}}" alt="{{$item['alt']}}" class="examples__img">
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>
</div>