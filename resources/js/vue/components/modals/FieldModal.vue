<template>
  <ModalOverlay v-if="opened" :on-click="onClose">
    <ModalPanel v-if="!isLoading" :size="size" :full-height="fullHeight" :typeModal="typeModal">
        <ModalHeader
          :size="size"
          :fixed="fullHeight"
          :title="title"
          :on-close="onClose"
          :style="headerStyles"
          :text-style="headerTextStyles"
          :typeModal="typeModal"
          :header-close-classes="headerCloseClasses"
        />
        <slot/>
    </ModalPanel>
    <Preloader
      :styles="{
        position: 'absolute',
        top: '50%',
        left: '50%'
      }"
      v-else
    />
  </ModalOverlay>
</template>

<script>
import ModalOverlay from "./ModalOverlay";
import ModalPanel from "./ModalPanel";
import ModalHeader from "./ModalHeader";
import Preloader from "../Preloader";

export default {
  name: "FieldModal",
  props: {
    isLoading: {
      type: Boolean,
      default: false
    },
    opened: {
      type: Boolean,
      default: false
    },
    title: String,
    onClose: Function,
    size: String,
    fullHeight: {
      type: Boolean,
      default: false
    },
    headerStyles: {
      type: Object,
      default: () => {}
    },
    headerTextStyles: {
      type: Object,
      default: () => {}
    },
    typeModal: String,
    headerCloseClasses : String,
  },
  components: {Preloader, ModalPanel, ModalOverlay, ModalHeader}
}
</script>
