<template>
    <div class="tooltip" id="tooltip" ref="tooltip" :class="addClasses">
      <div class="tooltip_body" ref="tooltipBody" v-html="content"></div>
      <div class="tooltip_down" ref="tooltipDown">
        <svg width="80" height="16" viewBox="0 0 80 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M80.0001 -8.96454e-05C69.7001 -8.87449e-05 64.4501 1.11992 56.5001 8.10662L52.8501 11.3066C49.3 14.4533 44.65 16 40 16C35.35 16 30.7 14.4533 27.15 11.3066L23.5 8.10663C15.55 1.11992 10.2999 -8.3552e-05 -7.76927e-05 -8.26515e-05L80.0001 -8.96454e-05Z"
            fill="#5A6E8C"/>
        </svg>
      </div>
    </div>
</template>

<script>

import {onMounted, ref} from "vue";
import {computePosition} from '@floating-ui/dom';

export default {
  name: "TooltipShortContent",
  emits: ['update:modelValue'],
  props: {
    content: {
      type: String,
      default: ''
    },
    modelValue: Boolean,
    addClasses: String,
    containerPositionX: Number,
    noMoveTooltip: {
      type: Boolean,
      default: false,
    }
  },
  setup(props) {
    const tooltip = ref(null);
    const tooltipBody = ref(null);
    const tooltipDown = ref(null);

    const moveTooltip = () => {
      const tooltipLeftValue = parseInt(window.getComputedStyle(tooltip.value).left);
      const tooltipWidth = parseInt(window.getComputedStyle(tooltip.value).width);
      const tooltipOffset = 20;
      let tooltipDownStyles = {};

      if (props.containerPositionX  < tooltipWidth / 2) {
        tooltip.value.style.left = Math.trunc(tooltipLeftValue + tooltipWidth / 2 - props.containerPositionX) + 'px';
        tooltipDownStyles.marginRight = 2 * Math.trunc(  tooltipWidth / 2 - props.containerPositionX) + 'px';
      }

      if (window.innerWidth - props.containerPositionX  < tooltipWidth / 2) {
        tooltip.value.style.left = Math.trunc(tooltipLeftValue - (tooltipWidth / 2 - (window.innerWidth - props.containerPositionX)) - tooltipOffset) + 'px';
        tooltipDownStyles.marginLeft = 2 * Math.trunc(tooltipWidth / 2 - window.innerWidth + props.containerPositionX) + 2 * tooltipOffset + 'px';
        tooltipDownStyles.marginTop = '-3px'
      }

      computePosition(tooltipBody.value, tooltipDown.value, {
        placement: 'bottom'
      }).then(() => {
        Object.assign(tooltipDown.value.style, tooltipDownStyles);
      });
    }

    onMounted(() =>   {
      if (!props.noMoveTooltip) {
        moveTooltip();
      }
    })

    return {
      tooltip,
      tooltipDown,
      tooltipBody
    }
  }
}
</script>

<style >
.tooltip_container {
  position: relative;
}
.tooltip_body {
  background: #5A6E8C;
  border-radius: 4px;
  color: #FFFFFF;
  padding: 16px;
  white-space: pre-wrap;
}

.tooltip_down {
  margin-top: -1px;
}

.tooltip {
  position: absolute;
  left: -129px;
  bottom: 22px;

  z-index: 90;

  width: 288px;
  height: auto;

  display: flex;
  flex-direction: column;
  align-items: center;

  overflow: hidden;
}

.tooltip_count {
  left: -207px;
  bottom: 12px;
  width: 322px;
}

.tooltip_img {
  height: 160px;
  border-radius: 4px;
  display: flex;
  overflow: hidden;
}
.tooltip_img img {
  width: 258px;
  height: 160px;
}
.tooltip_header {
  font-family: 'Euclid Circular B';
  font-style: normal;
  font-weight: 600;
  font-size: 17px;
  line-height: 0;
  padding-bottom: 10px;
  margin: 5px 0 -10px 0;
}
.tooltip_text {
  font-family: 'Inter';
  font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 120%;
  white-space: pre-wrap;
}

.tooltip_text > a {
  color: #fff;
  text-decoration: underline;
}

.tooltip_icon {
  padding: 5px;
  cursor: pointer;
}
.overlay {
  width: 100%;
  height: 100%;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 50;
}
</style>
