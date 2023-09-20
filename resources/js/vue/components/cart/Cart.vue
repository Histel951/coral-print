<template>
  <div class="container">
    <div class="pure-g page-top page-top_cart">
      <div v-show="cart !== null" class="pure-u-1-6 pure-u-md-1-4 order-md-3 text-right-md">
        <span @click="dropCart" class="clear-cart">
          <span class="clear-cart__text">Очистить корзину</span>
          <span class="clear-cart__ico">
                            <i class="icon-trash"></i>
                            <i class="icon-del"></i>
                        </span>
        </span>
      </div>
      <div class="pure-u-2-3 pure-u-md-1-2 order-md-2" :style="cart === null ? 'width: 100%;' : ''">
        <h1 v-show="cart !== null" class="page-title page-title_center page-title_inner2">Корзина</h1>
        <h1 v-show="cart === null" class="page-title page-title_center page-title_inner2">Корзина пуста</h1>
      </div>
      <div class="pure-u-1-6 pure-u-md-1-4 order-md-1"></div>
    </div>
    <div v-if="cart !== null && calculators.length !== 0" class="cart-items">
      <div v-for="cartItem in cart.items" class="c-item" :key="cartItem.index">
        <suspense>
          <CartItem
            v-on:dropItem="dropItem"
            v-on:cartPriceChanged="cartPriceChanged"
            v-on:filesChanged="onCartChanged(false)"
            v-on:commentChanged="onCartChanged(false)"
            v-on:duplicateItem="duplicateItem"
            :cart_item="cartItem"
            :calculator="getCalculator(cartItem.calculator_id, cartItem.print_type, cartItem.white_print)">
          </CartItem>
        </suspense>
      </div>
    </div>
    <div v-if="cart !== null" class="cart-total">
      <i class="icon-cp-summ"></i> <span class="hidden visible-md">Общая стоимость: </span>
      <Price :price="cart?.cart_price"/>
    </div>
    <span @click.prevent="prepareToOrder" v-show="cart !== null" class="btn btn_bg btn_lg cart-btn">
      <span class="link-cart__order">Оформить заказ →</span>
    </span>
  </div>
</template>

<script>
import CartItem from "@/components/cart/CartItem";
import Price from "@/components/ui/Price.vue";
import {ref} from "vue";
import {cloneDeep} from "lodash";
import usePrice from "@/composables/usePrice";

export default {
  name: "Cart",
  components: {CartItem, Price},

  props: {
    calculators: Array
  },

  async setup(props) {
    const cart = ref({});

    const {format} = usePrice();

    cart.value = JSON.parse(localStorage.getItem('cart'));

    const onCartChanged = (isToNull = false) => {
      if (!isToNull) {
        localStorage.setItem('cart', JSON.stringify(cart.value));
      } else {
        localStorage.removeItem('cart');
      }

      window.dispatchEvent(new CustomEvent('cart-changed', {
        detail: {
          cart: localStorage.getItem('cart')
        }
      }));
    };

    const dropCart = () => {
      cart.value = null;

      onCartChanged(true);
    };

    const dropItem = (index) => {
      const cartItem = cart.value.items.find((item) => item.index === index);

      cartPriceChanged(-cartItem.total_price);
      cart.value.items.splice(cart.value.items.indexOf(cartItem), 1);

      if (cart.value.items.length === 0) {
        dropCart();

        return;
      }

      onCartChanged();
    };

    const cartPriceChanged = (diff) => {
      cart.value.cart_price += diff;

      onCartChanged();
    };

    const getCalculator = (id, printType, whitePrint) => {
      return cloneDeep(props.calculators.find((calculator) => {
          let calcCondition = id === calculator.id;

          if (typeof printType !== 'undefined') {
            calcCondition = calcCondition && printType === calculator.print_type;
          }

          if (typeof whitePrint !== 'undefined') {
            calcCondition = calcCondition && whitePrint === calculator.white_print;
          }

          return calcCondition;
        })
      );
    };

    const duplicateItem = (index) => {
      const cartItem = cart.value.items.find((item) => item.index === index);

      const lastIndex = cart.value.items[cart.value.items.length - 1].index;

      const duplicate = cloneDeep(cartItem);
      duplicate.index = lastIndex + 1;
      cart.value.items.push(duplicate);

      cartPriceChanged(cartItem.total_price);
    };

    const prepareToOrder = () => {
      cart.value.items.forEach((item) => {
        item.design_services.forEach((service) => {
          service.checked = service.checked ?? false;
        });
      });

      onCartChanged();

      document.location.href = '/order';
    };

    return {
      cart,
      dropCart,
      dropItem,
      format,
      cartPriceChanged,
      getCalculator,
      onCartChanged,
      duplicateItem,
      prepareToOrder,
    };
  },
};
</script>

<style lang="scss" scoped>
.cart-btn {
  cursor: pointer;
}

.link-cart {
  &__order {
    font-style: normal;
    font-weight: 500;
    font-size: 18px;
    line-height: 20px;
    display: flex;
    align-items: center;
    text-align: center;
    color: #FFFFFF;
  }
}

.clear-cart {
  cursor: pointer;
}
</style>
