<template>
  <div class="calc-arrow" :class="{'animated': animated}">
    <svg class="calc-arrow__bg" width="112" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0 21c14.42 0 21.77-1.47 32.9-10.64l5.11-4.2C42.98 2.03 49.49 0 56 0c6.51 0 13.02 2.03 17.99 6.16l5.11 4.2C90.23 19.53 97.58 21 112 21H0Z" fill="#F1F2F0"/>
    </svg>
    <CalcIcon class="calc-arrow__ico"/>
  </div>
</template>
<script>

import CalcIcon from "./icons/CalcIcon";
import useTypes from "../composables/useTypes";
import {watch, ref} from "vue";

export default {
  name: "CalcArrow",
  props: {},
  components: {
    CalcIcon
  },
  setup() {
    const {activeType} = useTypes();
    const animated = ref(false);

    watch(activeType, () => {
      animated.value = true
      setTimeout(() => {
        animated.value = false
      }, 150)
    });

    return {
      animated
    }
  }
}
</script>

<style lang="scss" scoped>
.calc-arrow {
  width: 112px;
  height: 21px;
  position: absolute;
  left: 50%;
  bottom: 100%;
  margin-left: -56px;
  transform: scale(1);
  transition: transform 0.15s ease;
  transform-origin: 50% 100% ;

  &__ico {
    position: absolute;
    left: 50%;
    top: 15px;
    transform: translateX(-50%);
  }

  &.animated {
    transform: scale(0.3);
  }
}
</style>