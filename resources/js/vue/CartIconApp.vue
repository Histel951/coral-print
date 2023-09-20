<template>
  <div>
    <a href="/cart" class="link-cart">
      <div class="link-cart__icon">
        <img src="images/icon/icon-basket.svg" alt="icon basket">
        <span class="link-cart__number">{{ itemsCount }}</span>
      </div>
      <span class="link-cart__sum hidden visible-md">
        <Price :price="cartPrice" />
      </span>
    </a>
  </div>
</template>

<script>
import {onBeforeMount, onMounted, ref} from "vue";
import usePrice from "@/composables/usePrice";
import Price from "@/components/ui/Price.vue";

export default {
  name: "CartIconApp",
  components: {Price},

  setup() {
    const cartPrice = ref(0);
    const itemsCount = ref(0);

    const {format} = usePrice();

    onBeforeMount(() => {
      if (localStorage.getItem('cart') !== null) {
        const cart = JSON.parse(localStorage.getItem('cart'));
        cartPrice.value = cart.cart_price;
        itemsCount.value = cart.items.length;
      }
    });

    onMounted(() => {
      window.addEventListener('cart-changed', (event) => {
        if (event.detail.cart === null) {
          cartPrice.value = 0;
          itemsCount.value = 0;
        } else {
          const cart = JSON.parse(event.detail.cart);
          cartPrice.value = cart.cart_price;
          itemsCount.value = cart.items.length;
        }
      });
    });

    return {
      cartPrice,
      itemsCount,
      format
    };
  }
}
</script>

<style scoped>
.link-cart {
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-align-items: center;
  -ms-flex-align: center;
  align-items: center;
  max-height: 50px
}

.link-cart__icon {
  position: relative;
  max-width: 45px
}

.link-cart__number {
  display: -webkit-inline-flex;
  display: -ms-inline-flexbox;
  display: inline-flex;
  -webkit-align-items: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-justify-content: center;
  -ms-flex-pack: center;
  justify-content: center;
  min-width: 30px;
  background: #ffc730;
  font-family: Euclid Circular B, Arial, Tahoma, sans-serif;
  font-weight: 500;
  font-size: 12px;
  color: #1e1e1e;
  border-radius: 20px;
  padding: 0 5px;
  position: absolute;
  bottom: -4px;
  right: -2px
}

.link-cart__sum {
  font-family: Euclid Circular B, Arial, Tahoma, sans-serif;
  color: #fff;
  font-size: 24px;
  line-height: 1;
  margin-left: 14px
}

.hidden {
  display: none
}

.visible-md {
  display: block
}
</style>
