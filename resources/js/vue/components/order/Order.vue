<template>
  <div class="container">
    <h1 class="page-title page-title_center page-title_inner3">Оформление заказа</h1>
    <form id="order-form" action="#" method="post">
      <div class="pure-g order">
        <div class="pure-u-1 pure-u-md-1-2">
          <div class="order__side">
            <OrderContacts ref="contacts" v-on:personalDataChecked="checkIsAllowed"/>
            <OrderDelivery ref="deliveryAddress" v-on:setDelivery="setDelivery" :order-weight="orderWeight"/>
            <OrderPayment ref="payment"/>
            <OrderDiscount v-on:setDiscount="setDiscount" :discount-value="discount"/>
          </div>
        </div>
        <div class="pure-u-1 pure-u-md-1-2">
          <div class="order__side">
            <div class="order__part">
              <OrderListItems
                :order_items="order.items"
                :order_price="order.cart_price"
                :delivery="delivery"
                :discount="discount"
                :order_weight="orderWeight"/>
              <div class="order__btn">
                <button @click.prevent="submitForm()" type="submit" class="btn btn_bg btn_lg"
                        :class="{disabled: !isAllowed}">Оформить заказ →
                </button>
              </div>
              <div class="order__btn-warning">
                Нажимая кнопку «Оформить заказ» вы соглашаетесь с <a href="#">условиями оферты</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import {ref} from "vue";
import OrderContacts from "./OrderContacts";
import OrderDelivery from "./OrderDelivery";
import OrderDiscount from "./OrderDiscount";
import OrderListItems from "./OrderListItems";
import OrderPayment from "./OrderPayment";
import axios from "axios";
import {cloneDeep} from "lodash";

export default {
  name: "Order",
  components: {OrderPayment, OrderDiscount, OrderDelivery, OrderContacts, OrderListItems},

  setup() {
    const order = ref(null);
    const isAllowed = ref(true);
    const delivery = ref({});
    const orderWeight = ref(0);
    const discount = ref(0);
    const payment = ref(null);
    const contacts = ref(null);
    const deliveryAddress = ref(null);

    order.value = JSON.parse(localStorage.getItem('cart'));
    order.value.items.forEach((item) => {
      orderWeight.value += item.weight;
    });

    const checkIsAllowed = (isPersonalDataChecked) => {
      isAllowed.value = isPersonalDataChecked;
    };

    const setDelivery = (deliveryProps) => {
      delivery.value = deliveryProps;
    };

    const setDiscount = (value) => {
      discount.value = value;
    };

    const submitForm = async () => {
      if (await contacts.value.validate()) {
        const orderItems = cloneDeep(order.value.items);
        orderItems.forEach((item) => {
          item.design_services = item.design_services.filter((service) => service.checked);

          delete item.index;
          delete item.calculator_id;
          delete item.svg_id;
        });

        await axios
          .post('/api/orders', {
            order_price: discount.value !== 0
              ? (order.value.cart_price + delivery.value.price) * (1 - discount.value / 100)
              : order.value.cart_price + delivery.value.price,
            contacts: {
              fio: contacts.value.fio,
              phone: contacts.value.phone,
              email: contacts.value.eMail,
            },
            payment: {
              id: payment.value.payment,
              files: payment.value.files.length !== 0 && payment.value.payment === 3 ? payment.value.files : null,
              company_name: payment.value.payment === 3 ? payment.value.company : null,
              company_inn: payment.value.payment === 3 ? payment.value.companyInn : null,
            },
            delivery: delivery.value,
            delivery_address: deliveryAddress.value.address,
            discount: discount.value,
            order: {
              items: orderItems,
            }
          })
          .then((res) => {
            localStorage.removeItem('cart');
            document.location.href = "/order-thank?order=" + res.data.order_uuid;
          });
      }
    }

    return {
      order,
      isAllowed,
      delivery,
      orderWeight,
      discount,
      payment,
      contacts,
      deliveryAddress,
      checkIsAllowed,
      setDelivery,
      setDiscount,
      submitForm,
    };
  },
};
</script>

<style lang="scss" scoped>
.order-items {
  display: flex;
  flex-direction: column;
}
</style>
