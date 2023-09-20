<template>
  <div class="discount-footer">
    <div :class="{
      'discount-footer__change-circulation-btn': !isLockButtonChangeEdition,
      'discount-footer__change-circulation-btn__lock': isLockButtonChangeEdition
    }" @click="onClick()">
      <span class="discount-footer__change-circulation-btn__text">
        {{ text }}
      </span>
    </div>
  </div>
</template>

<script>
import useDiscount from "@/composables/useDiscount";

export default {
  name: "DiscountFooter",
  props: {
    text: {
      type: String,
      default: ''
    },
    onClick: Function
  },

  setup() {
    const {isLockButtonChangeEdition} = useDiscount();

    return {
      isLockButtonChangeEdition
    };
  }
}
</script>

<style lang="scss" scoped>

.discount-footer {
  width: 100%;
  padding: 16px 16px 16px 16px;
  background-color: #fff;
  display: flex;
  justify-content: center;
  border-top: 1px solid #CCCCCC;

  &__change-circulation-btn {
    background: #007DEB;
    border-radius: 50px;
    width: 200px;
    height: 40px;
    cursor: pointer;
    padding: 10px 8px;
    text-align: center;
    transition: 0.1s;

    &__lock {
      background: #63b7ff;
      cursor: not-allowed;
      border-radius: 50px;
      width: 200px;
      height: 40px;
      padding: 10px 8px;
      text-align: center;
      transition: 0.1s;
    }

    &__text {
      font-family: 'Euclid Circular B';
      font-style: normal;
      font-weight: 500;
      font-size: 18px;
      line-height: 20px;
      color: #FFFFFF;
    }
  }

  &__change-circulation-btn:hover {
    background: #005AB4;
    transition: 0.1s;
  }
}

</style>
