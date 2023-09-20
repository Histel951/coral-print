<template>
  <div class="modal-header" :class="classes" :style="style">
    <div class="modal-header__title">
      <span class="modal-header__title-text" :style="textStyle">{{ title }}</span>
    </div>
    <div class="modal-header__close" :class="headerCloseClasses" @click="onClose">
      <CloseIcon/>
    </div>
  </div>
</template>

<script>
import CloseIcon from "../icons/CloseIcon";

export default {
  name: "ModalHeader",
  components: {CloseIcon},
  props: {
    title: {
      type: String,
      required: true
    },
    onClose: Function,
    fixed: {
      type: Boolean,
      default: false
    },
    style: {
      type: Object,
      default: () => {}
    },
    textStyle: {
      type: Object,
      default: () => {}
    },
    size: {
      type: String,
      default: 'xs'
    },
    typeModal: String,
    headerCloseClasses: String,
  },
  setup(props) {
    const classnames = () => {
      const classesArr = [];
      if (props.fixed) {
        classesArr.push('modal-header_fixed');
      }
      if (props.size) {
        classesArr.push(`modal-header_${props.size}`);
      }
      if (props.typeModal === 'design') {
        classesArr.push(`modal-header_design`);
      }
      if (props.typeModal === 'tooltip') {
        classesArr.push(`modal-header_tooltip`);
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
.modal-header {
  display: flex;
  padding: 8px 8px 8px 16px;

  &__title {
    flex: 1 1 1px;
    min-width: 0;
    font-family: Euclid Circular B, Arial, sans-serif;
    color: #00195A;
    line-height: 120%;
  }

  &__close {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #F1F2F0;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  &_base {
    .modal-header__title {
      margin: 20px 0 0 0;
      font-size: 24px;
      font-weight: 600;
    }
  }

  &_fixed {
    background: #F1F2F0;
    align-items: center;

    .modal-header__close {
      margin: -4px -4px -4px 8px;
    }

    .modal-header__title {
      font-size: 20px;
      font-weight: bold;
    }
  }
}

@media all and (max-width: 767px) {
  .modal-header_design {
    background: #F1F2F0;
    padding-top: 15px;
    padding-bottom: 15px;;
  }
}

@media all and (min-width: 768px) {
  .modal-header {
    &_lg {
      padding: 8px 8px 0 32px;
    }
    &_design {
      padding: 32px 8px 14px 32px;
    }
    &_tooltip {
      padding: 32px 0 0 46px;
    }
    &__close {
      background: none;
      cursor: pointer;

      &:hover {
        background: #F1F2F0;
      }
    }

    &_base {
      .modal-header__title {
        font-size: 22px;
        margin: 24px 0 0 0;
      }
    }

    &_fixed {
      background: none;
      .modal-header__title {
        font-size: 22px;
        font-weight: 600;
        margin: 24px 0 0 0;
        align-items: flex-start;
      }
      .modal-header__close {
        margin: 0 0 0 8px;
        align-self: flex-start;
      }
    }
  }
  .modal-panel {
    &_xs {
      .modal-header {
        &_fixed, &_base {
          align-items: center;

          .modal-header__title {
            margin: 0;
          }
        }
      }
    }
  }
}
</style>

<style lang="scss">
@media all and (min-width: 768px) {
  .modal-header {
    &__close {
      svg {
        path {
          stroke: #D6DEE3;
        }
      }

      &:hover {
        svg {
          path {
            stroke: #EB444C
          }
        }
      }
    }
  }
}
</style>
