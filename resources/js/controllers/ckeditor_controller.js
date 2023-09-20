export default class extends window.Controller {
    connect() {
        CKEDITOR.replace('ckeditor', {
            height: '500px'
        });
    }
}
