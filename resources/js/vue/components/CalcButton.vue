<template>
  <span class="calc-btn" :class="{
    'calc-btn__disabled': isDisabled,
    'calc-btn__hover': !isDisabled
  }"><slot/></span>
</template>

<script>
export default {
  name: "CalcButton",
  props: {
    isDisabled: {
      type: Boolean,
      default: false
    }
  }
}
</script>

<style lang="scss" scoped>
.calc-btn {
  display: inline-flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  background: #007DEB;
  border-radius: 24px;
  height: 48px;
  font-weight: 500;
  font-size: 18px;
  line-height: 20px;
  color: #fff;
  font-family: "Euclid Circular B", Arial, Tahoma, sans-serif;

  &__hover:hover {
    background: #005AB4;
  }

  &__disabled {
    opacity: 0.2;
    cursor: default;
    transition: 0.15s;

    &:hover {

    }
  }

  &_flex {
    display: flex;
  }
}
</style>
