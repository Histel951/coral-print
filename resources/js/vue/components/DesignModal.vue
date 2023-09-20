<template>
  <FieldModal :opened="p.opened.value" size="lg" title="Дизайн макетов" class="design-modal__title" typeModal="design"
              headerCloseClasses="design-modal__close-btn">
    <ModalContent size="lg">
      <div v-if="isLoading">
        <Preloader/>
      </div>
      <div v-if="!isLoading">
        <div class="design-modal__tabs" ref="tabs">
          <ul class="design-modal__list">
            <li class="design-modal__item" :class="{active: stateTab.order}" @click="showTab('order')">Заказать у нас
            </li>
            <li class="design-modal__item" :class="{active: stateTab.upload}" @click="showTab('upload')">Загрузить свой
              макет
            </li>
          </ul>
        </div>
        <div v-if="stateTab.order">
          <DesignOrderTab v-model="state" :prices="prices" v-on:updateDesignPrice="emitPrice"/>
        </div>
        <div v-if="stateTab.upload">
          <DesignUploadTab v-on:chooseFiles="chooseFiles"/>
        </div>
      </div>
    </ModalContent>
  </FieldModal>
</template>

<script>
import FieldModal from "@/components/modals/FieldModal";
import ModalContent from "@/components/modals/ModalContent";
import Preloader from "@/components/Preloader";
import {inject, ref, toRefs, watchEffect} from "vue";
import debounce from "lodash/debounce";
import DesignUploadTab from "@/components/DesignUploadTab";
import DesignOrderTab from "@/components/DesignOrderTab";

export default {
  name: "DesignModal",
  components: {DesignOrderTab, DesignUploadTab, Preloader, ModalContent, FieldModal},
  emits: ['update:modelValue', 'updateDesignPrice', 'chooseFiles'],
  props: {
    tab: String,
    modelValue: Number,
    opened: Boolean,
  },
  setup(props, context) {
    const p = toRefs(props);
    const tabs = ref(null);
    const state = ref([]);
    const prices = ref([]);
    const isLoading = ref(true);
    const isLoaded = ref(false);
    const calculatorId = inject('calculatorId');
    const stateTab = ref({
      'order': false,
      'upload': false,
    });

    const emitPrice = (price, activePrices) => context.emit('updateDesignPrice', price, activePrices);
    const loadDesignPrices = async () => {
      isLoading.value = true;
      const data = await (await fetch('api/calculator/prices/' + calculatorId.value, {
        method: 'GET',
      })).json();
      prices.value = data.prices;
      prices.value.forEach((price) => {
        price.count = 1;
      });
      isLoading.value = false;
      isLoaded.value = true;
    }

    const debounceLoadDesignPrices = debounce(loadDesignPrices, 300);
    const showTab = (tab) => Object.keys(stateTab.value).forEach(v => stateTab.value[v] = v === tab)

    watchEffect(() => {
      if (p.opened.value) {
        tabs.value && showTab(props.tab);
        !isLoaded.value && debounceLoadDesignPrices();
      }
    });

    const chooseFiles = (comment) => {
      context.emit('chooseFiles', comment);
    };

    return {
      stateTab,
      state,
      tabs,
      emitPrice,
      showTab,
      prices,
      p,
      isLoading,
      chooseFiles
    }
  },
}
</script>

<style lang="scss">
.design-modal {
  &__title {
    text-align: left;
    font-style: normal;
    font-weight: 600;
    font-size: 22px;
    line-height: 26px;
    color: #00195A;
  }

  &__main-content {
    font-style: normal;
    font-weight: 400;
    font-size: 15px;
    line-height: 130%;
    color: #1E1E1E;
  }

  &__tabs {
    overflow: auto;
    margin-top: -15px;
    padding-right: 21px;
  }

  &__list {
    font-family: Euclid Circular B, Arial, Tahoma, sans-serif;
    font-weight: 500;
    font-size: 15px;
    line-height: 120%;
    color: #00195a;
    display: -webkit-inline-flex;
    display: -ms-inline-flexbox;
    display: inline-flex;
    flex-flow: row nowrap;
    white-space: nowrap;
    margin: 0;
    padding: 0;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    justify-content: flex-start;
    border-bottom: 1px solid #d6dee3
  }

  &__item {
    cursor: pointer;
    display: flex;
    align-items: center;
    padding: 0 0 10px 0;
    border-bottom: 2px solid transparent;
    margin: 0 20px -1px 0
  }

  &__item.active {
    color: #007deb;
    border-color: #007deb;
  }

  &__footer {
    width: 100%;
    display: flex;
    flex-flow: row wrap;
    align-items: center;

    &__info {
      color: #8E8E8E;
      flex: 1 1 1px;
      min-width: 0;
      text-align: left;
      margin: 0 30px 0 0;
      font-style: normal;
      font-weight: 400;
      font-size: 14px;
      line-height: 21px;
    }

    &__price {
      text-align: center;
      font-family: Euclid Circular B, Arial, sans-serif;
      font-style: normal;
      font-weight: 600;
      font-size: 22px;
      line-height: 26px;
      color: #00195A;
      flex: 0 0 auto;
      margin: 0 16px 0 25px;
    }

    &__btn {
      display: flex;
      justify-content: center;
      flex: 0 0 auto;
    }

    &__submit {
      width: 136px;
    }
  }

  &__close-btn {
    position: absolute;
    right: 10px;
    top: 10px;
  }
}

.modal-footer {
  margin-top: 10px;
  overflow: auto;
  flex: 0 0 auto;
  border-top: 1px solid #CCCCCC;
  display: flex;
  align-items: center;
  padding-top: 32px;

  &_center {
    justify-content: center;
  }
}

@media all and (max-width: 767px) {
  .design-modal__item {
    margin-top: 40px;
  }
}
</style>
