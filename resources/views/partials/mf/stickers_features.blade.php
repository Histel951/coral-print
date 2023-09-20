<section class="section-advantages">
    <div class="container">
        <div class="pure-g pure-g_advantages">
            @foreach($data as $item)
            <div class="pure-u-1 pure-u-md-1-2">
                <div class="advantages">
                    <div class="advantages__media">
                        <picture>
                            <source srcset="{{$item['image_sm']}}" media="(min-width: 1280px)">
                            <img src="{{$item['image_md']}}" alt="{{$item['alt']}}">
                        </picture>
                    </div>
                    <div class="advantages__text">
                        <h2>{{$item['title']}}</h2>
                        <p>
                            {{$item['description']}}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>