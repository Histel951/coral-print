@component($typeForm, get_defined_vars())
    <div data-controller="quillCode"
         data-quillCode-toolbar='@json($toolbar)'
         data-quillCode-base64='@json($base64)'
         data-quillCode-value='@json($value)'
         data-quillCode-language="{{$language}}"
         data-quillCode-default-Theme="{{$defaultTheme}}"
         data-quillCode-groups="{{$attributes['groups'] ?? ''}}"
         data-theme="{{$theme ?? 'inlite'}}"
    >
        <div id="toolbar"></div>
        <div class="code quill p-3 position-relative" id="quill-wrapper-{{$id}}"
             style="min-height: {{ $attributes['height'] }}">
        </div>
        <input class="d-none" {{ $attributes }}>
    </div>
@endcomponent
