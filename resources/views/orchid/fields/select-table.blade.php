@component($typeForm, get_defined_vars())
    <div data-controller="selectTable"
         data-selectTable-default-value="{{ $default }}"
         data-selectTable-url-value="{{ $url }}"
         data-selectTable-field-value="{{ $field }}"
         data-selectTable-requestmethod-value="{{ $requestmethod }}"
    >
        <div class="option-value" data-itemId="{{ $itemId }}">

        </div>
        <div class="options-container" data-itemId="{{ $itemId }}">
            @foreach($options as $key => $option)
                <div class="option" @isset($value)
                    @if (is_array($value) && in_array($key, $value)) data-selected="true"
                     @elseif (isset($value[$key]) && $value[$key] == $option) data-selected="true"
                     @elseif (!$isOptionList && $key == $value) data-selected="true"
                    @endif
                    @endisset
                    data-value="{{ $key }}"
                >
                {{ $option }}
                </div>
            @endforeach
        </div>
    </div>
@endcomponent
