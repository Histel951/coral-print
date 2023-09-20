<template>
  <div class="calc-content" :class="{'calc-content_loading': isLoading}">
    <div class="calc-content__fields">
      <Field v-for="field in fields" :key="`${field.label}${schemaIndex}${field.id}`" :field-schema="field"
             :top-line="Boolean(!field.noneTopLine)"/>
      <div v-if="checkboxes.length" class="calc-content__checkboxes">
        <div v-for="chunk in Math.ceil(checkboxes.length / 2)" :key="'chunk-'+chunk+schemaIndex" class="checkbox-line">
          <CheckboxWrap v-for="checkbox in checkboxes.slice((chunk - 1) * 2, chunk * 2)" :field-schema="checkbox"
                        :key="`${checkbox.label}${schemaIndex}`" :field-name="checkbox.formField"/>
        </div>
      </div>
    </div>
    <div class="calc-content__center">
      <Preview v-if="isSchemaRendered" :is-loading="isLoadingPrice" :previews="previews"/>
      <TextBlock class="text-block_design">
        <template v-slot:icon>
          <PencilIcon/>
        </template>
        <template v-slot:title>Дизайн макета</template>
        <template v-slot:content>
          <DesignLinks v-on:updateDesignPrice="updateDesignPrice"/>
        </template>
      </TextBlock>
    </div>
    <div class="calc-content__right">
      <CalcPrice :designPrice="designPrice"/>
      <CalcButton @click="addToCart" :is-disabled="Boolean(priceIsLoading)" class="calc-btn_flex calc-content__add-to-cart">
        Добавить в корзину
      </CalcButton>
      <div class="calc-content__discount-link">
        <DiscountsPrice
          :visible="true"
          :on-load="enableLoadDiscounts"
          :is-opened-modal="isOpenedDiscountModal"
          :on-close-modal="closeDiscountModal"
        />
        <div v-if="repeatCirculation" class="repeat-circulation" :class="{
          'repeat-circulation__disabled': priceIsLoading
        }">
          <div class="repeat-circulation__main-text"><span v-html="format(repeatCirculation, 12)" /> за штуку</div>
          <div>при повторном заказе</div>
        </div>
        <span v-else @click="enableLoadDiscounts()">
          <ActionLink :is-disabled="Boolean(priceIsLoading)" class="action-link_green" @click="openDiscountModal()" text="Можно дешевле!"/>
        </span>
      </div>
      <TextBlock class="text-block_term">
        <template v-slot:icon>
          <ClockIcon/>
        </template>
        <template v-slot:title>Сроки печати</template>
        <template v-slot:content><span v-html="page?.print_time_description"></span></template>
      </TextBlock>
    </div>
  </div>
  <div v-if="price && price.all_calc_data" v-html="price.all_calc_data"></div>
</template>

<script>
import Field from "./fields/Field";
import {computed, onBeforeUnmount, provide, ref, watch} from "vue";
import useForm from "../composables/useForm";
import useTypes from "../composables/useTypes";
import useFormSchema from "../composables/useFormSchema";
import TextBlock from "./TextBlock";
import PencilIcon from "./icons/PencilIcon";
import ClockIcon from "./icons/ClockIcon";
import DesignLinks from "./DesignLinks";
import ActionLink from "./ActionLink";
import CalcButton from "./CalcButton";
import CalcPrice from "./CalcPrice";
import usePrice from "../composables/usePrice";
import CheckboxWrap from "./fields/CheckboxWrap";
import {cloneDeep, debounce} from "lodash";
import useRestrictions from "@/composables/useRestrictions";
import DiscountsPrice from "@/components/discount/DiscountsPrice";
import useDiscount from "@/composables/useDiscount";
import Preview from "@/components/Preview";
import {POSITION, useToast} from "vue-toastification";
import "vue-toastification/dist/index.css";

