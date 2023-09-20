<template>
  <div class="tooltip_container">
        <span class="tooltip_icon" v-if="iconShow" @click="toggleTooltip($event)">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" ref="tooltip_icon">
      <path opacity="0.6" d="M9.56534 19.5653C14.8501 19.5653 19.1307 15.2848 19.1307 9.99997C19.1307 4.71517 14.8501 0.434631 9.56534 0.434631C4.28054 0.434631 0 4.71517 0 9.99997C0 15.2848 4.28054 19.5653 9.56534 19.5653ZM9.56534 18.4119C4.91193 18.4119 1.15341 14.6434 1.15341 9.99997C1.15341 5.34656 4.91193 1.58804 9.56534 1.58804C14.2188 1.58804 17.9773 5.34656 17.9773 9.99997C17.9773 14.6434 14.2188 18.4119 9.56534 18.4119ZM8.87926 12.2272H10.0724V12.1676C10.0923 10.9346 10.4105 10.3977 11.2855 9.85082C12.1605 9.31886 12.6776 8.55324 12.6776 7.45452C12.6776 5.90338 11.544 4.76986 9.79403 4.76986C8.18324 4.76986 6.90554 5.76418 6.83097 7.45452H8.08381C8.15838 6.28122 8.97869 5.80395 9.79403 5.80395C10.7287 5.80395 11.4844 6.42043 11.4844 7.39486C11.4844 8.18534 11.032 8.7521 10.4503 9.10509C9.47585 9.6967 8.89418 10.2734 8.87926 12.1676V12.2272ZM9.51563 15.1704C10.0078 15.1704 10.4105 14.7677 10.4105 14.2755C10.4105 13.7834 10.0078 13.3807 9.51563 13.3807C9.02344 13.3807 8.62074 13.7834 8.62074 14.2755C8.62074 14.7677 9.02344 15.1704 9.51563 15.1704Z" fill="#8E8E8E"/>
      </svg>
    </span>
    <div v-if="modelValue">
      <TooltipShortContent :tooltip-opened="modelValue" :content="content" :add-classes="addClasses" :containerPositionX="containerPositionX" :no-move-tooltip="noMoveTooltip"/>
    </div>
  </div>
</template>

<script>
import TooltipShortContent from "@/components/fields/TooltipShortContent";
import {ref, watchEffect} from "vue";

export default {
  name: "TooltipShort",
  components: {TooltipShortContent},
  emits: ['update:modelValue'],
  props: {
    content: String,
    modelValue: Boolean,
    iconShow: {
      type: Boolean,
      default: true,
    },
    addClasses: String,
    noMoveTooltip: {
      type: Boolean,
      default: false,
    }
  },

  setup(props, context) {
    const containerPositionX = ref(0);
    const tooltip_icon = ref({});

    const toggleTooltip = (e) => {
      context.emit('update:modelValue', !props.modelValue)
      containerPositionX.value = e.target.getBoundingClientRect().left
    }

    watchEffect(() => {
      if (props.modelValue && tooltip_icon.value.getBoundingClientRect) {
        containerPositionX.value = tooltip_icon.value.getBoundingClientRect().left
      }
    });

    return {
      containerPositionX,
      tooltip_icon,
      toggleTooltip
    }
  }
}
</script>

<style scoped>
.tooltip_container {
  position: relative;
}

.tooltip_icon {
  padding: 5px;
  cursor: pointer;
}
</style>
