/**
 * @typedef {import('./file-manager').SelectedEvent} SelectedEvent
 * @typedef {import('./file-manager').SelectedFile} SelectedFile
 * @typedef {{ id: null | number, alt: string, description: string, path: string, basename: string}} FileObject
 */
export default class extends window.Controller {
    static targets = [
        'input',
        'template',
        'container',
        'file',
        'modal',
        'alt',
        'description',
    ];

    static values = {
        data: Array,
        activeFile: {
            type: Number,
            default: -1,
        }
    }

    connect() {
        for (const fileObject of this.dataValue) {
            this.renderFile(fileObject);
        }
    }

    /**
     *
     * @param {Number} value
     * @param {Number|undefined} previousValue
     */
    dataValueChanged(value, previousValue) {
        if (typeof previousValue === 'undefined' && this.inputTarget.value.trim() !== '') {
            this.dataValue = JSON.parse(this.inputTarget.value);
        }

        this.inputTarget.value = JSON.stringify(this.dataValue);
    }

    /**
     * @param {Event} event
     */
    editFileAttributes(event) {
        this.dispatchCurrentFileHtmlElement(event, (element, index) => {
            this.activeFileValue = index;

            this.modalData = this.dataValue[index];

            this.modal.show();
        });
    }

    /**
     * @param {Event} event
     */
    unselectFile(event) {
        this.dispatchCurrentFileHtmlElement(event, (element, index) => {
            this.setState((dataValue) => {
                dataValue.splice(index, 1)
            })

            element.remove();
        })
    }

    /**
     * @param {Event} event
     * @param {(element: HTMLElement, index: Number) => void} callback
     */
    dispatchCurrentFileHtmlElement(event, callback) {
        for (let index = 0; index < this.fileTargets.length; index++) {
            /** @type {HTMLElement} */
            const element = this.fileTargets[index];

            if (!element.contains(event.currentTarget)) {
                continue;
            }

            callback(element, index);

            break;
        }
    }

    /**
     * @param {Event} event
     */
    modalClosed(event) {
        this.modalData = {}
        this.activeFileValue = -1;
    }

    /**
     * @param {Event} event
     */
    updateSelected(event) {
        if (this.activeFileValue > -1) {
            this.setState(dataValue => dataValue[this.activeFileValue] = { ...dataValue[this.activeFileValue], ...this.modalData });
        }

        this.modal.hide();
    }

    /**
     * @param {SelectedEvent} event
     */
    dispatchSelected({ detail: { files } }) {
        for (const element of files) {
            if (element.type === 'dir') {
                continue;
            }

            if (this.dataValue.some((file) => element.path === file.path)) {
                continue;
            }

            this.addSelectedFile(element);
        }
    }

    /**
     * @param {SelectedFile} file
     */
    addSelectedFile(file) {
        /** @type {FileObject} */
        const fileObject = {
            id: null,
            alt: '',
            description: '',
            basename: file.basename,
            path: file.path,
        };

        this.renderFile(fileObject);
        this.setState(dataValue => dataValue.push(fileObject));
    }

    /**
     * @param {FileObject} fileObject
     */
    renderFile(fileObject) {
        /** @type {HTMLTemplateElement} */
        const template = this.templateTarget;

        this.containerTarget.insertAdjacentHTML(
            'beforeend',
            this.replaceData(
                template.innerHTML,
                fileObject,
            )
        );

    }

    /**
     * @param {string} template
     * @param {{[key as string]: string}} data
     * @returns
     */
    replaceData(template, data) {
        const regex = new RegExp(':(' + Object.keys(data).join('|') + ')', 'g');
        return template.replace(regex, (m, $1) => data[$1] || m);
    }

    /**
     * @param {(dataValue: FileObject[]) => void} callback
     */
    setState(callback) {
        const dataValue = this.dataValue;
        callback(dataValue);
        this.dataValue = dataValue;
    }

    /**
     * @param {Event} event
     */
    removeImgElement({ target }) {
        target.remove();
    }

    disconnect() {
        this.modal.dispose()
    }

    get modalData() {
        return {
            alt: this.altTarget.value,
            description: this.descriptionTarget.value,
        }
    }

    set modalData({ alt = '', description = '' } = {}) {
        this.altTarget.value = alt;
        this.descriptionTarget.value = description;
    }

    /**
     * @return {import('bootstrap').Modal}
     */
    get modal() {
        return window.Bootstrap.Modal.getOrCreateInstance(this.modalTarget);
    }
}

