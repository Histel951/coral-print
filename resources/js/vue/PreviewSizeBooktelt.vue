<template>
  <div class="booklets-preview-container">
    <div class="width-size" :style="widthStyles">
      {{ form.width }} мм
    </div>
    <svg :width="svgWidth" :height="svgHeight">
      <use :xlink:href="'#' + svgId"></use>
    </svg>
    <div class="height-size no-wrap" :style="heightStyles">
      {{ form.height }} мм
    </div>
  </div>
</template>

<script>
import useForm from "@/composables/useForm";

export default {
  props: {
    svgId: String,
    svgWidth: {
      type: Number,
      default: 168
    },
    svgHeight: {
      type: Number,
      default: 120
    },
    heightStyles: {
      type: Object,
      default: () => {}
    },
    widthStyles: {
      type: Object,
      default: () => {}
    }
  },
  name: "PreviewSizeBooktelt",
  setup() {
    const {form} = useForm();

    return {
      form
    };
  }
}
</script>

<style scoped>
.no-wrap {
  white-space: nowrap;
  min-height: 36px;
  max-height: 36px;
}

.width-size {
  text-align: center;
  font-size: 12px;
}

.height-size {
  font-size: 12px;
  writing-mode: vertical-lr;
}
</style>
