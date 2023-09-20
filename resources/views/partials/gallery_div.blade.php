<div class="pure-g pure-g_plate">
    @php
        $index = -1;
        $count = 0;
    @endphp
    @foreach($galleries as $gallery)
        @foreach($gallery as $key => $file)
            @php
                if (!($key % 4)) $index = intdiv($key, 4) * 4 + rand(0, 3);
            @endphp
            <div class="pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4">
                <div class="examples">
                    <a
                        @class([
                            'gallery__link',
                            array_rand(array_flip(['circle', 'decagon', ''])) => $loop->index == $index
                        ])
                        href="#gallery-header"
                        data-item-num="{{ $count + $loop->index }}"
                        >
                        <img
                            src="{{ $file->src }}"
                            alt="{{ $file->alt }}"
                            class="examples__img"
                            data-micromodal-trigger="gallery-modal"
                            >
                    </a>
                </div>
            </div>
            @php
                if ($loop->last) $count += $loop->index + 1;
            @endphp
        @endforeach
    @endforeach
</div>
