import {ref} from "vue";

const activeModal = ref(null);

const openModal = (name) => {
  activeModal.value = name;
}

const closeModal = () => {
  activeModal.value = null
}

export default () => {

  return {
    openModal,
    closeModal,
    activeModal
  };
};
