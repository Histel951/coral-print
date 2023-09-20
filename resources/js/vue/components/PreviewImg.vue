<template>
  <div class="container">
    <svg :style="{height: preview.height + 'px'}">
      <use :xlink:href="'#' + preview.svg_id"></use>
    </svg>
  </div>
</template>

<script>

export default {
  name: "PreviewImg",
  props: {
    preview: {
      type: Object,
      default: () => {}
    }
  }
}
</script>

<style lang="scss" scoped>

.container {
  display: flex;
  width: auto;
  flex-direction: column;
  padding: 10px;
  align-items: center;
  justify-content: center;
}

.img {
  display: flex;
  justify-content: center;
  transition: 0.2s;
  background-repeat: no-repeat;
  background-size: contain;
  padding: 0;
  background-position: center;
  margin: 0 auto calc(100% - 98%);
}

@media all and (min-width: 768px) {

}
</style>
