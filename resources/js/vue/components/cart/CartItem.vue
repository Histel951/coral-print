<template>
  <div class="c-item__img">
    <svg style="width: 100%; height: 100%;">
      <use :xlink:href="'#' + cartItem.svg_id"></use>
    </svg>
  </div>
  <div class="c-item__content">
    <div class="c-item__top">
      <h2 class="c-item__title">{{ cartItem.name }}<span v-if="quantityTypes">, {{ quantityTypes }}</span>
      </h2>
      <div class="item-price item-price_cart hidden-lg">
        <div class="item-price__value">
          <Price :price="cartItem.total_price"/>
        </div>
        <div class="item-price__per-one">
          <Price :price="cartItem.item_price"/>
          за шт.
        </div>
      </div>
    </div>
    <div class="c-item__options">
      <span v-html="sizes"></span> <b>Тираж:</b> {{ cartItem.product_count }} шт.
    </div>
    <suspense>
      <CartItemText
        :cart-item="cartItem"
        :fields-params="calculator.data"
        :calculator-type="calculator.calculator_type"
        :weight="cartItem.weight"/>
    </suspense>
    <div class="c-item__m-t-holder">
      <div @click="isOpened = !isOpened" class="c-item__mockups-toggler" :class="{opened: isOpened}">
        Добавить дизайн
        <i class="icon-chevron-down" style="margin-right: 13px"></i>
        <span v-show="checkedDSCount > 0 && !isOpened" class="link-cart__number">{{ checkedDSCount }}</span>
      </div>
      <div v-show="cartItem.client_designs.length === 0" class="dt-mockup-error visible-lg" style="margin-left: 27px">
        <i class="icon-cp-alarm"></i>
        Дизайн-макеты не прикреплены!
      </div>
    </div>
    <div v-if="typeof cartItem !== 'undefined'" :id="'mockups-item-' + cartItem.index" class="hidden c-item__mockups"
         :style="{display: isOpened ? 'block' : 'none'}">
      <ul data-tabs class="c-item__tabs">
        <li class="c-item__tab c-item__not-last-tab">
          <a @click="activeTab = 0" :aria-selected="activeTab === 0">Заказать у нас</a>
        </li>
        <li class="c-item__tab">
          <a @click="activeTab = 1" :aria-selected="activeTab === 1">Загрузить свой макет</a>
        </li>
      </ul>
      <div :id="'mock-0-item-' + cartItem.index" :hidden="activeTab !== 0">
        <DesignService
          v-for="service in cartItem.design_services"
          v-on:designChecked="designChecked"
          v-on:countChanged="designCountChanged"
          :id="'ds-' + cartItem.index + '-' + service.id"
          :key="service.id"
          :service="service"
          :types_count="cartItem.quantity_types?.length ?? 1"/>
      </div>
      <div :id="'mock-1-item-' + cartItem.index" :hidden="activeTab !== 1">
        <DesignUpload
          v-on:filesChanged="$emit('filesChanged')"
          :filesList="cartItem.client_designs"/>
        <div class="design-upload__field no-mobile">
      <textarea v-model="comment" type="text" required class="input input_area input_wide" rows="3" id="comment"
                name="comment"
                placeholder="Комментарий к макетам — если необходимо, уточните, какие изменения нужно внести в ваши макеты"/>
        </div>
      </div>
    </div>
  </div>
  <div class="c-item__side text-right-lg">
    <div class="item-price item-price_cart hidden visible-lg">
      <div class="item-price__value">
        <Price :price="cartItem.total_price"/>
      </div>
      <div class="item-price__per-one">
        <Price :price="cartItem.item_price"/>
        за шт.
      </div>
    </div>
    <div>
      <span @click="duplicateItem" class="duplicate-cart-item">
        <span class="clear-cart__text">Дублировать</span>
        <span class="clear-cart__ico">
          <i class="icon-duplicate"></i>
        </span>
      </span>
      <span @click="dropItem" class="clear-cart clear-cart_item">
        <span class="clear-cart__text">Удалить</span>
        <span class="clear-cart__ico">
          <i class="icon-trash"></i>
          <i class="icon-del"></i>
        </span>
      </span>
    </div>
  </div>
