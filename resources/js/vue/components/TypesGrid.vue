<template>
  <div class="types-grid">
    <div class="types-grid__item" :key="type.value + type.id" v-for="type in types">
      <Type :data="type" :set-active-type="setActiveType" :active="type === activeType"/>
    </div>
  </div>
</template>
<script>
import Type from "./Type";
import useTypes from "../composables/useTypes";


export default {
  components: {Type},
  setup() {
    const {types, setActiveType, activeType} = useTypes();
    return {
      types,
      setActiveType,
      activeType
    }
  }
};
</script>

<style lang="scss" scoped>
.types-grid {
  display: flex;
  flex-flow: row wrap;
  margin: -2px 0;


  &__item {
    flex: 0 0 14.285%;
    min-width: 0;
    margin: 2px 0;
  }
}

@media all and (min-width: 1280px) {
  .types-grid {
    margin: -2px -8px;
  }
}

@media all and (min-width: 1400px) {
  .types-grid {
    margin: 0 -12px;
  }
}


</style>
