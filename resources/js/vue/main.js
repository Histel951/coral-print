import {createApp} from "vue";
import TOAST from "vue-toastification";

import App from './App.vue';
import CartIconApp from './CartIconApp';
import CartApp from './CartApp';
import OrderApp from './OrderApp';

import "vue-toastification/dist/index.css";

const options = {
    transition: "Vue-Toastification__bounce",
    maxToasts: 3,
    newestOnTop: true
};

createApp(CartIconApp).mount('#cart-icon');

const cartMountEl = document.querySelector("#cart");
if (cartMountEl !== null) {
    createApp(CartApp)
        .use(TOAST, options)
        .mount('#cart');
}

const calcMountEl = document.querySelector("#calc");
if (calcMountEl !== null) {
    createApp(App, {...calcMountEl.dataset})
        .use(TOAST, options)
        .mount('#calc');
}

const orderMountEl = document.querySelector("#order");
if (orderMountEl !== null) {
    createApp(OrderApp).mount('#order');
}
