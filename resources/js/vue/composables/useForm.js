import {reactive} from "vue";

const form = reactive({});
const addFieldValue = (fieldName, value = '') => {
  form[fieldName] = value;
}
const removeField = (fieldName) => {
  delete form[fieldName];
}

export default () => {

  return {
    removeField,
    addFieldValue,
    form
  };
};
