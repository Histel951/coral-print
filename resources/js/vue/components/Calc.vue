<template>
  <div class="calc">
    <div class="calc__container">
      <CalcArrow/>
      <div class="calc__wrap">
        <div class="calc__top">
          <div class="calc__title">{{ activeType.pagetitle }}</div>
          <div v-if="page?.is_show_constructor || activeType.show_print_type" class="calc__top-links">
            <ActionLink v-if="page?.is_show_constructor" class="action-link_top action-link_constructor" :icon-component="constructorIcon" text="Конструктор макетов"/>
            <ActionLink v-if="activeType.show_print_type" class="action-link_top" :icon-component="printTypesIcon" text="Виды печати" @click="openTooltip"/>
            <div v-if="tooltipOpened">
              <TooltipLong :opened="tooltipOpened" :tooltip="tooltip ?? ''" @close="closeTooltip"/>
            </div>
          </div>
        </div>
        <CalcContent/>
      </div>
    </div>
  </div>
</template>

<script>
import ConstructorIcon from './icons/ConstructorIcon';
import PrintTypesIcon from "./icons/PrintTypesIcon";
import CalcArrow from "./CalcArrow";
import useTypes from "../composables/useTypes";
import useFormSchema from "../composables/useFormSchema";
import CalcContent from "./CalcContent";
import ActionLink from "./ActionLink";
import {ref, watchEffect} from "vue";
import TooltipLong from "@/components/TooltipLong";
import useTooltips from "@/composables/useTooltips";

export default {
  name: "Calc",
  components: {
    TooltipLong,
    ActionLink,
    CalcContent,
    CalcArrow,
  },
  props: {
    title: String,
  },
  setup() {
    const {activeType} = useTypes();
    const {fields, config, page} = useFormSchema();
    const {tooltips} = useTooltips();
    const tooltipOpened = ref(false);

    const tooltip = ref({})
    watchEffect(() => {
      if (tooltips.value) {
        for (let t in tooltips.value) {
          if (tooltips.value[t].name === 'tooltip_print') {
            tooltip.value = tooltips.value[t];
          }
        }
      }
    })

    const openTooltip = () => {
      if (tooltip.value.name !== undefined) {
        tooltipOpened.value = true;
      }

    }
    const closeTooltip = () => {
      tooltipOpened.value = false;
    }

    return {
      activeType,
      fields,
      tooltip,
      tooltipOpened,
      openTooltip,
      closeTooltip,
      config,
      constructorIcon: ConstructorIcon,
      printTypesIcon: PrintTypesIcon,
      page
    }
  }
}
</script>

<style lang="scss" scoped>
.calc {
  &__container {
    background: #F1F2F0;
    padding: 40px 0;
    position: relative;
  }

  &__wrap {
    max-width: 1472px;
    padding: 0 16px;
    margin: 0 auto;
  }

  &__loader-container {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  &__title {
    font-family: Euclid Circular B, Arial, sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 24px;
    line-height: 120%;
    text-align: center;
    color: #00195A;
    margin: 0 0 10px 0;
  }

  &__top {
    border-bottom: 1px solid #E4E4E4;
    margin: 0 0 8px 0;
    padding: 0 0 20px 0;
  }

  &__top-links {
    display: flex;
    justify-content: center;
    align-items: center;
  }
}

@media all and (min-width: 768px) {
  .calc {
    &__container {
      padding: 30px 0 35px;
    }
    &__wrap {
      padding: 0 32px;
    }
    &__title {
      margin: 0 30px 0 0;
      flex: 1 1 1px;
      min-width: 0;
      text-align: left;
      font-size: 28px;
    }
    &__top {
      display: flex;
      align-items: center;
    }
  }
}

@media all and (min-width: 1280px) {
  .calc {
    &__wrap {
      padding: 0 80px;
    }
  }
}

</style>
