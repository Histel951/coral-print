<template>
  <div class="design-links">
    <ActionLink text="Загрузите свой" @click="openModal('upload')"/>
    или
    <ActionLink text="закажите у нас" @click="openModal('order')"/>
    <br/>
    <ActionLink class="design-links__constructor" text="Конструктор макетов" @click="openModal('constructor')"/>
  </div>
  <div v-show="mOpened">
    <DesignModal v-model="designPrice" :tab="tab" :opened="mOpened" v-on:updateDesignPrice="emitPrice" v-on:chooseFiles="chooseFiles" @close="closeModal"/>
  </div>
</template>

<script>
import ActionLink from "./ActionLink";
import {ref} from "vue";
import DesignModal from "@/components/DesignModal";

export default {
  name: "DesignLinks",
  components: {DesignModal, ActionLink},
  emits: ['updateDesignPrice'],
  props: {
    modelValue: Number,
  },
  setup(props, context) {
    const mOpened = ref(false);
    const designPrice = ref(0);
    const tab = ref('');

    const openModal = (tabName) => {
      mOpened.value = true;
      tab.value = tabName;
    }

    const closeModal = () => {
      mOpened.value = false;
    }

    const chooseFiles = (comment) => {
      if (comment !== '' && sessionStorage.getItem('files') !== null) {
        sessionStorage.setItem('comment', JSON.stringify({comment: comment}));
      } else if (sessionStorage.getItem('comment') !== null) {
        sessionStorage.removeItem('comment');
      }

      closeModal();
    };

    const emitPrice = (price, activePrices) => {
      context.emit('updateDesignPrice', price, activePrices);
      closeModal();
    }

    return {
      designPrice,
      tab,
      mOpened,
      openModal,
      closeModal,
      emitPrice,
      chooseFiles
    }
  },
}
</script>

<style lang="scss" scoped>
.design-links {
  line-height: 36px;
}

@media all and (min-width: 1024px) {
  .design-links {
    &__constructor {
      display: none;
    }
  }
}
</style>
