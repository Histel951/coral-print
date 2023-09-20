<div
    data-controller="file-manager-modal"
    data-action="fm:insert@window->file-manager-modal#closeModal"
    data-file-manager-modal-url-value="{{ Str::finish(url('/file-manager/'), '/') }}"
    data-file-manager-modal-csrf-token-value="{{ csrf_token() }}"
    >
    <button
        class="btn btn-link"
        type="button"
        data-action="file-manager-modal#openModal"
        >
        <x-orchid-icon
            class="me-2"
            width="1em"
            height="1em"
            path="folder"
            />
        Файловый менеджер
    </button>

    <div
        class="modal fade center-scale"
        data-file-manager-modal-target="modal"
        data-action="
            hidden.bs.modal->file-manager-modal#modalHidden
            shown.bs.modal->file-manager-modal#modalShown
        "
        tabindex="-1"
        role="dialog"
        aria-hidden="false"
        >
        <div class="modal-dialog modal-fullscreen-md-down modal-lg">
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
                    <div data-file-manager-modal-target="appElement" style="height: 700px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
