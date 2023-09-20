export default class extends window.Controller {

    /**
     * Значение отправляемое в запрос в виде значения
     * @type {null}
     */
    value = null;

    /**
     * Текст выбранного значения в поле
     * @type {string}
     */
    toggleText = '';

    /**
     * Состояние блокировки селекта
     * @type {boolean}
     */
    isBlockedSelect = false;

    static values = {
        default: Number,
        requestmethod: String,
        url: String,
        field: String
    };

    connect() {
        this.value = this.defaultValue;
        const optionsContainer = this.element.querySelector('div.options-container');
        const toggle = this.element.querySelector('div.option-value');

        this.clickOutsideElements([optionsContainer, toggle], () => {
            if (optionsContainer.style.display !== 'none') {
                optionsContainer.style.display = 'none';
            }
        });

        this.toggleClick(toggle, optionsContainer);

        this.logic(toggle, optionsContainer, async () => {
            this.blockToggle(toggle);
            await window.axios.request({
                method: this.requestmethodValue,
                url: this.urlValue,
                data: {
                    content: this.value,
                    field: this.fieldValue
                },
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            this.blockToggle(toggle, false);
        });
    }

    /**
     * Логика работы селекта, можно передать обработчик клика на опцию {onClickOption}
     * @param toggle
     * @param optionsContainer
     * @param onClickOption
     */
    logic(toggle, optionsContainer, onClickOption = () => {}) {
        optionsContainer.childNodes.forEach(child => {

            if (!this.isDiv(child)) {
                return;
            }

            if (child.dataset.value == this.value) {
                this.toggleText = child.textContent;
                toggle.textContent = this.toggleText;
            }

            child.addEventListener('click', e => {
                if (this.isBlockedSelect) {
                    return;
                }

                optionsContainer.style.display = 'none';
                e.target.style.backgroundColor = '#f4f4f4';
                e.target.dataset.selected = 'true';
                this.value = e.target.dataset.value;
                this.toggleText = e.target.textContent;

                toggle.textContent = this.toggleText;

                onClickOption(e.target);

                e.target.parentNode.childNodes.forEach(el => {
                    if (!this.isDiv(el)) {
                        return;
                    }

                    if (el.dataset.value !== this.value) {
                        el.style.backgroundColor = '#fff';

                        if (el.dataset.selected === 'true') {
                            delete el.dataset.selected;
                        }
                    }
                });
            });
        });
    }

    blockToggle(toggle, value = true) {
        this.isBlockedSelect = value;

        if (value) {
            toggle.style.opacity = '0.4';
        } else {
            toggle.style.opacity = '1';
        }
    }

    /**
     * Срабатывает при клике за пределами переданных элементов
     * @param elements
     * @param callback
     */
    clickOutsideElements(elements, callback) {
        document.addEventListener('click', e => {
            let checksOutside = [];

            elements.forEach(element => {
                checksOutside.push(e.composedPath().includes(element));
            });

            if (!checksOutside.includes(true)) {
                callback(e);
            }
        });
    }

    /**
     * Логика отображения опций
     * @param toggle
     * @param optionsContainer
     */
    toggleClick(toggle, optionsContainer) {
        toggle.addEventListener('click', () => {
            if (this.isBlockedSelect) {
                return;
            }

            if (optionsContainer.style.display === 'block') {
                optionsContainer.style.display = 'none';
            } else {
                optionsContainer.style.display = 'block';
            }
        });
    }

    isDiv(el) {
        return el.nodeName === 'DIV';
    }
}
