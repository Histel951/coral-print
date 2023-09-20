<template>
  <div v-if="price" class="calc-price" :class="{'calc-price_loading': priceIsLoading}">
    <Price :price="price.total_price + designPrice" :font-size="32" :color="'#00195A'"/>
    <br><span class="calc-price__for-one" v-html="price.total_price ? format((price.total_price + designPrice) / (price.total_price / price.item_price), 16) : format(0, 16)" />
    &nbsp;<span v-if="price.total_price">за штуку</span>
  </div>
</template>

<script>
import usePrice from "../composables/usePrice";
import Price from "@/components/ui/Price.vue";

export default {
  name: "CalcPrice",
  components: {Price},
  props: {
    designPrice: Number,
  },
  setup() {
    const {price, priceIsLoading, format} = usePrice();

    return {
      format,
      price,
      priceIsLoading
    }
  }
}
</script>

<style lang="scss" scoped>
.calc-price {
  text-align: center;
  font-family: "Euclid Circular B", Arial, Tahoma, sans-serif;

  &_loading {
    opacity: 0.4;
  }

  &__value {
    font-weight: 600;
    font-size: 36px;
    line-height: 120%;
    letter-spacing: 0.03em;
    color: #00195A;
  }

  &__for-one {
    font-weight: 500;
    font-size: 18px;
    line-height: 120%;
    letter-spacing: 0.02em;
    color: #1E1E1E;
    margin: 4px 0 0 0;
  }
}
</style>