export default {
  name: "CalcContent",
  components: {
    Preview,
    DiscountsPrice,
    CheckboxWrap,
    CalcPrice,
    CalcButton,
    ActionLink,
    DesignLinks,
    ClockIcon,
    PencilIcon,
    TextBlock,
    Field,
  },
  setup() {
    const {activeType} = useTypes();
    const {form} = useForm();
    const {
      fields,
      config,
      isSchemaRendered,
      schemaIndex,
      isLoading,
      priceUrl,
      calculator_id,
      page,
      previews,
      checkboxes
    } = useFormSchema();
    const {setPriceLoading, setPrice, price, waitActionsStack, priceIsLoading, repeatCirculation, format} = usePrice();

    const {
      discountVisible,
      setVisible,
      setDiscounts,
      discountsList,
      disabledDiscounts,
      setMinProductCount,
      setLoading,
      setLockButton
    } = useDiscount();
    const toast = useToast();
    const colorCount = ref(0)
    const isOpenedDiscountModal = ref(false);
    const designPrice = ref(0);
    const designServices = ref([]);
    const disabledCalcButton = ref(false);
    const isLoadingPrice = ref(false);
    const isDisabledCalcButtons = computed(() => disabledCalcButton.value || waitActionsStack.value.length);
    const {allowables} = useRestrictions();

    watch(isDisabledCalcButtons, () => {
      setTimeout(() => setPriceLoading(isDisabledCalcButtons.value), 100);
    });

    const {setRestriction, restrictions} = useRestrictions();

    const openDiscountModal = async () => {
      if (!isDisabledCalcButtons.value) {
        isOpenedDiscountModal.value = true;

        await enableLoadDiscounts();
        setVisible(true);
      }
    };

    const closeDiscountModal = () => {
      isOpenedDiscountModal.value = false;
      setVisible(false);
    };

    provide('colorCount', colorCount);
    provide('calculatorId', calculator_id);

    let formWatcher = undefined;
    let priceTimeout = null;
    let abortController = null;

    const onLoadDiscount = ref(false);

    const enableLoadDiscounts = async () => {
      if (!disabledCalcButton.value) {
        const oldValue = onLoadDiscount.value;
        onLoadDiscount.value = true;

        if (!oldValue) {
          await loadPrice();
        }
      }
    };

    const openDiscountPrices = () => {
      setVisible(!discountVisible.value);
    };

    const allowableCheck = async () => {
      let check = true;
      Object.keys(allowables.value).some(fieldName => {
        if (allowables.value[fieldName]?.active) {
          check = false;
        }

        return !check;
      });

      return check;
    };

    const loadPrice = async () => {
      setLockButton(true);
      setLoading(true);
      isLoadingPrice.value = true;
      if (priceTimeout) {
        clearTimeout(priceTimeout);
      }

      const getPrice = async () => {
        if (abortController && calculator_id.value) {
          disabledCalcButton.value = true;
          const priceResponse = await (await fetch(priceUrl.value + '&' + new URLSearchParams(form).toString(), {
            method: 'GET',
            signal: abortController.signal
          })).json();

          if (priceResponse.total_price || priceResponse.is_check_restriction) {
            await setPrice(priceResponse);
            disabledCalcButton.value = false;
            restrictions.value = {};

            if (priceResponse.repeat_circulation) {
              repeatCirculation.value = priceResponse.repeat_circulation;
            }
          } else {
            setRestriction(
              priceResponse.fields,
              priceResponse.message,
              true,
              priceResponse.restriction.max_size,
              priceResponse.restriction.min_size
            );

            await setPrice({
              item_price: 0,
              total_price: 0,
              all_calc_data: priceResponse?.all_calc_data
            });
            disabledCalcButton.value = true;
          }
        }
      };

      const getDiscounts = async () => {
        if (abortController && !disabledCalcButton.value && calculator_id.value) {
          const discounts = await (
            await fetch(
              `api/calculator/discount/${calculator_id.value}` + '?' + 'type=' + activeType.value.id + '&' + new URLSearchParams(form).toString(),
              {
                method: 'GET',
                signal: abortController.signal
              }
            )).json();

          setMinProductCount(discounts.discount_min_edition);
          setDiscounts(discounts.discounts);
          disabledDiscounts(false);
        }
        setLockButton(false);
      }

      priceTimeout = setTimeout(async () => {
        if (abortController) {
          abortController.abort();
        }
        abortController = new AbortController()

        disabledDiscounts(true);
        await getPrice();
        priceTimeout = null;

        if (onLoadDiscount.value) {
          await getDiscounts();
        }
        setLoading(false);
        isLoadingPrice.value = false;

        abortController = null;
      }, 50)
    }

    const debounceLoadPrice = debounce(loadPrice, 300);

    watch(isSchemaRendered, async (newValue) => {
      if (newValue && !formWatcher) {
        console.log('watched')
        await loadPrice();
        setTimeout(() => {
          formWatcher = watch(() => [form, waitActionsStack.value], async () => {
            try {
              if (!waitActionsStack.value.length && await allowableCheck()) {
                await debounceLoadPrice();
              } else {
                setLockButton(true);
                setLoading(true);
                isLoadingPrice.value = true;
                disabledCalcButton.value = true;
              }
            } catch (err) {
              console.log(err)
            }
          }, {deep: true});
        }, 1000);
      } else if (!newValue && formWatcher) {
        console.log('unwatch')
        formWatcher();
        formWatcher = undefined;
      }
    });

    const updateDesignPrice = (designProps) => {
      designPrice.value = designProps.price;
      designServices.value = designProps.services;
      designServices.value.forEach((service) => {
        service.checked = true;
      });
    };

    onBeforeUnmount(() => {
      formWatcher && formWatcher();
    });

    const addToCart = async () => {
      if (isDisabledCalcButtons.value) {
        return;
      }

      let cart = {};

      const getCartOrCreate = () => {
        if (localStorage.getItem('cart') === null) {
          cart.items = [];
          cart.cart_price = 0;
        } else {
          cart = JSON.parse(localStorage.cart)
        }
      };

      const addItemToCart = () => {
        const cartItem = cloneDeep(form);

        cartItem.index = cart.items.length > 0 ? cart.items[cart.items.length - 1].index + 1 : 0;

        cartItem.name = activeType.value.pagetitle;
        cartItem.item_price = price.value.item_price;
        cartItem.product_price = price.value.total_price;
        cartItem.design_price = designPrice.value;
        cartItem.calculator_id = calculator_id.value;
        cartItem.design_services = designServices.value;
        cartItem.client_designs = JSON.parse(sessionStorage.getItem('files')) ?? [];
        cartItem.design_comment = JSON.parse(sessionStorage.getItem('comment'))?.comment ?? '';
        cartItem.svg_id = activeType.value.svg_id;

        cartItem.weight = Number.parseFloat(price.value.weight);
        cartItem.total_price = cartItem.design_price + cartItem.product_price;

        const productCountByTypes = cartItem.quantity_types?.reduce((sum, current) => sum + current, 0);

        const countField = fields.value.find(field => field.type === 'count');
        if (countField.default != productCountByTypes && cartItem.product_count !== productCountByTypes) {
          cartItem.product_count = productCountByTypes;
        }

        cart.items.push(cartItem);

        cart.cart_price += cartItem.total_price;
      };

      const saveCart = () => {
        sessionStorage.removeItem('files');
        sessionStorage.removeItem('comment');
        localStorage.setItem('cart', JSON.stringify(cart));

        window.dispatchEvent(new CustomEvent('cart-changed', {
          detail: {
            cart: localStorage.getItem('cart')
          }
        }));
      };

      await getCartOrCreate();
      await addItemToCart();
      await saveCart();

      toast('Товар добавлен в корзину!', {
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
        icon: "icon-cp-check",
      });
    };

    return {
      activeType,
      fields,
      config,
      isSchemaRendered,
      schemaIndex,
      isLoading,
      isLoadingPrice,
      checkboxes,
      price,
      discountsList,
      designPrice,
      updateDesignPrice,
      openDiscountPrices,
      discountVisible,
      enableLoadDiscounts,
      isOpenedDiscountModal,
      closeDiscountModal,
      openDiscountModal,
      disabledCalcButton,
      page,
      previews,
      addToCart,
      designServices,
      waitActionsStack,
      toast,
      isDisabledCalcButtons,
      priceIsLoading,
      repeatCirculation,
      format
    }
  }
}
</script>

