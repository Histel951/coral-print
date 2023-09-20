<template>
  <span @click="openModal(modalName)"><slot/></span>
</template>

<script>
import useModal from "../../composables/useModal";

export default {
  name: "ModalLink",
  props: {
    modalName: {
      type: String,
      required: true
    }
  },
  setup() {
    const {openModal} = useModal();

    return {
      openModal
    }
  }
}
</script>
