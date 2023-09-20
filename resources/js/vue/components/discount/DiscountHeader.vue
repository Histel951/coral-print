<template>
  <div class="discount-header">
    <div>
      <span class="discount-header__text">{{ text }}</span>
    </div>
    <div class="discount-header__close">
    </div>
  </div>
</template>

<script>
export default {
  name: "DiscountHeader",
  components: {},
  props: {
    text: {
      type: String,
      default: ''
    }
  },

  setup() {

    return {
    };
  }
}
</script>

<style lang="scss" scoped>

.discount-header {
  text-align: left;
  width: 100%;
  display: flex;
  justify-content: space-between;

  &__text {
     font-family: 'Euclid Circular B';
     font-style: normal;
     font-weight: 600;
     font-size: 20px;
     line-height: 120%;
     color: #00195A;
   }


}

</style>
