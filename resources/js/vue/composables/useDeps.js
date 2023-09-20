import {ref, onBeforeMount, onBeforeUnmount, watchEffect} from 'vue';
import useForm from "@/composables/useForm";

const {form} = useForm();

const configDeps = ref({});
const activeDeps = ref({});

const setConfigDeps = (configs) => {
    configDeps.value = configs;
};

const setActiveDeps = (fieldName, data) => activeDeps.value[fieldName] = data;

let watcher = null;
export default () => {

    onBeforeMount(() => {
        if (watcher) {
            return;
        }

        watcher = watchEffect(() => {
            if (!configDeps.value) {
                return;
            }

            Object.keys(configDeps.value).forEach(fieldName => {
                let setterFlag = false;
                configDeps.value[fieldName].some(depsItem => {
                    let conditionChecker = {
                        conditionsLength: Object.keys(depsItem.conditions).length,
                        checks: []
                    };
                    Object.keys(depsItem.conditions).some(conditionFieldName => {
                        conditionChecker.checks.push(form[conditionFieldName] == depsItem.conditions[conditionFieldName]);
                        setterFlag = !conditionChecker.checks.includes(false)
                            && conditionChecker.conditionsLength === conditionChecker.checks.length;

                        return setterFlag;
                    });

                    if (setterFlag) {
                        setActiveDeps(fieldName, depsItem.values);
                        return true;
                    }
                });
            });
        });
    });

    onBeforeUnmount(() => {
        if (watcher) {
            watcher();
            watcher = null;
        }
    });

    return {
        configDeps,
        activeDeps,
        setConfigDeps,
        setActiveDeps
    };
};
