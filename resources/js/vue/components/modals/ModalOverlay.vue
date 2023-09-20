<template>
  <div class="modal-overlay">
    <div class="modal-overlay__bg" @click="onClick"></div>
    <slot/>
  </div>
</template>

<script>
import {onBeforeMount, onBeforeUnmount} from "vue";

export default {
  name: "ModalOverlay",
  props: {
    onClick: Function
  },
  setup() {
    onBeforeMount(() => {
      document.body.classList.add('scroll-lock')
    })
    onBeforeUnmount(() => {
      document.body.classList.remove('scroll-lock')
    })
  }
}
</script>

<style lang="scss" scoped>
.modal-overlay {
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  z-index: 99;
  display: flex;
  overflow: auto;

  &__bg {
    background: #00195A;
    opacity: 0.7;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
  }
}
</style>