<style lang="scss">

.repeat-circulation  {
  text-align: center;
  font-size: 15px;
  color: #59A471;

  &__disabled {
    opacity: 0.4;
  }

  &__main-text {
    font-weight: 600;
  }
}

/*
  DO NOT DELETE!
  These classes are for toasts customization
*/
.Vue-Toastification__toast--default.custom-toast {
  background-color: #FFC730;
  color: #00195A;
  align-items: center;
  padding: 10px 20px;
}

.Vue-Toastification__toast-body.custom-body {
  font-family: Euclid Circular B, Arial, sans-serif;
  font-style: normal;
  font-weight: 500;
  font-size: 18px;
  line-height: 130%;
}
</style>

<style lang="scss" scoped>
.calc-content {
  &__right {
    border-top: 1px solid #E4E4E4;
    padding: 12px 0 0 0;
    margin: 25px 0 0 0;
  }

  &__center {
    padding: 30px 0 0 0;
  }

  &__discount-link {
    margin: 24px 0 0 0;
    text-align: center;
  }

  &__add-to-cart {
    width: 224px;
    margin: 12px auto 0;
  }

  &_loading {
    pointer-events: none;
    opacity: 0.6;
  }
}

.checkbox-line {
  border-top: 1px solid #E4E4E4;
  padding: 12px 0;
  display: flex;
}

@media all and (max-width: 480px) {
  .checkbox-line {
    flex-direction: column;
    border: none;
    padding: 0;
  }
}

@media all and (min-width: 768px) {
  .calc-content {
    display: flex;
    flex-flow: row wrap;

    &__fields {
      flex: 1 0 400px;
      max-width: 500px;
      margin: 0 36px 0 0;
    }

    &__center {
      padding: 22px 0 0 0;
      flex: 0 0 268px;
      margin: 0 auto;
    }

    &__right {
      flex: 0 0 100%;
    }
  }
}

@media all and (min-width: 1024px) {
  .calc-content {
    &__fields {
      margin: 0;
      flex: 1 1 1px;
      min-width: 0;
      max-width: 568px;
    }

    &__right {
      padding: 16px 0 0 0;
      flex: 0 0 230px;
      border: none;
      margin: 0;
    }

    &__center {
      margin: 0 48px;
    }
  }
}

@media all and (min-width: 1280px) {
  .calc-content {
    &__center {
      margin: 0 64px;
      flex: 0 0 320px;
    }

    &__discount-link {
      margin: 20px 0 0 0;
    }

    &__add-to-cart {
      margin: 20px auto 0;
    }
  }
}

@media all and (min-width: 1400px) {
  .calc-content {
    &__center {
      margin: 0 75px;
      flex: 0 0 406px;
    }

    &__right {
      margin: 0 auto;
    }
  }
}
</style>
