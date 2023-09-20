<template>
  <div class="order__part">
    <h2 class="order__part-title">Скидки</h2>
    <div class="promo">
      <input v-model="code" type="text" name="promo" class="input" :class="{error: invalidCode}" placeholder="Промокод"
             autocomplete="off">
      <span @click="checkPromocode" style="cursor: pointer;" class="btn btn_border disabled">Применить</span>
    </div>
  </div>
</template>

<script>
import {ref, watch} from "vue";
import axios from "axios";

export default {
  name: "OrderDiscount",
  props: {
    discountValue: Number,
  },
  emits: ['setDiscount'],

  setup(props, context) {
    const code = ref('');
    const invalidCode = ref(false);
    const discount = ref(props.discountValue);

    const checkPromocode = () => {
      axios
        .get('api/promocodes?code=' + code.value, {
          headers: {
            'Accept': 'application/json',
          },
        })
        .then((res) => {
          discount.value = res.data.discount;
          context.emit('setDiscount', discount.value);
        })
        .catch(() => {
          invalidCode.value = true;
        })
    };

    watch(code,
      () => {
        invalidCode.value = false
      });

    return {
      code,
      invalidCode,
      discount,
      checkPromocode,
    };
  },
};
</script>

<style scoped>

</style>
