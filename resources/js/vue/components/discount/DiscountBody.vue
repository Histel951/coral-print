<template>
  <div class="discount-body">
    <div>
      <span class="discount-body__text">
          {{ text }}
      </span>
    </div>
      <DiscountList :discounts="discountsList" :on-check="onCheck" />
  </div>
</template>

<script>
import DiscountList from "@/components/discount/DiscountList";
import useDiscount from "@/composables/useDiscount";
import {onBeforeMount, watch} from "vue";

export default {
  name: "DiscountBody",
  components: {DiscountList},
  props: {
    text: {
      type: String,
      default: ''
    },
    onCheck: Function
  },

  setup() {
    const {discountsList} = useDiscount();

    const setDefault = () => {
      discountsList.value.map((discount, index) => {
        discount.id = index;
        return discount;
      })
    }

    onBeforeMount(() => {
      setDefault();
    });

    watch(discountsList, () => {
      setDefault();
    });

    return {
      discountsList
    };
  }
}
</script>

<style lang="scss" scoped>

.discount-body {
  width: 100%;
  text-align: left;
  padding: 10px 0;

  &__text {
    color: #1E1E1E;
    font-family: 'Inter';
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 148%;
  }
}

</style>
