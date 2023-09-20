<template>
  <h2 class="order__part-title order__part-title_center">Информация о заказе</h2>
  <div class="order-items">
    <OrderItem v-for="item in order_items" :key="item.index" :order_item="item"/>
    <DeliveryItem v-if="JSON.stringify(delivery) !== '{}'" :delivery="delivery" :weight="order_weight"/>
    <DiscountItem v-if="discount !== 0" :discount="discount" :order_total_price="order_price + delivery.price"
                  class="order-item__discount"/>
  </div>
  <div class="order__total">
    <span v-if="typeof delivery?.price !== 'undefined'">Итого к оплате: <Price :price="calculateTotalPrice()"/></span>
  </div>
</template>

<script>
import OrderItem from "./OrderItem";
import DeliveryItem from "./DeliveryItem";
import DiscountItem from "./DiscountItem";
import {ref} from "vue";
import usePrice from "@/composables/usePrice";
import Price from "@/components/ui/Price.vue";

export default {
  name: "OrderListItems",
  components: {DiscountItem, OrderItem, DeliveryItem, Price},

  props: {
    order_items: Array,
    order_price: Number,
    delivery: Object,
    discount: Number,
    order_weight: Number,
  },

  setup(props) {
    const orderPrice = ref(props.order_price);

    const {format} = usePrice();

    const calculateTotalPrice = () => {
      return props.discount !== 0
        ? (orderPrice.value + props.delivery.price) * (1 - props.discount / 100)
        : orderPrice.value + props.delivery.price;
    }

    return {
      orderPrice,
      format,
      calculateTotalPrice,
    };
  },
};
</script>

<style lang="scss" scoped>
.order-item {
  display: flex;
  flex: 1;
  flex-direction: row;
  align-items: center;
  padding: 8px 0;
  border-top: 1px solid #D6DEE3;

  &__discount {
    padding: 15px 0;
  }
}

@media all and (min-width: 768px) {
  .order-item {
    padding: 10px 0;

    &__discount {
      padding: 10px 0;
    }
  }
}
</style>