</template>

<script>
import CartItemText from "@/components/cart/CartItemText";
import DesignService from "@/components/cart/DesignService";
import DesignUpload from "@/components/cart/DesignUpload";
import {onBeforeMount, ref, watch} from "vue";
import {cloneDeep} from "lodash";
import usePrice from "@/composables/usePrice";
import Price from "@/components/ui/Price.vue";
import {POSITION, useToast} from "vue-toastification";
import useTypesDeclinations from "@/composables/useTypesDeclinations";

export default {
  name: "CartItem",
  components: {Price, DesignService, DesignUpload, CartItemText},
  props: {
    cart_item: Object,
    calculator: Object
  },
  emits: [
    'dropItem',
    'cartPriceChanged',
    'filesChanged',
    'commentChanged',
    'duplicateItem',
  ],

  async setup(props, context) {
    const sizes = ref('');
    const cartItem = ref(props.cart_item);
    const comment = ref(props.cart_item.design_comment);
    const quantityTypes = ref('');

    const checkedDSCount = ref(0);
    const isOpened = ref(false);
    const activeTab = ref(0);

    const {declination} = useTypesDeclinations();

    const toast = useToast();
    const options = {
      position: POSITION.TOP_CENTER,
      toastClassName: "custom-toast",
      bodyClassName: "custom-body",
      timeout: 3000,
      closeOnClick: true,
      pauseOnFocusLoss: true,
      pauseOnHover: true,
      draggable: false,
      hideProgressBar: true,
      closeButton: false,
    };

    const {format} = usePrice();

    onBeforeMount(() => {
      if (typeof props.calculator.data['width-height'] !== 'undefined') {
        props.calculator.data['width-height'].forEach((item) => {
          if (cartItem.value?.width === item.width && cartItem.value?.height === item.height) {
            sizes.value = "<b>Размер: </b>" + item.name;
          }
        });
      }

      if (sizes.value === '') {
        if (cartItem.value.is_diameter === 1) {
          sizes.value = "<b>Диаметр:</b> " + cartItem.value.diameter + " мм.";
        } else if (typeof cartItem.value.height !== 'undefined' && typeof cartItem.value.width !== 'undefined') {
          sizes.value = "<b>Размер:</b> " + cartItem.value.width + "×" + cartItem.value.height + " мм.";
        } else if (typeof cartItem.value.diameter !== 'undefined') {
          sizes.value = "<b>Диаметр:</b> " + cartItem.value.diameter + " мм.";
        }
      }

      quantityTypes.value = declination(cartItem.value.quantity_types?.length);

      const checkedServices = cloneDeep(cartItem.value.design_services);

      cartItem.value.design_services = cloneDeep(props.calculator.design_services);

      cartItem.value.design_services.forEach((service) => {
        const checkedService = checkedServices.find((item) => service.id === item.id);
        if (typeof checkedService !== 'undefined') {
          service.checked = checkedService.checked ?? false;
          if (service.checked) {
            checkedDSCount.value++;
          }
        }

        service.count = checkedService?.count ?? 1;
      });
    });

    const designChecked = (id) => {
      const service = cartItem.value.design_services.find((service) => service.id === id);

      service.checked = !service.checked;

      checkedDSCount.value += service.checked ? 1 : -1;

      const oldDesignPrice = cartItem.value.design_price;

      cartItem.value.design_price = 0;
      cartItem.value.design_services.forEach((service) => {
        cartItem.value.design_price += service.checked ? service.value : 0;
      });

      const diff = cartItem.value.design_price - oldDesignPrice;

      cartItem.value.item_price += diff / cartItem.value.product_count;

      cartItem.value.total_price += diff;

      context.emit('cartPriceChanged', diff);
    };

    const designCountChanged = (id, countDiff) => {
      const service = cartItem.value.design_services.find((service) => service.id === id);
      const oldCount = service.count;

      service.count += countDiff;

      const diff = service.value * service.count - service.value * oldCount;
      cartItem.value.item_price += diff / cartItem.value.product_count;
      cartItem.value.design_price += diff;
      cartItem.value.total_price += diff;

      context.emit('cartPriceChanged', diff);
    };

    const duplicateItem = () => {
      options.icon = 'icon-copy';
      toast('Товар дублирован', options);

      context.emit('duplicateItem', cartItem.value.index);
    };

    const dropItem = () => {
      options.icon = 'icon-trash-mini';
      toast('Товар удален', options);

      context.emit('dropItem', cartItem.value.index);
    }

    watch(comment,
      (newValue) => {
        cartItem.value.design_comment = newValue;
        context.emit('commentChanged');
      }
    );

    return {
      cartItem,
      sizes,
      comment,
      checkedDSCount,
      isOpened,
      activeTab,
      quantityTypes,
      format,
      designChecked,
      designCountChanged,
      duplicateItem,
      dropItem,
    }
  }
}
</script>

