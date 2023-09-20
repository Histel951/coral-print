<template>
  <span class="action-link" :class="{
    'action-link__disabled': isDisabled,
    'action-link__hover': !isDisabled
  }">
    <component v-if="iconComponent" class="action-link__icon" :is="iconComponent"/>
    <span class="action-link__text" :class="{'action-link__text_disabled': isDisabled}" @click="onClick">{{ text }}</span>
  </span>
</template>

<script>
export default {
  name: "ActionLink",
  props: {
    isDisabled: {
      type: Boolean,
      default: false
    },
    iconComponent: Object,
    text: String,
    onClick: Function,
  }
}
</script>

<style lang="scss" scoped>
.action-link {
  display: inline-flex;
  align-items: center;
  justify-content: flex-start;
  font-size: 14px;
  line-height: 110%;
  color: #007DEB;
  cursor: pointer;

  &__disabled {
    opacity: 0.2;
    cursor: default;
    transition: 0.15s;

    &:hover {

    }
  }

  &_green {
    color: #59A471;
    .action-link__text {
      border-color: #59A471;
      cursor: pointer;

      &_disabled {
        cursor: default;
      }
    }
  }

  &__icon {
    margin: 0 4px 0 0;
    display: none;
  }

  &__text {
    border-bottom: 1px dashed #007DEB;
  }

  &:hover {
    .action-link__text {
      border-color: rgba(0, 0, 0, 0);
    }
  }

  &_constructor {
    display: none;
  }
}

@media all and (min-width: 768px) {
  .action-link {
    font-size: 15px;
    &__icon {
      display: block;
    }
  }
}

@media all and (min-width: 1024px) {
  .action-link {
    cursor: pointer;
    &_constructor {
      display: flex;
    }

    &_top {
      + .action-link_top {
        margin: 0 0 0 35px;
      }
    }

  }
}
</style>
