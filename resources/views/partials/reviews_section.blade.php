<section>
    <div class="container">
        <h2 class="block-title block-title_center">
            <a class="link link_arrows-top" href="[~3025~]"><span>Отзывы клиентов</span></a>
        </h2>
        <!-- Slider main container -->
        <div class="swiper-container swiper-reviews">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                @foreach($reviews as $review)
                    <div class="swiper-slide">
                        <div class="reviews">
                            <div class="reviews__top">
                                <img class="reviews__img" src="{{ $review['image'] }}" alt="photo">
                                <div class="reviews__author">{{ $review['author'] }}</div>
                            </div>
                            <div class="reviews__text">
                                <p>
                                    {!! $review['legend'] !!}
                                </p>
                            </div>
                            <img src="{{ $review['logo'] }}" class="reviews__logo" alt="logo company">
                        </div>
                    </div>
                @endforeach


            </div>
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev">
                <img src="new-theme/images/icon/icon-arrows-l.svg" alt="arrows left">
            </div>
            <div class="swiper-button-next">
                <img src="new-theme/images/icon/icon-arrows-r.svg" alt="arrows right">
            </div>
        </div>
    </div>
</section>