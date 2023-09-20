<template>
  <div class="booklets-bottom-preview-size" :style="sizeDivStyle">
    <div class="booklets-bottom-preview-size-container">
      <div class="booklets-bottom-preview-svg">
        <svg :width="svgWidth" :height="svgHeight">
          <use :xlink:href="'#' + svgId"></use>
        </svg>
        <div class="booklets-bottom-preview-text">
          В сложенном<br>виде:<br>
          {{ widthSize }}x{{ form.height }} мм
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import useForm from "@/composables/useForm";
import {watch, ref, onMounted} from "vue";

export default {
  props: {
    svgId: String,
    folds: {
      type: Number,
      default: 0
    },
    sizeDivStyle: {
      type: Object,
      default: () => {}
    },
    svgWidth: {
      type: Number,
      default: 64
    },
    svgHeight: {
      type: Number,
      default: 100
    },
  },
  name: "PreviewSizeBottomBooktelt",
  setup(props) {
    const {form} = useForm();

    const widthSize = ref(form.width);

    const changeWidth = (newWidthSize, newFoldCount) => {
      if (newFoldCount) {
        widthSize.value = Math.ceil(newWidthSize / (newFoldCount + 1));
      } else {
        widthSize.value = newWidthSize;
      }
    };

    onMounted(() => {
      changeWidth(form.width, form.fold_count ?? props.folds);

      watch(() => [form.width, form.fold_count, props.folds], ([newWidthSize, newFoldCount]) => {
        changeWidth(newWidthSize, newFoldCount ?? props.folds);
      });
    });

    return {
      widthSize,
      form
    };
  }
}
</script>

<style scoped>
.booklets-bottom-preview-size {
  margin-top: 28px;
  margin-left: 28px;
}

.booklets-bottom-preview-size-container {
  display:flex;
  flex-direction: row;
  place-content: center space-evenly;
  flex-wrap: nowrap;
  justify-content: flex-start;
  align-content: center;
  align-items: baseline;
  width: 70%;
}

.booklets-bottom-preview-text {
  margin-left: 16px;
  white-space: nowrap;
  font-size: 12px;
}

.booklets-bottom-preview-svg {
  display: flex;
  flex-direction: row;
  align-content: center;
  justify-content: center;
  align-items: normal
}
</style>
