@include('orchid.file-manager-modal')

@component($typeForm, get_defined_vars())
    <div
        data-controller="file-manager-selector"
        data-action="fm:insert@window->file-manager-selector#dispatchSelected"
        >
        <div
            class="d-flex flex-wrap gap-3"
            data-file-manager-selector-target="container"
            ></div>
        <input type="hidden" data-file-manager-selector-target="input" {{ $attributes }}>
        <template data-file-manager-selector-target="template">
            <div
                class="card p-1"
                style="width: 8rem"
                title=":basename"
                data-file-manager-selector-target="file"
                >
                <div class="ratio ratio-1x1">
                    <x-orchid-icon
                        width="2em"
                        height="2em"
                        path="doc"
                    />
                    <img
                        style="object-fit: cover; object-position: center;"
                        src="{{ url('storage/:path') }}"
                        alt=":basename"
                        data-action="error->file-manager-selector#removeImgElement"
                        >
                </div>
                <div class="overflow-hidden text-truncate text-nowrap fs-6">
                    <small>:basename</small>
                </div>
                <div class="d-flex justify-content-evenly">
                    <button
                        class="btn btn-link"
                        type="button"
                        data-action="file-manager-selector#editFileAttributes"
                        >
                        <x-orchid-icon
                            width="1em"
                            height="1em"
                            path="pencil"
                            />
                    </button>
                    <button
                        class="btn btn-link link-danger"
                        type="button"
                        data-action="file-manager-selector#unselectFile"
                        >
                        <x-orchid-icon
                            width="1em"
                            height="1em"
                            path="minus"
                            />
                    </button>
                </div>
            </div>
        </template>
        <div
            class="modal fade center-scale"
            data-file-manager-selector-target="modal"
            data-action="hidden.bs.modal->file-manager-selector#modalClosed"
            tabindex="-1"
            role="dialog"
            aria-hidden="false"
            >
            <div class="modal-dialog modal-fullscreen-md-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-black fw-light">
                            {{__('File Information')}}
                            <small class="text-muted d-block">{{__('Information to display')}}</small>
                        </h4>

                        <button
                            type="button"
                            class="btn-close"
                            title="Close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            ></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="form-group">
                            <label>{{ __('Alternative text') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                data-file-manager-selector-target="alt"
                                maxlength="255"
                                placeholder="{{  __('Alternative text')  }}"
                                >
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea
                                class="form-control no-resize"
                                data-file-manager-selector-target="description"
                                placeholder="{{ __('Description') }}"
                                maxlength="255"
                                rows="3"
                                ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            data-bs-dismiss="modal"
                            class="btn btn-link"
                            >
                                <span>
                                    {{__('Close')}}
                                </span>
                        </button>
                        <button
                            type="button"
                            data-action="file-manager-selector#updateSelected"
                            class="btn btn-default"
                            >
                            {{__('Apply')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcomponent
