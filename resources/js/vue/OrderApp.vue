<template>
<Order></Order>
</template>

<script>
import Order from "./components/order/Order";

export default {
  name: "OrderApp",
  components: {Order},

  setup() {
    if (localStorage.getItem('cart') === null) {
      document.location.href = '/';
    }
  },
};
</script>

<style scoped>

</style>
