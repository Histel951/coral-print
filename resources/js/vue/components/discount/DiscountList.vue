<template>
  <div class="discount-list">
    <div class="discount-list__list">
      <DiscountListItem
        v-for="discount in discounts"
        :key="discount.id"
        :id="discount.id"
        :percent="discount.percent"
        :amount="discount.product_count"
        :price-for-one="discount.count_item_price"
        :checked="discount.active"
        :on-check="onCheck"
        :disabled="Boolean(discount.disabled)"
      />
    </div>
  </div>
</template>

<script>
import DiscountListItem from "@/components/discount/DiscountListItem";

export default {
  name: "DiscountList",
  components: {DiscountListItem},
  props: {
    discounts: {
      type: Array,
      default () {
        return [];
      }
    },

    onCheck: Function
  },
}
</script>

<style lang="scss" scoped>

.discount-list {
  margin-top: 12px;
  width: 100%;
}

</style>
