<template>
  <div class="design-modal__main-content ">
    <div v-for="(price, index) in prices" :key="index" class="design-modal__list-content">
      <label class="design-modal__checkbox" :for="index">
        <input type="checkbox" v-model="checkedFields[index]" :id="index" @change="changePrice(price)"/>
        <span class="checkbox-span"></span>
        {{ price.name }}:&nbsp;<Price :price="price.value * price.count" />
      </label>
      <div v-if="form.quantity_types.length > 1 && checkedFields[index]" class="c-item__count visible-lg"
           style="padding-top: 10px">
        <div class="input-count">
          <div class="input-count__item">
            <button @click="countMinus(price.id)" class="input-count__btn minus" type="button"></button>
          </div>
          <div class="input-count__item">
            <input class="input-count__input" type="text" :id="'input-count__input' + price.id" :value="price.count" readonly>
          </div>
          <div class="input-count__item">
            <button @click="countPlus(price.id)" class="input-count__btn plus" type="button"></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer modal-footer_left modal-footer_lg">
    <div class="design-modal__footer">
      <div class="design-modal__footer__info">
      </div>
      <div class="design-modal__footer__price">
        <Price :price="sumPrice" />
      </div>
      <div class="design-modal__footer__btn">
        <CalcButton
          class="design-modal__footer__submit"
          @click="$emit('updateDesignPrice', {price: sumPrice, services: JSON.parse(JSON.stringify(activePrices))})">
          Выбрать
        </CalcButton>
      </div>
    </div>
  </div>
</template>

<script>
import CalcButton from "@/components/CalcButton";
import {onBeforeUnmount, ref, toRefs} from "vue";
import usePrice from "@/composables/usePrice";
import useForm from "@/composables/useForm";
import Price from "@/components/ui/Price.vue";

export default {
  name: "DesignOrderTab",
  components: {Price, CalcButton},
  emits: ['update:modelValue', 'updateDesignPrice'],
  props: {
    modelValue: Array,
    opened: Boolean,
    prices: Object,
    state: Object,
  },
  setup(props, context) {

    const p = toRefs(props)
    const checkedFields = ref([]);
    const activePrices = ref([]);
    const sumPrice = ref(0);

    const {form} = useForm();
    const {format} = usePrice();

    if (props.modelValue?.includes(true)) {
      for (let i = 0; i < props.prices.length; i++) {
        if (props.modelValue[i]) {
          activePrices.value.push(props.prices[i]);
          sumPrice.value += props.prices[i].value * props.prices[i].count;
        }
      }
    }

    const changePrice = (price) => {
      if (activePrices.value.some((v) => v.name === price.name)) {
        activePrices.value = activePrices.value.filter((v) => v.name !== price.name);
        sumPrice.value -= price.value * price.count;
        price.count = 1;
      } else {
        activePrices.value.push(price);
        sumPrice.value += price.value;
      }
    };

    const countMinus = (id) => {
      const service = activePrices.value.find((item) => item.id === id);
      if (service.count > 1) {
        service.count--;
        sumPrice.value -= service.value;
      }
    };

    const countPlus = (id) => {
      const service = activePrices.value.find((item) => item.id === id);
      if (service.count < form.quantity_types.length) {
        service.count++;
        sumPrice.value += service.value;
      }
    };

    if (props.modelValue) {
      checkedFields.value = p.modelValue.value
    }

    onBeforeUnmount(() => {
      context.emit('update:modelValue', checkedFields.value)
    });

    return {
      checkedFields,
      sumPrice,
      activePrices,
      form,
      changePrice,
      format,
      countMinus,
      countPlus
    };
  },
}
</script>

<style lang="scss" scoped>
.design-modal {

  &__main-content {
    padding-top: 24px;
    margin-bottom: 19px;
  }

  &__list-content {
    padding-bottom: 13px;
  }

  &__checkbox {
    display: inline-flex;
    align-items: center;

    input {
      display: block;
      opacity: 0;
      width: 0;
      height: 0;
      border: 0;
      background: 0;

      &:checked + .checkbox-span {
        background: #007DEB;
        border-color: #007DEB;
      }
    }

    .checkbox-span {
      width: 24px;
      height: 24px;
      flex: 0 0 auto;
      background: #FFFFFF;
      border: 1px solid #CCCCCC;
      box-sizing: border-box;
      border-radius: 3px;
      margin: 0 8px 0 0;
      display: flex;
      align-items: center;
      justify-content: center;

      &:before {
        content: '';
        background-image: url("data:image/svg+xml,%3Csvg width='17' height='13' viewBox='0 0 17 13' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M6.02124 13L0.130615 7.10938L2.26343 4.97656L6.02124 8.63281L14.6541 0L16.7869 2.13281L6.02124 13Z' fill='white'/%3E%3C/svg%3E%0A");
        width: 17px;
        height: 13px;
        flex: 0 0 auto;
      }
    }
  }
}
</style>
