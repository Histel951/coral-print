<td style="background:
@if(!$repository->is_active)
    pink;
@endif
;" class="
 @if(!$width) text-truncate @endif
 @if(!$wrap) text-nowrap @endif
 "
    data-column="{{ $slug }}" colspan="{{ $colspan }}"
    @empty(!$width)style="width:{{ is_numeric($width) ? $width . 'px' : $width }}"@endempty
>
    <div>
        @isset($render)
            {!! $value !!}
        @else
            {{ $value }}
        @endisset
    </div>
</td>
