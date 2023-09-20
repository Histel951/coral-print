import {ref} from "vue";

const data = ref({});
const setData = (newData) => {
  data.value = newData;
}
const getData = (fieldName) => {
    return data.value[fieldName]
};

export default () => {

  return {
    setData,
    getData,
      data
  };
};
