<div class="main-head">
    <div class="container">
        <div class="text">
            <a href="@makeUrl($documentObject['parent'])" class="back">Назад к календарям</a>
            <h1>{{ $block['title'] }}</h1>
            <p>{!!  $block['tiny_description']  !!}</p>
        </div>
    </div>
    <div class="image">
        <img src="{{ $block['image'] }}" alt="">
    </div>
</div>