import {onBeforeMount, ref} from "vue";
import useForm from "@/composables/useForm";
import useInitData from "@/composables/useInitData";

const {addFieldValue, form} = useForm();

const optionsList = ref({});
const optionActive = ref({});
const selectData = ref({});

const setOptions = (options) => {
    options.forEach(option => {
        if (typeof option.active === 'undefined') {
            option.active = false;
        }

        return option;
    });

    optionsList.value = options;
};

const setActiveOption = (option) => {
    optionsList.value.forEach(optionList => {
        if (option.id === optionList.id) {
            optionActive.value = option;
            optionList.active = true;
        } else {
            optionList.active = false;
        }

        return optionList;
    });
}

const setData = (fieldName, defaultValue = null) => {

    if (defaultValue) {
        addFieldValue(fieldName, defaultValue);
        return;
    }

    const {getData} = useInitData();

    const data = getData(fieldName);
    if (data) {
        if (data.data) {
            addFieldValue(fieldName, data.data[0].id);
            return;
        }

        if (data[0]) {
            if (data[0].items) {
                addFieldValue(fieldName, data[0].items[0].id);
            } else {
                addFieldValue(fieldName, data[0].id);
            }
        }
    }
}

const onMountDefaultOptions = (closure) => {
    onBeforeMount(() => {
        if (optionsList.value.length) {
            // дефолтные значения для полей
            optionsList.value.forEach(option => {
                if (typeof option.fields === 'object') {
                    option.fields = Object.values(option.fields);
                }

                option.fields.forEach(field => {
                    if (field.formField) {
                        if (!form[field.formField]) {
                            setData(field.formField)
                        }
                    } else {
                        if (!form[field.dataField]) {
                            setData(field.dataField);
                        }
                    }

                });
                option.checkboxes.forEach(checkboxes => addFieldValue(checkboxes.formField, checkboxes.default));

                return option;
            });

            setActiveOption(optionsList.value[0]);
            closure();
        }
    });
}

export default () => ({
    optionsList,
    optionActive,
    selectData,
    setOptions,
    setActiveOption,
    onMountDefaultOptions,
});
