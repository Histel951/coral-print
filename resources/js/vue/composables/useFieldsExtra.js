import {ref, watch} from 'vue';
import useFormSchema from "@/composables/useFormSchema";

const {calculator_id} = useFormSchema();
const extraLabels = ref({});
const extraHideTypes = ref({});
const extraPredefinedValue = ref({});

watch(calculator_id, () => {
    extraLabels.value = {};
    extraHideTypes.value = {};
    extraPredefinedValue.value = {};
});

const setExtraPredefinedValue = (value = false, fieldName) => {
    extraPredefinedValue.value[fieldName] = value;
};

const setExtraHideTypes = (isHideTypes = false, fieldName) => {
    extraHideTypes.value[fieldName] = isHideTypes;
};

const getExtraHideTypes = (fieldName) => extraHideTypes.value[fieldName];

const setExtraLabel = (label, fieldName) => {
    extraLabels.value[fieldName] = label;
};

const getExtraLabel = (fieldName) => extraLabels.value[fieldName];

export default () => ({
    extraLabels,
    extraHideTypes,
    setExtraHideTypes,
    getExtraHideTypes,
    setExtraLabel,
    getExtraLabel,
    extraPredefinedValue,
    setExtraPredefinedValue
});
