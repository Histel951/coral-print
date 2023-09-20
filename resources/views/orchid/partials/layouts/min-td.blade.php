<td style="padding: 4px !important;" class="text-{{$align}} @if(!$width) text-truncate @endif"
    data-column="{{ $slug }}" colspan="{{ $colspan }}"
    @empty(!$width)style="min-width:{{ is_numeric($width) ? $width . 'px' : $width }};"@endempty
>
    <div style="{{ $style }}">
        @isset($render)
            {!! $value !!}
        @else
            {{ $value }}
        @endisset
    </div>
</td>
