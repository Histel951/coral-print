@component($typeForm, get_defined_vars())
    <div data-controller="input"
         data-input-mask="{{$mask ?? ''}}"
    >
        <div style="
          display: inline-block;
          border: 1px solid rgba(28,43,54,.1);
          border-radius: 4px;
          margin-bottom: 10px;
          padding: 10px;
          ">
            <svg>
                <use xlink:href="#{{ $attributes['value'] }}"></use>
            </svg>
        </div>
        <div>
            <input {{ $attributes }}>
        </div>
    </div>
@endcomponent
