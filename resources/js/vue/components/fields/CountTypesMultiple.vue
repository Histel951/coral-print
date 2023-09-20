<template>
  <div class="count-types">
    <div class="count-types__counts-container">
      <div class="count-types__counts-types-text unselectable">
        Виды
      </div>
      <div
        class="count-types__counts-expression count-types__counts-expression-right-none"
        :class="{'disabled-expression': isBlockMinus}"
        @click="decrementTypesCount()">
        <svg width="16" height="16">
          <use xlink:href="#minus"></use>
        </svg>
      </div>
      <div class="count-types__counts-counter-container">
        <div class="count-types__counts-counter unselectable" type="text">{{ types.length }}</div>
      </div>
      <div class="count-types__counts-expression count-types__counts-expression-left-none"
           @click="incrementTypesCount()">
        <svg width="16" height="16">
          <use xlink:href="#plus"></use>
        </svg>
      </div>
      <div class="count-types__counts-types-text unselectable">
        шт
      </div>
    </div>
    <div class="count-types__description">
      <div class="count-types__all-counts unselectable">
        {{ quantityTypes }} по {{ types[0] ?? 0 }} шт
      </div>
      <div class="count-types__total-circulation unselectable">
        Общий тираж: {{ (types.length * types[0]) ?? 0 }} шт
      </div>
    </div>
  </div>
</template>

<script>
import useTypesDeclinations from "@/composables/useTypesDeclinations";
import {ref, watch} from "vue";

export default {
  name: "CountTypesMultiple",
  props: {
    types: {
      type: Array,
      default: () => [],
    },
    isBlockMinus: {
      type: Boolean,
      default: false
    },
    decrementTypesCount: Function,
    incrementTypesCount: Function
  },

  setup(props) {
    const {declination} = useTypesDeclinations();

    const quantityTypes = ref(declination(props.types.length, true));

    watch(
      () => props.types.length,
      (newCount) => {
        quantityTypes.value = declination(newCount, true);
      }
    );

    return {
      quantityTypes,
    };
  },
}
</script>

<style lang="scss" scoped>
.disabled-expression {
  opacity: 0.4;
}

.unselectable {
  user-select: none;
  -moz-user-select: none;
  -khtml-user-select: none;
  -webkit-user-select: none;
  -o-user-select: none;
}

.count-types {
  &__description {
    margin-top: 26px;
    font-weight: 600;
    text-align: center;
  }

  &__counts {
    &-types {
      &-text {
        margin: 8px;
        font-size: 14px;
      }
    }

    &-counter-container {
      display: flex;
      width: 72px;
      height: 48px;
      flex-wrap: wrap;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      align-content: center;
      box-shadow: inset 0 2px 4px rgba(30, 30, 30, 0.15);
      border-bottom: 1px solid rgba(30, 30, 30, .15);
    }

    &-counter {
      text-align: center;
      font-size: 18px;
    }

    &-container {
      display: flex;
      flex-direction: row;
      flex-wrap: nowrap;
      justify-content: center;
      align-items: center;
    }

    &-expression {
      width: 48px;
      height: 48px;
      display: flex;
      flex-wrap: nowrap;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      border: 1px solid rgba(30, 30, 30, 0.15);

      &-right-none {
        border-right: none;
        border-radius: 4px 0 0 4px;
      }

      &-left-none {
        border-left: none;
        border-radius: 0 4px 4px 0;
      }
    }

    &-expression:hover {
      background: #f7f7f7;
    }

    &-counter {
      width: 72px;
    }
  }
}

@media all and (min-width: 768px) {
  .count-types {
    &__counts {
      &-counter-container {
        display: flex;
        width: 50px;
        height: 40px;
        flex-wrap: wrap;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        align-content: center;
        box-shadow: inset 0 2px 4px rgba(30, 30, 30, 0.15);
        border-bottom: 1px solid rgba(30, 30, 30, .15);
        border-radius: 4px;
        margin-right: 8px;
        margin-left: 8px;
      }

      &-expression {
        width: 32px;
        height: 40px;
        display: flex;
        flex-wrap: nowrap;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        border: none;
      }
    }
  }
}
</style>
