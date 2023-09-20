import {ref} from "vue";

const windowWidth = ref(window.innerWidth);

window.addEventListener('resize', () => {
  windowWidth.value = window.innerWidth;
})

export default () => {

  return {
    windowWidth
  };
};
