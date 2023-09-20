@component($typeForm, get_defined_vars())
    <div data-controller="clearPicture"
         data-clearPicture-value="{{ $attributes['value'] }}"
         data-clearPicture-storage="{{ $storage ?? 'public' }}"
         data-clearPicture-target="{{ $target }}"
         data-clearPicture-url="{{ $url }}"
         data-clearPicture-max-file-size="{{ $maxFileSize }}"
         data-clearPicture-accepted-files="{{ $acceptedFiles }}"
         data-clearPicture-urlChange="{{ $urlChange }}"
         data-clearPicture-requestMethod="{{ $requestMethod }}"
         data-clearPicture-changeable="{{ $changeable }}"
         data-clearPicture-field="{{ $field }}"
         data-clearPicture-groups="{{$attributes['groups'] ?? ''}}"
    >
        <div class="border-dashed text-end p-3 picture-actions" @if($issmall) style="
        display: flex;
         justify-content: center;
          padding: 4px 0 !important;
          " @endif>
            <div>
                <div class="fields-picture-container">
                    <img @if($issmall) style="max-height: 90px; max-width: 100%" @endif src="#" class="picture-preview img-fluid img-full mb-2 border" alt="">
                </div>

                @if($changeable)
                    <div class="btn-group">
                        <label class="btn btn-default m-0">
                            <x-orchid-icon path="cloud-upload" class="me-2"/>

                            @if(!$issmall){{ __('Browse') }}@endif
                            <input type="file"
                                   accept="image/*"
                                   data-clearPicture-target="upload"
                                   data-action="change->clearPicture#upload"
                                   class="d-none">
                        </label>

                        @if($issmall)
                            <button type="button" class="btn btn-outline-danger picture-remove"
                                    data-action="clearPicture#clear"><x-orchid-icon path="admin.trash" /></button>
                        @else
                            <button type="button" class="btn btn-outline-danger picture-remove"
                                    data-action="clearPicture#clear">{{ __('Remove') }}</button>
                        @endif

                    </div>

                    <input type="file"
                           accept="image/*"
                           class="d-none">
            </div>
                @endif

            <input class="picture-path d-none"
                   type="text"
                   data-clearPicture-target="source"
                {{ $attributes }}
            >

        </div>
    </div>
@endcomponent
