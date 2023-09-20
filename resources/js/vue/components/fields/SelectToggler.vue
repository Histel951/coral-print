<template>
  <div class="select-toggler" :style="toggleStyle" :class="{error: isError}">
    <ColorPreview
      v-if="!isImg"
      :add-styles="stylesPreview"
      class="select-toggler__preview"
      :preview-color="previewColor"
      :preview-img="previewImg"
    />
    <img v-else :style="{marginRight: '8px'}" class="select_toggler__img" :src="previewImg">
    <div class="select-toggler__label">
      <span v-if="prevText" v-html="prevText"></span>
      <span v-html="label"></span><span v-if="isUsePostTextIcon && postNameText?.length && !isNotUsePostTextIcon" v-html="postNameText"></span>
      <svg style="padding-top: 1px" width="18" height="18" v-if="isUsePostTextIcon && postTextIcon && !isNotUsePostTextIcon">
        <use :xlink:href="'#' + postTextIcon"></use>
      </svg>
      <span v-if="postText?.length" v-html="postText"></span>
    </div>

    <div class="select-toggler__triangle"></div>
  </div>
</template>

<script>
import ColorPreview from "./ColorPreview";

export default {
  name: "SelectToggler",
  components: {ColorPreview},
  props: {
    isUsePostTextIcon: {
      type: Boolean,
      default: false
    },
    postNameText: {
      type: String,
      default: ''
    },
    toggleStyle: {
      type: Object,
      default: () => {}
    },
    prevText: {
      type: String,
      default: ''
    },
    postText: {
      type: String,
      default: ''
    },
    postTextIcon: {
      type: String,
      default: ''
    },
    isNotUsePostTextIcon: {
      type: Boolean,
      default: false
    },
    isError: {
      type: Boolean,
      default: false
    },
    isImg: {
      type: Boolean,
      default: false
    },
    label: String,
    stylesPreview: {
      type: Object,
      default: () => {}
    },
    previewColor: String,
    previewImg: String
  }
}
</script>

<style lang="scss" scoped>
.error {
  border: 1px solid #eb444c !important;
  transition: 0.2s;
}

.select-toggler {
  transition: 0.2s;
  background: #FFFFFF;
  border: 1px solid #CCCCCC;
  box-sizing: border-box;
  box-shadow: inset 0 2px 4px rgba(30, 30, 30, 0.15);
  border-radius: 4px;
  width: 100%;
  height: 40px;
  padding: 0 10px;
  font-size: 15px;
  line-height: 120%;
  display: flex;
  align-items: center;

  &__img {
    margin-right: 8px;
  }

  &__label {
    white-space: nowrap;
    text-overflow: ellipsis;
    flex: 1 1 1px;
    overflow: hidden;
    min-width: 0;
  }

  &__triangle {
    flex: 0 0 auto;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 6px 6px 0 6px;
    border-color: #007deb transparent transparent transparent;
    margin: 0 0 0 10px;
  }

  &__preview {
    margin: 0 8px 0 0;
  }
}

@media all and (min-width: 1024px) {
  .select-toggler {
    height: 32px;
    cursor: pointer;
  }
}
</style>
