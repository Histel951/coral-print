<template>
  <FieldModal
    :is-loading="isLoadingDiscount"
    :opened="isOpenedModal"
    :on-close="onCloseModal"
    :title="discountsList.length && !isLoadingDiscount ? 'Можно дешевле!' : ''"
    :header-styles="{
      textAlign: 'initial',
      paddingBottom: '0'
    }"
    :header-text-styles="{
      display: 'block',
      lineHeight: 2,
      fontSize: '20px',
      fontWeight: '600',
      height: 'auto'
    }">
    <ModalContent>
      <div class="discount-panel">
        <div v-if="!discountsList.length && minProductCount !== form.product_count && totalPrice === minPrice">
          <DiscountHeader :text="''" />
          <DiscountWarn />
        </div>
        <div v-else-if="discountsList.length && !isLoadingDiscount">
          <DiscountHeader :text="''" />
          <DiscountBody :on-check="setActiveDiscount" :text="'Заказывайте больше — экономьте нa уменьшении стоимости'" />
        </div>
        <div v-else>
          <DiscountHeader :text="''" />
          <DiscountBestPrice />
        </div>
      </div>
      <div v-if="!discountsList.length && minProductCount !== form.product_count && totalPrice === minPrice">
        <DiscountFooter :on-click="warnChangeEdition" :text="'Изменить тираж'" />
      </div>
      <div v-else-if="discountsList.length && !isLoadingDiscount">
        <DiscountFooter :on-click="discountChangeEdition" :text="'Изменить тираж'" />
      </div>
    </ModalContent>
  </FieldModal>
</template>

<script>
import DiscountHeader from "@/components/discount/DiscountHeader";
import DiscountBody from "@/components/discount/DiscountBody";
import DiscountFooter from "@/components/discount/DiscountFooter";
import useDiscount from "@/composables/useDiscount";
import DiscountBestPrice from "@/components/discount/DiscountBestPrice";
import usePrice from "@/composables/usePrice";
import useFormSchema from "@/composables/useFormSchema";
import DiscountWarn from "@/components/discount/DiscountWarn";
import useForm from "@/composables/useForm";
import {watch, ref} from "vue";
import FieldModal from "@/components/modals/FieldModal";
import ModalContent from "@/components/modals/ModalContent";

export default {
  name: "DiscountsPrice",
  components: {
    ModalContent, FieldModal, DiscountWarn, DiscountBestPrice, DiscountFooter, DiscountBody, DiscountHeader},
  props: {
    visible: {
      type: Boolean,
      default: false
    },
    onCloseModal: Function,
    isOpenedModal: {
      type: Boolean,
      default: false
    }
  },

  setup(props) {
    const {
      discountsList,
      discountActive,
      setActiveDiscount,
      minProductCount,
      isLoadingDiscount,
      setLockButton,
      setLoading
    } = useDiscount();
    const {price} = usePrice();
    const {minPrice} = useFormSchema();
    const {form} = useForm();

    const totalPrice = ref(0);

    const warnChangeEdition = () => {
      if (minProductCount.value) {
        form.product_count = minProductCount.value;
        setLockButton(true);
        setLoading(true);
        props.onCloseModal();
      }
    };

    const discountChangeEdition = () => {
        form.product_count = discountActive.value.product_count;
        setLockButton(true);
        props.onCloseModal();
    }

    watch(price, () => {
      totalPrice.value = price.value.total_price;
    });

    return {
      discountsList,
      price,
      minPrice,
      totalPrice,
      warnChangeEdition,
      discountChangeEdition,
      setActiveDiscount,
      isLoadingDiscount,
      minProductCount,
      form
    };
  }
}
</script>

<style lang="scss" scoped>

.modal-content {
  padding: 0;
}

.modal-header {
  border-bottom: 1px solid #e5e5e5;
}

.modal-loader {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 200px;
}

.discount-panel {
  background: #FFFFFF;
  padding: 0 16px 16px;
  height: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  -webkit-box-shadow: 0 0 56px -3px rgba(34, 60, 80, 0.24);
  -moz-box-shadow: 0 0 56px -3px rgba(34, 60, 80, 0.24);
  box-shadow: 0 0 56px -3px rgba(34, 60, 80, 0.24);
  border-radius: 4px;
}
</style>
