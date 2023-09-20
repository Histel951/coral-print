<div class="container">
    <div class="pure-g pure-g_advantages">
        @if(isset($advantages) && is_iterable($advantages))
            @foreach($advantages as $advantage)
                <div class="pure-u-1 pure-u-md-1-2">
                    <div class="advantages">
                        <div class="advantages__media">
                            <picture>
                                <source srcset="{{ $advantage->image?->url() }}" media="(min-width: 1280px)">
                                <img src="{{ $advantage->image?->url() }}" alt="advantages images">
                            </picture>
                        </div>
                        <div class="advantages__text">
                            <h2>{{ $advantage->title }}</h2>
                            {!! $advantage->description !!}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
