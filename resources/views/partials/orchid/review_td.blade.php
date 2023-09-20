<td style="background:
@switch($repository->status)
    @case(\App\Services\ReviewService::STATUS_NEW)
        DeepSkyBlue
    @break
    @case(\App\Services\ReviewService::STATUS_REJECTED)
        pink
    @break
@endswitch
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
