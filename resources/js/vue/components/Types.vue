<template>
  <div class="calc-types">
    <div class="calc-types__wrap">
      <TypesGrid v-if="showGrid"/>
      <TypesSlider v-else/>
    </div>
  </div>
</template>
<script>
import TypesGrid from "./TypesGrid";
import TypesSlider from "./TypesSlider";
import {onBeforeMount, ref} from 'vue';


export default {
  components: {TypesGrid, TypesSlider},
  setup() {
    let showGrid = ref((window.innerWidth > 1279 && window.innerHeight > 800));
    onBeforeMount(() => {
      window.addEventListener('resize', () => {
        showGrid.value = (window.innerWidth > 1279 && window.innerHeight > 800);
      })
    })
    return {
      showGrid
    }
  }
};
</script>

<style lang="scss" scoped>
.calc-types {
  margin: 0 0 42px 0;
  &__wrap {
    max-width: 1472px;
    padding: 0 16px;
    margin: 0 auto;
  }
}

@media all and (min-width: 768px) {
  .calc-types {
    &__wrap {
      padding: 0 32px;
    }
  }
}

@media all and (min-width: 1280px) {
  .calc-types {
    &__wrap {
      padding: 0 80px;
    }
  }
}
</style>
