import { createApp } from 'vue';
import { createStore } from 'vuex';

import fm from 'laravel-file-manager/src/store';
import FileManager from 'laravel-file-manager/src/FileManager.vue';

/**
 * @typedef {{basename: string, dirname: string, path: string, timestamp: number, type: 'dir', visibility: string}} SelectedDir
 * @typedef {{basename: string, dirname: string, extension: string, filename: string, path: string, size: number, timestamp: number, type: 'file', visibility: string}} SelectedFile
 * @typedef {CustomEvent<{files: (SelectedFile|SelectedDir)[]}>} SelectedEvent
 */
export default class extends window.Controller {
    static values = {
        url: String,
        csrfToken: String,
    };

    static targets = ['appElement'];

    /**
     * @type {import('vue').App<HTMLElement>}
     */
    application;

    connect() {
        const store = createStore({
            strict: false,
            modules: { fm },
        });;

        const settings = {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': this.csrfTokenValue,
            },
            baseUrl: this.urlValue,
            lang: 'ru',
            // mode: 'insert' // на будущее
        };

        this.application = createApp(FileManager, { settings }).use(store);

        this.application.mount(this.appElementTarget);
    }

    disconnect() {
        this.application.unmount();
        this.application = null;
    }
}
