<template>
  <div class="colors-container">
    <ColorPreview
      v-for="preview in previewsList"
      :preview-color="'#fff'"
      :preview-img="preview?.image?.url"
      :key="preview?.image?.url"
      :add-styles="preview?.styles"
    />
  </div>
</template>

<script>
import ColorPreview from "@/components/fields/ColorPreview";
import {watchEffect, ref} from 'vue';
import cloneDeep from "lodash/cloneDeep";

export default {
  name: "ManyColorPreviews",
  components: {ColorPreview},
  props: {
    zIndexStart: {
      type: Number,
      default: 10
    },
    isOverlayColors: {
      type: Boolean,
      default: true
    },
    previews: {
      type: Array,
      default: () => []
    }
  },
  setup(props) {
    const previewsList = ref(props.previews);

    const changeStyles = () => {
      previewsList.value = props.previews;

      if (!props.isOverlayColors) {
        previewsList.value.forEach((preview, index) => {
          let marginLeft = 0;

          if (index != 0) {
            marginLeft = '4px';
          }

          preview.styles = {
            marginLeft,
            width: '12px',
            height: '12px'
          };

          return preview;
        });
        return;
      }

      let zIndex = cloneDeep(props.zIndexStart);
      previewsList.value.forEach(preview => {
        let marginRight = '-6px';
        let marginLeft = 0;

        if (preview.is_additional_paint) {
          marginRight = 0;
          marginLeft = '12px';
        }

        preview.styles = {
          marginRight,
          marginLeft,
          zIndex,
          width: '12px',
          height: '12px'
        };

        zIndex -= 1;

        return preview;
      });
    }

    watchEffect(() => {
      changeStyles();
    });

    return {
      previewsList
    }
  }
}
</script>

<style lang="scss" scoped>
.colors-container {
  display: inline-flex;
  margin-left: 3px;
  align-items: center;
}
</style>
