import useForm from "@/composables/useForm";

const {form} = useForm();

const getParams = (fieldName, itemCheck) => {
    const values = Object.fromEntries(itemCheck.deps.map(item => [item, form[item]]));

    const prepareParams = () => new URLSearchParams(
        Object.fromEntries(
            [['field', fieldName]]
        )
    ).toString();

    const urlParams = prepareParams();

    let params;
    Object.keys(values).map(key => {
        if (!params) {
            params = `values[${key}]=${values[key] ?? null}&`;
        } else {
            params += `values[${key}]=${values[key] ?? null}&`;
        }
    });

    return `${urlParams}&${params}`;
};

export default () => ({
    getParams
});
