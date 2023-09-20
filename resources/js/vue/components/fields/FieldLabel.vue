<template>
  <div class="field-label" :class="aditionalClass">
    <span :class="{'field-label__dashed': fieldSchema.text_decoration === 'dashed', 'tooltip_label': issetTooltip('long') || issetTooltip('short')}" @click="toggleTooltip">
      {{ labelText }}
    </span>
    <span v-if="labelInnerText" class="field-label__sub-label">
         {{ labelInnerText }}
    </span>
    <TooltipShort v-if="issetTooltip('short')" :content="getTooltip(fieldName)?.content" v-model="tooltipOpened"/>
    <span @click="openTooltip" class="tooltip_icon" v-if="issetTooltip('long')">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path opacity="0.6"
                d="M9.56534 0.434504C14.8501 0.434504 19.1307 4.71504 19.1307 9.99984C19.1307 15.2846 14.8501 19.5652 9.56534 19.5652C4.28054 19.5652 0 15.2846 0 9.99984C0 4.71504 4.28054 0.434504 9.56534 0.434504ZM9.56534 1.58791C4.91193 1.58791 1.15341 5.35638 1.15341 9.99984C1.15341 14.6533 4.91193 18.4118 9.56534 18.4118C14.2187 18.4118 17.9773 14.6533 17.9773 9.99984C17.9773 5.35638 14.2187 1.58791 9.56534 1.58791ZM10.2415 15.0908H8.8892L8.98864 8.77257H10.142L10.2415 15.0908ZM9.56534 4.82939C10.0575 4.82939 10.4602 5.23209 10.4602 5.72428C10.4602 6.21646 10.0575 6.61916 9.56534 6.61916C9.07315 6.61916 8.67045 6.21646 8.67045 5.72428C8.67045 5.23209 9.07315 4.82939 9.56534 4.82939Z"
                fill="#8E8E8E"/>
        </svg>
    </span>
    <div v-if="tooltipOpened && issetTooltip('long')">
      <TooltipLong :opened="tooltipOpened" :tooltip="tooltips ? getTooltip(fieldName) : ''" @close="closeTooltip"/>
    </div>
  </div>
</template>

<script>

import {ref} from "vue";
import TooltipShort from "@/components/fields/TooltipShort";
import TooltipLong from "@/components/TooltipLong";
import useTooltips from "@/composables/useTooltips";
import onClickOutside from "vue-click-outside-hook";

export default {
  name: "FieldLabel",
  components: {
    TooltipLong,
    TooltipShort,
  },
  props: {
    labelText: String,
    labelInnerText: String,
    info: [Object, Boolean],
    modalLink: String,
    aditionalClass: String,
    fieldSchema: Object,
    fieldName: {
      type: String,
      default: ''
    }
  },
  setup(props) {
    const {tooltips, getTooltip} = useTooltips();

    const aditionalTooltipsClass = {
      'field-label__tooltip': tooltips.value && tooltips.value[props.fieldName] && tooltips.value[props.fieldName].type === 'long'
    }

    const tooltipOpened = ref(false);

    const issetTooltip = (type) => tooltips.value && tooltips.value[props.fieldName] && tooltips.value[props.fieldName].type === type;

    const toggleTooltip = () => {
      tooltipOpened.value = !tooltipOpened.value;
    }

    const openTooltip = () => {
      tooltipOpened.value = true;
    }

    const closeTooltip = () => {
      tooltipOpened.value = false;
    }

    onClickOutside(() => {
      tooltipOpened.value = false;
    });

    return {
      aditionalTooltipsClass,
      tooltipOpened,
      issetTooltip,
      openTooltip,
      closeTooltip,
      tooltips,
      getTooltip,
      toggleTooltip
    }
  }
}
</script>

<style lang="scss" scoped>
.field-label {
  font-weight: 600;
  font-size: 14px;
  line-height: 115%;
  flex: 0 0 98px;
  display: flex;
  align-items: center;

  &__dashed {
    border-bottom: 1px dashed #6e6e6e;
    padding-bottom: 1px;
  }

  &__sub-label {
    font-weight: normal;
    color: #ABABAB;
    margin: 0 0 0 4px;
    display: none;
  }

  &__tooltip {
    text-decoration: dashed underline;
    cursor: pointer;
  }
}

.tooltip_icon {
  padding: 5px;
  cursor: pointer;
}

.tooltip_modal_content {
  font-weight: normal;
}

.tooltip_label {
  cursor: pointer;
  border-bottom: 1px dashed #6e6e6e;
  padding-bottom: 1px;
}

@media all and (min-width: 768px) {
  .field-label {
    flex: 0 0 120px;
    &__sub-label {
      display: inline;
    }
  }
}
</style>
