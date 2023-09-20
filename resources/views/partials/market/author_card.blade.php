<div class="slider-artist__item">
    <a href="#" class="slider-artist__link authorLink" data-value="{{ $author['authorName'] }}">
{{--    <a href="{{ $author['market_author_inst'] }}" class="slider-artist__link">--}}
        <img src="{{ $author['market_author_image'] }}" alt="" class="slider-artist__img">
        {{ '@'.$author['authorName'] }}
    </a>
</div>