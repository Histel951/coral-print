<template>
  <div class="order-item">
    <div class="order-item__img">
      <i class="icon-cp-gift"></i>
    </div>
    <div class="order-item__content">
      <div class="order-item__title">Скидка по промокоду</div>
    </div>
    <div class="order-item__prices">
      <div class="item-price item-price_order">
        <div class="item-price__value">-
          <Price :price="calculateDiscountPrice()"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import usePrice from "@/composables/usePrice";
import Price from "@/components/ui/Price.vue";

export default {
  name: "DiscountItem",
  components: {Price},
  props: {
    discount: Number,
    order_total_price: Number,
  },

  setup(props) {
    const {format} = usePrice();

    const calculateDiscountPrice = () => {
      return props.order_total_price * props.discount / 100;
    }

    return {
      format,
      calculateDiscountPrice,
    };
  },

};
</script>

<style lang="scss" scoped>
.order-item {
  &__img {
    display: flex;
    justify-content: center;
    min-width: available;
    min-height: available;
  }

  &__content {
    padding: 0 16px;
  }

  &__prices {
    display: flex;
    flex: 1;
    justify-content: flex-end;
    min-width: 112px;
  }
}

@media all and (min-width: 768px) {
  .order-item {
    padding: 10px 0;

    &__img {
      max-width: 92px;
    }
  }
}

@media all and (min-width: 1024px) {
  .order-item {
    &__img {
      min-width: 109px;
    }
  }
}
</style>
