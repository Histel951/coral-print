
<td class="text-{{$align}}
@switch($repository->status)
    @case(\App\Services\CallService::STATUS_NEW)
        bg-info bg-gradient
    @break
    @case(\App\Services\CallService::STATUS_PROCESSED)
        bg-success bg-gradient
    @break
@endswitch
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
