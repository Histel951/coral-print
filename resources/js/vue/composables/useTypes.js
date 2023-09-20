import {ref} from "vue";

const types = ref([]);
const activeType = ref(undefined);
const setTypes = (newTypes) => {
  activeType.value = newTypes[Math.max(0, newTypes.findIndex((v) => v.active))];
  types.value = newTypes;
}
const setActiveType = (newActiveType) => {
   document.querySelectorAll('.gallery-tabs__item').forEach((el) => {
     if (JSON.parse(el.dataset.calcs ?? '[]').includes(newActiveType.id)) {
       el.dispatchEvent(new Event('click'));
     }
   })
  localStorage.setItem('activeCalc', newActiveType.id);
  activeType.value = newActiveType;
}

export default () => {

  return {
    activeType,
    setActiveType,
    setTypes,
    types
  };
};
