<td class="text-{{$align}}
@if($repository->is_active)
        bg-success bg-gradient
@else
    bg-secondary bg-gradient
@endif
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
