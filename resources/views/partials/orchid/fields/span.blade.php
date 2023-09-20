@component($typeForm, get_defined_vars())
    <div
        class="span-container span-container-border"
        data-controller="spanController"
        data-spanController-contenteditable-value="{{ $contenteditable ?: 0 }}"
        contenteditable="{{ $contenteditable ? 'true' : 'false' }}"
        data-spanController-url-value="{{ $url }}"
        data-spanController-field-value="{{ $field }}"
        data-action="focusout->spanController#onFocusOut focus->spanController#onFocus"
        data-spanController-requestmethod-value="{{ $requestmethod }}"
        style="{{ $style }}"
        {{ $attributes }}
    >{!! $text ?? '' !!}</div>
@endcomponent
