<div class="p-review">
    <div class="p-review__top">
        <img src="{{$review['file']['path']}}" alt="" class="p-review__avatar">
        <div class="p-review__top-content">
            <div class="p-review__head">
                <div class="rate p-review__rate">
                    @include('partials.reviews.stars', ['stars'=>$review['rate']])
                </div>
                <div class="p-review__title">{{$review['title']}}</div>
            </div>
            <div class="p-review__info">
                <div class="p-review__author">{{$review['name']}}</div>
                <div class="p-review__date">{{date('d.m.Y h:m:s', strtotime($review['created_at']))}}</div>
            </div>
        </div>
    </div>
    <div class="p-review__text">
        <p>{{$review['comment']}}.</p>
    </div>
</div>