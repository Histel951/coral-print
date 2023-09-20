<template>
  <div v-if="options" class="calc-select" :class="{opened: isOpened, 'calc-select_read-only': isReadOnly}">
    <SelectTogglerManyColors
      :is-overlay-colors="!isSelectedCustomColors"
      :label="String(isSelectedCustomColors ? customColor?.name : activeOption?.name ?? '')"
      :previews="isSelectedCustomColors ? customColor?.items : activeOption?.items"
      @click="toggleOpen"
      :class="{'disabled': readOnly}"
    />
    <div v-if="isOpened" class="calc-select__dropdown" :style="{zIndex: 50}">
      <ul class="calc-select__options">
        <li v-if="customColor.name"
            class="calc-select__options__item"
            :class="{active: isSelectedCustomColors}"
            :key="customColor.name" @click="onSelectCustomColors(customColor)"
        >
          <span v-html="customColor.name"></span>
          <ManyColorPreviews
            :z-index-start="100"
            :is-overlay-colors="!isSelectedCustomColors"
            class="calc-select__options__colors"
            :previews="customColor.items"
          />
          <CheckIcon :styles="{float: 'right'}" v-if="isSelectedCustomColors" class="calc-select__checked"/>
        </li>
        <li v-for="option in options" :key="option.id"
            :class="{
              active: option === activeOption && !isSelectedCustomColors,
              'calc-select__options__item': !option?.disabled,
              'calc-select__options__item-disabled': option?.disabled
            }"
            @click="setValue(option)">
          <span>{{ option.name }}</span>
          <ManyColorPreviews :z-index-start="40" class="calc-select__options__colors" :previews="option.items" />
          <CheckIcon v-if="option === activeOption && !isSelectedCustomColors" :styles="{float: 'right'}" class="calc-select__checked"/>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import ManyColorPreviews from "@/components/fields/ManyColorPreviews";
import SelectTogglerManyColors from "@/components/fields/SelectTogglerManyColors";
import CheckIcon from "@/components/icons/CheckIcon";

export default {
  name: "ColorSelector",
  components: {
    CheckIcon,
    SelectTogglerManyColors,
    ManyColorPreviews
  },
  props: {
    readOnly: {
      type: Boolean,
      default: false
    },
    fieldName: {
      type: String,
      default: ''
    },
    options: Array,
    customColor: {
      types: Object,
      default: () => {}
    },
    onSelectCustomColors: Function,
    isSelectedCustomColors: {
      type: Boolean,
      default: false
    },
    isReadOnly: {
      type: Boolean,
      default: false
    },
    toggleOpen: Function,
    activeOption: {
      type: Object,
      default: () => {}
    },
    isOpened: {
      type: Boolean,
      default: false
    },
    setValue: Function
  }
}
</script>

<style lang="scss" scoped>

.disabled {
  cursor: default;
  opacity: 0.4;
}

.calc-select {
  width: 100%;
  position: relative;

  &_read-only {
    opacity: 0.5;
  }

  &.opened {
    z-index: 99;
  }

  &__dropdown {
    width: 122%;
    margin-left: -22%;
    box-sizing: border-box;
    position: absolute;
    left: 0;
    top: 0;
  }

  &__options {
    margin: 0;
    padding: 0;
    background: #FFFFFF;
    box-shadow: 0 2px 15px rgba(45, 45, 45, 0.2);
    border-radius: 4px;
    font-size: 15px;
    line-height: 20px;
    color: #1E1E1E;
    list-style: none;
    overflow: auto;
    overflow-x: hidden;

    &__max-height {
      max-height: 192px;
    }

    &::-webkit-scrollbar {
      width: 6px;
      background-color: #D6DEE3;
      border-radius: 0 4px 4px 0;
      display: block;
    }

    &::-webkit-scrollbar-thumb {
      background-color: #007DEB;
      border-radius: 4px;
      display: block;
    }

    &__colors {
      margin-left: 3px;
    }

    &__item {
      display: flex;
      align-items: center;
      position: relative;
      padding: 10px 36px 10px 10px;
      cursor: pointer;

      &:hover {
        background: #E5EBEF;
      }

      &.active {
        background: #F1F2F0;
        //display: flex;
        //justify-content: space-between;
        padding-right: 10px;
      }
    }

    &__item-disabled {
      position: relative;
      padding: 10px 36px 10px 10px;
      cursor: default;
      background: #f9f9f9;
      color: #9c9c9c;
    }
  }

  &__checked {
    fill: #007DEB;;
    position: absolute;
    width: 90%;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
  }
}

@media all and (min-width: 1024px) {
  .calc-select {
    &__dropdown {
      top: 100%;
      padding: 0;
    }

    &__options {
      li {
        padding-top: 6px;
        padding-bottom: 6px;
      }
    }
  }
}

</style>
