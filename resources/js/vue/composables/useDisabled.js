import {ref, watchEffect} from "vue";
import useForm from "@/composables/useForm";

export default (disableds) => {
    const isDisabled = ref(false);
    const disabledDefaultValue = ref(null);
    const {form} = useForm();

    if (disableds) {
        disableds.forEach(disable => {
            if (disable.type === 'width_height') {
                watchEffect(() => {
                    const formBigger = form.height > form.width ? form.height : form.width;
                    const formMin = form.height > form.width ? form.width : form.height;

                    isDisabled.value = !(formBigger <= disable.bigger && formMin <= disable.min);

                    if (isDisabled.value) {
                        disabledDefaultValue.value = disable.default;
                    }
                });
            }
        });
    }

    return {
        isDisabled,
        disabledDefaultValue
    };
};
