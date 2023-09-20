<template>
  <div class="order-item">
    <div class="order-item__img">
      <div class="order-item__img-container">
        <svg style="width: inherit; height: inherit;">
          <use :xlink:href="'#' + order_item.svg_id"></use>
        </svg>
      </div>
    </div>
    <div class="order-item__base">
      <div class="order-item__info-and-prices">
        <div class="order-item__content">
          <h3 class="order-item__title">{{ order_item.name }}<span
            v-if="order_item.quantity_types?.length > 1">, {{ order_item.quantity_types?.length }}&nbsp;вида</span></h3>
          <div class="order-item__info">{{ sizes }}, {{ order_item.product_count }} шт.</div>
        </div>
        <div class="order-item__prices">
          <div class="item-price item-price_order">
            <div class="item-price__value"><Price :price="order_item.total_price" /></div>
            <div class="item-price__per-one"><Price :price="order_item.item_price" /> за шт.</div>
          </div>
        </div>
      </div>
      <div class="order-item__design-prices">
        <div class="order-item__designs">
          <span v-if="designServices !== ''">{{ designServices }}</span>
          <span v-else>Свой дизайн</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {ref} from "vue";
import usePrice from "@/composables/usePrice";
import Price from "@/components/ui/Price.vue";

export default {
  name: "OrderItem",
  components: {Price},

  props: {
    order_item: Object,
  },

  setup(props) {
    const sizes = ref('');
    const designServices = ref("");

    const {format} = usePrice();

    if (props.order_item.is_diameter === 1) {
      sizes.value = props.order_item.diameter + " мм";
    } else if (typeof props.order_item.height !== 'undefined' && typeof props.order_item.width !== 'undefined') {
      sizes.value = props.order_item.width + "×" + props.order_item.height + " мм";
    } else if (typeof props.order_item.diameter !== 'undefined') {
      sizes.value = props.order_item.diameter + " мм";
    }

    if (props.order_item.design_services.length !== 0) {
      props.order_item.design_services.forEach((service) => {
        const length = designServices.value.length;
        designServices.value += service.checked ? service.name ?? service.label : '';
        designServices.value += service.count > 1 ? " (" + service.count + "\xa0шт.)" : '';
        designServices.value += designServices.value.length !== length ? ', ' : '';
      });

      if (designServices.value.length !== 0) {
        designServices.value = designServices.value.trimEnd().substring(0, designServices.value.length - 2);
      }
    }

    return {
      sizes,
      designServices,
      format,
    };
  },
};
</script>

<style lang="scss" scoped>
.order-item {
  &__base {
    display: flex;
    flex-grow: 1;
    flex-direction: column;
  }

  &__img {
    padding: 0;
    display: flex;
    align-items: center;
    align-content: center;
    justify-content: center;
    min-height: fit-content;

    &-container {
      height: 80px;
    }
  }

  &__design-prices {
    display: none;
    flex: 1;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 4px 0 0 0;
    margin-left: 16px;
    border-top: 1px solid #E5EBEF;
    border-collapse: collapse;
  }

  &__designs {
    display: block;
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 21px;
    color: #1E1E1E;
    flex: none;
    flex-direction: column;
    order: 0;
    flex-grow: 0;
    width: 65%;
  }

  &__info-and-prices {
    display: flex;
    flex: 1;
    flex-shrink: 0;
    flex-basis: 100%;
    flex-direction: row;
    align-items: center;
    align-content: center;
    justify-content: space-between;
  }

  &__content {
    padding: 0 16px;
  }

  &__prices {
    display: flex;
    flex: 1;
    justify-content: flex-end;
    min-width: 112px;
  }
}

.item-price {
  &__per-one {
    margin: 0;
  }
}

@media all and (min-width: 768px) {
  .order-item {
    &__img {
      max-width: 92px;

      &-container {
        width: 92px;
      }
    }

    &__design-prices {
      display: flex;
    }
  }
}

@media all and (min-width: 1024px) {
  .order-item {
    &__img {
      min-width: 109px;

      &-container {
        width: 109px;
      }
    }
  }
}
</style>
