<template>
  <div class="order-item">
    <div class="order-item__img">
      <i class="icon-cp-delivery"></i>
    </div>
    <div class="order-item__content">
      <div class="order-item__title">Доставка</div>
      <div v-show="delivery.type === 1 && delivery.city === 'Москва'" class="order-item__info">Курьером по Москве</div>
      <div v-show="delivery.type === 2" class="order-item__info">Самовывоз<span
        v-if="delivery.metro !== null"> м. {{ delivery.metro }}</span>
      </div>
      <div v-show="delivery.type === 3" class="order-item__info">Курьером за МКАД</div>
      <div class="order-item__info">Суммарный вес ~ {{ weightFormat(weight) }}</div>
    </div>
    <div class="order-item__prices">
      <div class="item-price item-price_order">
        <div v-if="delivery.type !== 3" class="item-price__value"><Price :price="delivery.price" /></div>
      </div>
    </div>
  </div>
</template>

<script>
import usePrice from "@/composables/usePrice";
import Price from "@/components/ui/Price.vue";

export default {
  name: "DeliveryItem",
  components: {Price},
  props: {
    delivery: Object,
    weight: Number,
  },

  setup() {
    const weightFormat = (value) => {
      const formatter = new Intl.NumberFormat('ru-RU', {
        style: 'unit',
        unit: 'kilogram',
        maximumSignificantDigits: 3,
      });

      return formatter.format(value);
    };

    const {format} = usePrice();

    return {
      format,
      weightFormat,
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
