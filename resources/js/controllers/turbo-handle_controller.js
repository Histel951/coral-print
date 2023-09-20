export default class extends window.Controller {

    static values = {
        requestmethod: String,
        url: String
    };

    async handle(event) {
        try {
            this.element.disabled = true;

            const response = await window.axios.request({
                method: this.requestmethodValue,
                url: this.urlValue,
                headers: {
                    Accept: "text/vnd.turbo-stream.html, text/html, application/xhtml+xml"
                }
            });

            if (response.status !== 200) {
                throw new Error(`Ошибка: ${response.status}`);
            }

            window.Turbo.renderStreamMessage(await response.data);
        } catch (error) {
            console.error(error)
        } finally {
            this.element.disabled = false;
        }

        event.preventDefault();
    }
}
