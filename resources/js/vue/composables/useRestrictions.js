import {ref} from 'vue';

const restrictions = ref({});
const allowables = ref({});

const setRestriction = (fields, message, active = true, maxSize = 0, minSize = 0) => {
    if (fields) {
        fields.forEach(field => {
            restrictions.value[field] = {message, active, maxSize, minSize};
        });
    }
};

const allowableRestriction = (fields, message, active) => {
    if (fields) {
        fields.forEach(field => {
            allowables.value[field] = {message, active};
        });
    }
};

export default () => ({
    restrictions,
    setRestriction,
    allowables,
    allowableRestriction
});
