<template>
  <div v-if="previewImg || previewColor" class="color-preview" :style="{...styles, ...addStyles}"></div>
</template>

<script>
import {computed} from "vue";

export default {
  name: "ColorPreview",
  props: {
    previewColor: String,
    previewImg: String,
    addStyles: {
      type: Object,
      default: () => {}
    }
  },
  setup(props) {

    const styles = computed(() => {
      const style = {};
      if (props.previewColor) {
        style.backgroundColor = props.previewColor;
        if (!props.previewImg && props.previewColor.toLowerCase().indexOf('#fff') > -1) {
          style.border = '1px solid #8E8E8E';
        }
      }
      if (props.previewImg) {
        style.backgroundImage = `url(${props.previewImg})`;
      }
      return style;
    });

    return {
      styles
    }
  }
}
</script>

<style lang="scss" scoped>
.color-preview {
  width: 16px;
  height: 16px;
  box-sizing: border-box;
  background-position: center;
  background-size: cover;
  border-radius: 50%;
}
</style>
