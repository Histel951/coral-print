<ul class="list-group">
@isset($title)
    <li class="nav-item mt-3 mb-1">
        <small class="text-muted ms-4 w-100 user-select-none">{{ __($title) }}</small>
    </li>
@endisset

@if (!empty($name))
    <li class="nav-item list-group-item p-1 {{ active($active) }}">
        <a class="p-1" data-turbo="{{ var_export($turbo) }}"
            {{ $attributes }}
        >
            @isset($icon)
                <x-orchid-icon :path="$icon" class="{{ empty($name) ?: 'me-2'}}"/>
            @endisset

{{--            <span class="me-2 p-1">{{ $name ?? '' }}</span>--}}

{{--                <img height="10" width="10" src="{{ asset('/images/icon/three_dots_vertical_icon_159806.png') }}">--}}
            @isset($badge)
                <b class="badge bg-{{$badge['class']}} col-auto ms-auto">{{$badge['data']()}}</b>
            @endisset
        </a>
    </li>
@endif

@if(!empty($list))
    <div class="nav collapse sub-menu {{active($active, 'show')}}"
         id="menu-{{$slug}}"
         data-bs-parent="#headerMenuCollapse">
        @foreach($list as $item)
            {!!  $item->build($source) !!}
        @endforeach
    </div>
@endif

@if($divider)
    <li class="divider my-2"></li>
@endif
</ul>
