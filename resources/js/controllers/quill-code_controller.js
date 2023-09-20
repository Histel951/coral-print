import ApplicationController from "./application_controller";
import Quill from 'quill';
import CodeFlask from "codeflask";

export default class extends ApplicationController {
    /**
     *
     */
    connect() {
        const quill = Quill;
        const selector = this.element.querySelector('.quill').id;
        const input = this.element.querySelector('input');

        const options = {
            placeholder: input.placeholder,
            readOnly: input.readOnly,
            theme: 'snow',
            modules: {
                toolbar: {
                    container: this.containerToolbar(),
                },
            },
        };

        // Dispatch the event for customization and installation of plugins
        document.dispatchEvent(new CustomEvent('orchid:quill', {
            detail: {
                quill: quill,
                options: options
            }
        }));

        this.editor = new quill(`#${selector}`, options);

        // quill editor add image handler
        let isBase64Format = JSON.parse(this.data.get('base64'));
        if (! isBase64Format) {
            this.editor.getModule('toolbar').addHandler('image', () => {
                this.selectLocalImage();
            });
        }

        let value = JSON.parse(this.data.get("value"))

        // set value
        // editor.setText(input.value);
        this.editor.root.innerHTML = input.value = value;

        // save value
        this.editor.on('text-change', () => {
            input.value = this.editor.getText() ? this.editor.root.innerHTML : '';
            input.dispatchEvent(new Event('change'));
        });

        this.editor.getModule('toolbar').addHandler('color', (value) => {
            this.editor.format('color', this.customColor(value));
        });

        this.editor.getModule('toolbar').addHandler('background', (value) => {
            this.editor.format('background', this.customColor(value));
        });

        this.enableCodeSyntax(input);
    }

    enableCodeSyntax(input) {
        const flask = new CodeFlask(this.element.querySelector('.code'), {
            language: this.data.get('language'),
            defaultTheme: this.data.get('defaultTheme'),
            readonly: input.readOnly,
        });

        flask.updateCode(input.value);

        flask.onUpdate((code) => {
            input.value = code;
        });
    }

    containerToolbar() {
        const controlsGroup = {
            "media":  ['image', 'video'],
        }

        return JSON.parse(this.data.get("toolbar"))
            .map(tool => controlsGroup[tool]);
    }

    /**
     * Step1. select local image
     *
     */
    selectLocalImage() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.click();

        // Listen upload local image and save to server
        input.onchange = () => {
            const file = input.files[0];

            // file type is only image.
            if (/^image\//.test(file.type)) {
                this.saveToServer(file);
            } else {
                this.alert('Validation error', 'You could only upload images.', 'danger');
                console.warn('You could only upload images.');
            }
        };
    }

    /**
     * Step2. save to server
     *
     * @param {File} file
     */
    saveToServer(file) {
        console.log('lksad[paldspa');
        const formData = new FormData();
        formData.append('image', file);

        if (this.data.get('groups')) {
            formData.append('group', this.data.get('groups'));
        }

        axios
            .post(this.prefix('/systems/files'), formData)
            .then((response) => {
                console.log(response.data.url);
                this.insertToEditor(response.data.url);
            })
            .catch((error) => {
                this.alert('Validation error', 'Quill image upload failed');
                console.warn('quill image upload failed');
                console.warn(error);
            });
    }

    /**
     * Step3. insert image url to rich editor.
     *
     * @param {string} url
     */
    insertToEditor(url) {
        // push image url to rich editor.
        const range = this.editor.getSelection();
        console.warn('saldp[aldad');
        console.warn(range);
        this.editor.insertEmbed(range.index, 'image', url);
    }
}
