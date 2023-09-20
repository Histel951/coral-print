import {ref} from "vue";

const disabledFields = ref({});

const disabledItems = ref({});
const allCheckDisabledItems = ref({});
const disabledActions = ref({});

const disableField = (fieldName, condition, status) => {

    if (!disabledFields.value[fieldName]) {
        disabledFields.value[fieldName] = {};
    }

    if (!disabledFields.value[fieldName].conditions) {
        disabledFields.value[fieldName].conditions = [];
    }

    if (!disabledFields.value[fieldName].conditions.filter(el => el.name === condition).length) {
        disabledFields.value[fieldName].conditions.push({
            name: condition,
            status
        });
    } else {
        disabledFields.value[fieldName].conditions.forEach(el => {
            if (el.name === condition) {
                el.status = status;
            }

            return el;
        });
    }
};

const disableAction = (fieldName, value = true) => {
    disabledActions.value[fieldName] = value;
};

const dropAction = (fieldName) => {
    if (disabledActions.value[fieldName]) {
        delete disabledActions.value[fieldName];
    }
}

const dropDisabledItems = () => {
    disabledItems.value = {};
};

const disableItems = (field, items, relatedField = null) => disabledItems.value[field] = {items, relatedField};

const dropDisabledItemsByField = (field) => {
    delete disabledItems.value[field];
};

export default () => ({
    disableField,
    disableItems,
    dropDisabledItems,
    disabledItems,
    disabledFields,
    allCheckDisabledItems,
    dropDisabledItemsByField,
    disableAction,
    disabledActions,
    dropAction
});
