<template>
  <div class="text-block">
    <div class="text-block__title">
      <div class="text-block__icon">
        <slot name="icon"></slot>
      </div>
      <div>
        <slot name="title"></slot>
      </div>
    </div>
    <div class="text-block__content">
      <slot name="content"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "TextBlock"
}
</script>

<style lang="scss" scoped>
.text-block {
  &__title {
    font-family: "Euclid Circular B", Arial, Tahoma, sans-serif;
    font-weight: 600;
    font-size: 20px;
    line-height: 120%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #00195A;
    margin: 0 0 6px 0;
  }

  &__icon {
    margin: 0 6px 0 0;
    display: flex;
  }

  &__content {
    text-align: center;
    font-size: 15px;
    line-height: 130%;
    color: #1E1E1E;
  }

  &_design {
    border-top: 1px solid #E4E4E4;
    margin: 35px 0 0 0;
    padding: 16px 0 0 0;
  }

  &_term {
    margin: 16px 0 0 0;
  }
}


</style>
