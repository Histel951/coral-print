export default class extends window.Controller {
    static values = {
        contenteditable: Boolean,
        url: String,
        requestmethod: String,
        field: String
    };

    value = '';

    connect() {
        this.value = this.element.textContent;

        if (!this.element.innerHTML) {
            this.element.innerHTML = "&nbsp;";
        }
    }

    onFocus() {
        this.element.style.backgroundColor = '#f6f6f6';
    }

    async onFocusOut() {
        this.element.style.backgroundColor = '';

        try {
            const content = this.element.textContent;

            if (this.value !== content) {
                this.element.style.opacity = '0.4';
                this.element.setAttribute('contenteditable', false);
                await window.axios.request({
                    method: this.requestmethodValue,
                    url: this.urlValue,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: {
                        field: this.fieldValue,
                        content
                    }
                });

                this.element.setAttribute('contenteditable', true);
                this.value = content;
                this.element.style.opacity = '1';


            }
        } catch (e) {
            console.error(e);
        }
    }
}