<style>
/*
  DO NOT DELETE!
  These classes are for toasts customization
*/
.Vue-Toastification__toast--default.custom-toast {
  background-color: #FFC730;
  color: #00195A;
  align-items: center;
  padding: 10px 20px;
  min-width: fit-content;
  min-height: fit-content;
}

.Vue-Toastification__toast-body.custom-body {
  font-family: Euclid Circular B, Arial, sans-serif;
  font-style: normal;
  font-weight: 500;
  font-size: 18px;
  line-height: 130%;
}

.Vue-Toastification__icon.icon-copy {
  margin-right: 16px;
}

.Vue-Toastification__icon.icon-trash-mini {
  margin-right: 17px;
}
</style>

<style lang="scss" scoped>
.design-upload {
  &__field {
    display: none;
  }
}

.c-item {
  &__tabs {
    display: flex;
    max-width: fit-content;
  }

  &__tabs li {
    flex: 1 1 50%;
    width: fit-content;
  }

  &__tab {
    max-width: fit-content;
    cursor: pointer;
  }

  &__not-last-tab {
    margin-right: 24.5px;
  }

  &__tab a {
    padding: 0;
  }

  &__mockups-toggler {
    line-height: 145%;
    color: #007deb;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    text-decoration: none;
    background: none;
  }
}

.duplicate-cart-item {
  position: absolute;
  left: 0;
  top: 90px;
  -webkit-align-items: center;
  -ms-flex-align: center;
  align-items: center;
  bottom: auto;
  cursor: pointer;
}

.link-cart__number {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 30px;
  background: #ffc730;
  font-family: Euclid Circular B, Arial, Tahoma, sans-serif;
  font-weight: 500;
  font-size: 12px;
  color: #1e1e1e;
  border-radius: 20px;
  padding: 0 5px;
  position: static;
}

.clear-cart {
  cursor: pointer;
  left: 44px;
  top: 90px;
}

.dt-mockup-error {
  display: none;
}

@media all and (min-width: 768px) {
  .c-item {
    &__tab {
      min-width: max-content;
    }

    &__not-last-tab {
      margin-right: 49px;
      min-width: max-content;
    }
  }

  .duplicate-cart-item {
    display: -webkit-inline-flex;
    display: -ms-inline-flexbox;
    display: inline-flex;
    left: auto;
    top: 3px;
    right: 0;
  }

  .clear-cart {
    top: 35px;
    left: auto;
    right: 0;
  }

  .dt-mockup-error {
    display: block;
  }
}

@media all and (min-width: 1024px) {
  .c-item {
    &__content {
      flex: 1;
    }
  }

  .design-upload {
    &__field {
      display: flex;
      color: #8E8E8E;
      padding-top: 27px;
    }
  }

  .input_wide {
    flex: 1;
    background: #FFFFFF;
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 23px;
    border: 1px solid #D6DEE3;
    box-shadow: inset 0 2px 4px rgba(30, 30, 30, 0.15);
    border-radius: 4px;
  }

  .input_wide::placeholder {
    padding: 10px 10px 10px 12px;
  }

  .duplicate-cart-item {
    position: static;
  }

  .duplicate-cart-item:hover .clear-cart__text {
    text-decoration: underline
  }
}
</style>
