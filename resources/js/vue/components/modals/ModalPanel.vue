<template>
  <div class="modal-panel" :class="classes">
    <slot/>
  </div>
</template>

<script>
export default {
  name: "ModalPanel",
  props: {
    fullHeight: {
      type: Boolean,
      default: false
    },
    size: {
      type: String,
      default: 'xs'
    },
    typeModal: String,
  },
  setup(props) {
    const classnames = () => {
      const classesArr = [];
      if (props.fullHeight) {
        classesArr.push('modal-panel_full');
      }
      if (props.size) {
        classesArr.push(`modal-panel_${props.size}`);
      }
      if (props.typeModal === 'tooltip') {
        classesArr.push(`modal-panel_tooltip`);
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
.modal-panel {
  background: #fff;
  display: flex;
  flex-flow: column nowrap;
  margin: auto;
  width: 100%;
  position: relative;
  z-index: 2;

  &_full {
    height: 100%;
    overflow: auto;
  }
}

@media all and (min-width: 768px) {
  .modal-panel {
    box-shadow: 0 2px 15px rgba(45, 45, 45, 0.2);
    border-radius: 4px;
    max-height: 100%;
    &_full {
      height: auto;
    }
    &_auto {
      width: auto;
    }
    &_xs {
      width: 288px;
    }

    &_m {
      width: 408px;
    }

    &_lg {
      width: 639px;
    }
    &_tooltip {
      max-height: 95vh;
    }
  }
}
</style>
