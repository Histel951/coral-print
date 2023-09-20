@if(isset($reviews))
    <div class="reviews-stat">
        <div class="reviews-stat__item">
            <div class="reviews-stat__num">{{$reviews['count']}}</div>
            <div class="reviews-stat__label">Отзыва от клиентов</div>
        </div>
        <div class="reviews-stat__item">
            <div class="reviews-stat__num">{{$reviews['total_rate']}} / {{$reviews['total_stars']}}</div>
            <div class="rate rate_center reviews-stat__rate">
                @include('partials.reviews.stars', ['stars'=>$reviews['total_stars']])
            </div>
        </div>
    </div>
@endif
