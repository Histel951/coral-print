<div class="pure-g pure-g_plate" data-doc="{{$doc}}" data-offset="{{$offset}}">
    @foreach($gallery as $item)
        <div class="pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4">
            <div class="examples @if($loop->iteration===2)decagon @elseif($loop->iteration===7) circle @endif">
                <a class="examples__link" href="">
                    <img src="{{$item['image']}}" alt="{{$item['alt']}}" class="examples__img">
                </a>
            </div>
        </div>
    @endforeach
    @if(isset($video) && !empty($video))
        <div class="pure-u-1 pure-u-md-2-3 pure-u-lg-1-2">
            <div class="examples video">
                <a class="video__link" href="https://www.youtube.com/klb4w35rcas">
                    <picture>
                        <img class="video__media" src="https://i.ytimg.com/vi/klb4w35rcas/mqdefault.jpg"
                             alt="video youtube" data-src="{{$video}}">
                    </picture>
                </a>
                <button class="video__button" aria-label="Запустить видео">
                    <img src="new-theme/images/icon/icon-play.svg" alt="icon play">
                </button>
            </div>
        </div>
    @endif


</div>