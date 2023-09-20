@component($typeForm, get_defined_vars())
    <div data-controller="input"
         data-input-mask="{{$mask ?? ''}}"
    >
        <div>
            <input {{ $attributes }} style="background-color: {{ $attributes['value'] }};">
        </div>
    </div>
@endcomponent
