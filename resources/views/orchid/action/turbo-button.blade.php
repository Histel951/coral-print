@component($typeForm, get_defined_vars())
    <button
        @if($disabled) disabled="disabled" @endif
        id="{{ $id }}"
        data-controller="turboHandle"
        type="button"
        class="{{ $class }}"
        data-action="turboHandle#handle"
        data-turboHandle-csrf-token="{{ csrf_token() }}"
        data-turboHandle-method-value="{{ $method }}"
        data-turboHandle-url-value="{{ $url }}"
        data-turboHandle-requestmethod-value="{{ $requestmethod }}"
    >
        {{ $name ?? '' }}

        @isset($icon)
            <x-orchid-icon :path="$icon" class="{{ empty($name) ?: 'me-2'}}"/>
        @endisset
    </button>
@endcomponent
