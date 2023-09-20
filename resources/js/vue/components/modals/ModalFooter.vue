<template>
  <div :style="styles" :class="`modal-footer modal-footer_${align} modal-footer_${size}`">
    <slot/>
  </div>
</template>

<script>
export default {
  name: "ModalFooter",
  props: {
    align: {
      type: String,
      default: 'left'
    },
    size: {
      type: String,
      default: 'xs'
    },
    styles: {
      type: Object,
      default: () => {}
    }
  }
}
</script>

<style lang="scss" scoped>
.modal-footer {
  overflow: auto;
  flex: 0 0 auto;
  border-top: 1px solid #CCCCCC;
  display: flex;
  align-items: center;
  padding: 16px 16px;
  &_center {
    justify-content: center;
  }
}
@media all and (min-width: 768px) {
  .modal-footer {
    &_lg {
      padding: 28px 32px;
    }
  }
}
</style>
