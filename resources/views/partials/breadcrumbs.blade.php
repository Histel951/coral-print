<div class="hidden visible-md hidden-lg visible-xl">
    <div class="container">
        <ul class="breadcrumbs">
            <li><a href="/">Главная</a></li>
            <li><a href="/">Продукция</a></li>
            @foreach($breadCrumbsArr as $item)
                <li>
                    @if($content->url != $item['url'])
                        <a href="{{URL::to($item['url'])}}">{{$item['title']}}</a>
                    @else
                        {{$item['title']}}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="hidden-md visible-lg hidden-xl">
    <div class="container">
        <ul class="breadcrumbs">
            <li><a href="/" >← Продукция</a></li>
        </ul>
    </div>
</div>
