<template>
  <span class="calc-price__value" ref="refSpan" :style="{color, fontSize: fontSize + 'px'}" v-html="format(price, rubFontSize)" />
</template>

<script>
import usePrice from "@/composables/usePrice";
import {onMounted, ref} from "vue";

export default {
  props: {
    color: String,
    price: {
      type: Number,
      default: 0
    },
    fontSize: Number
  },
  name: "Price",
  setup() {
    const {format} = usePrice();
    const refSpan = ref(null);
    const rubFontSize = ref(0);

    onMounted(() => {
      const styleFontSize = Number(window.getComputedStyle(refSpan.value).fontSize.replace(/px/, ''));
      rubFontSize.value = styleFontSize - 4;
    });

    return {
      format,
      refSpan,
      rubFontSize
    };
  }
}
</script>

<style lang="scss" scoped>
.calc-price {
  &__value {
    letter-spacing: 0.03em;
  }
}
</style>
