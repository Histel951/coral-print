@foreach ($stickers as $sticker)
    <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-1-3">
        <div class="shop-card">
            <a href="@makeUrl($sticker['id'])" class="shop-card__img">
                @if(strpos($sticker['tag_search_vert'], '18+') !== false && !isset($_COOKIE['adult_accept']) || strpos($sticker['tag_search_vert'], '18+') !== false && isset($_COOKIE['adult_denied']))
                    <img src="/theme3/images/st-shop/slider/18plus.jpg" alt="">
                @else
                    <img src="{{ array_shift($sticker['stickerpack_images'])['image'] }}" alt="photo">
                @endif
            </a>
            <a href="@makeUrl($sticker['id'])" class="shop-card__name">
                {{ $sticker['market_product_type'] }} «{{ $sticker['pagetitle'] }}»
            </a>
            <div class="shop-card__desc">
                <div class="shop-card__autor">
                    <a href="#" class="authorLink"
                       data-value="{{ $sticker['authorName'] }}">{{ '@'.$sticker['authorName'] }},</a>
                    <span class="shop-card__number">@if(isset($start)){{ $start }} @else {{ $loop->iteration }} @endif из {{ $allStickersCount }}</span>
                </div>
                <div class="shop-card__price sticker-price_card">
                    <div class="sticker-price__sale">
                        <span class="sticker-price__prev">{{ $sticker['market_item_fake_price'] }} руб</span>
                        <div class="sticker-price__percent"><span>– 40%</span></div>
                    </div>
                    <span class="sticker-price__next">{{ $sticker['stickerpack_price'] }} руб</span>
                </div>
            </div>
        </div>
    </div>
    @php if(isset($start)){++$start;} @endphp

@endforeach