<template>
  <div class="ui__close-btn" @click="onClick">
    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M17 1.00004L1 17M17 17L1 1" stroke="#D6DEE3" stroke-width="2"/>
    </svg>
  </div>
</template>

<script>
export default {
  name: "CloseBtn",
  props: {
    onClick: Function
  }
}
</script>

<style lang="scss" scoped>

.ui {
  &__close-btn {
    cursor: pointer;
  }

  &__close-btn:hover {

  }
}

</style>
