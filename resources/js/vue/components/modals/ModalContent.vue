<template>
  <div class="modal-content" :style="styles" :class="classes">
    <slot/>
  </div>
</template>

<script>
export default {
  name: "ModalContent",
  props: {
    styles: {
      type: Object,
      default: () => {}
    },
    size: {
      type: String,
      default: 'xs'
    }
  },
  setup(props) {
    const classnames = () => {
      const classesArr = [];
      if (props.size) {
        classesArr.push(`modal-content_${props.size}`);
      }
      return classesArr.join(' ');
    }

    return {
      classes: classnames()
    }
  }
}
</script>

<style lang="scss" scoped>
.modal-content {
  padding: 10px 16px;
  overflow: auto;
  flex: 1 1 100%;
  min-height: 0;
  z-index: 200;
}

@media all and (min-width: 768px) {
  .modal-content {
    &_lg {
      padding: 20px 32px 32px 32px;
    }
  }
}
</style>
