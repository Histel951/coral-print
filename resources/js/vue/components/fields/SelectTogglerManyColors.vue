<template>
  <div class="select-toggler">
    <div class="select-toggler__label">
      <div class="select-toggler__text" v-html="label" />
      <ManyColorPreviews :z-index-start="40" :is-overlay-colors="isOverlayColors" :previews="previews" />
    </div>
    <div class="select-toggler__triangle"></div>
  </div>
</template>

<script>
import ManyColorPreviews from "@/components/fields/ManyColorPreviews";

export default {
  name: "SelectTogglerManyColors",
  components: {ManyColorPreviews},
  props: {
    isOverlayColors: {
      type: Boolean,
      default: true
    },
    label: String,
    previews: {
      type: Array,
      default: () => []
    }
  }
}
</script>

<style lang="scss" scoped>

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
  z-index: 1;

  &__label {
    display: flex;
    white-space: nowrap;
    flex: 1 1;
    min-width: 0;
  }

  &__text {
    text-overflow: ellipsis;
    overflow: hidden;
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
