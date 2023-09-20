<template>
  <ModalOverlay v-if="activeModal===name" :on-click="closeModal">
    <ModalPanel :size="size" :full-height="fullHeight">
      <ModalHeader :size="size" :fixed="fullHeight" :title="title" :on-close="closeModal"/>
      <slot/>
    </ModalPanel>
  </ModalOverlay>
</template>

<script>
import useModal from "../../composables/useModal";
import ModalOverlay from "./ModalOverlay";
import ModalPanel from "./ModalPanel";
import ModalHeader from "./ModalHeader";

export default {
  name: "Modal",
  props: {
    name: {
      type: String,
      required: true
    },
    title: String,
    size: String,
    fullHeight: {
      type: Boolean,
      default: false
    }
  },
  components: {ModalHeader, ModalPanel, ModalOverlay},
  setup() {
    const {activeModal, closeModal} = useModal();

    return {
      activeModal,
      closeModal
    }
  }
}
</script>
