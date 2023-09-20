export default class extends window.Controller {
    static values = {
        requestmethod: String,
        field: String,
        indeterminate: Boolean,
        url: String
    };

    connect() {
        const checkbox = this.element.querySelector('input:not([hidden])');

        if (checkbox) {
            checkbox.indeterminate = this.indeterminateValue;

            checkbox.addEventListener('change', () => {
                window.axios.request({
                    method: this.requestmethodValue,
                    url: this.urlValue,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: {
                        field: this.fieldValue,
                        content: checkbox.checked
                    }
                });
            });
        }
    }
}
