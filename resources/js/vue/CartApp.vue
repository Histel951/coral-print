<script>
import Cart from "@/components/cart/Cart";
import {ref} from "vue";
import axios from "axios";

export default {
  name: "CartApp",
  components: {Cart},

  setup() {
    const calculators = ref([]);

    if (localStorage.getItem('cart') !== null) {
      const cart = JSON.parse(localStorage.getItem('cart'));

      const calculatorsByIds = [];

      cart.items.forEach((cartItem) => {
        if (!calculatorsByIds.includes(cartItem.calculator_id)) {
          calculatorsByIds.push(
            {
              id: cartItem.calculator_id,
              print_type: cartItem.print_type ?? null,
              white_print: cartItem.white_print ?? null,
            }
          );
        }
      });

      axios
        .post('/api/calculator/configs_by_ids', {"calculators": calculatorsByIds})
        .then((res) => {
          calculators.value = res.data.calculators;
        })
        .catch(() => {
        });
    }

    return {
      calculators
    };
  },
};
</script>

<template>
  <suspense>
    <Cart :calculators="calculators"/>
  </suspense>
</template>
