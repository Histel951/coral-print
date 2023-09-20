<template>
  <ul class="color-list">
    <li class="color-list__item" v-for="color in material?.types ?? colorsList" :key="color.id">
      <div v-if="color.id" class="color-block" :style="getBlockStyles(color)" @click="onSelect(material, color)" :class="{selected: color.id === selectedColor?.id}">
        <div class="color-block__content" :style="getColorStyles(color)"/>
      </div>
    </li>
  </ul>
</template>

<script>

import {onBeforeMount, ref} from 'vue';

export default {
  name: "ColorList",
  props: {
    colors: Array,
    material: Object,
    selectedColor: Object,
    onSelect: Function,
    onOpen: Function
  },
  setup(props) {
    const colorsList = ref(props.colors);

    onBeforeMount(() => {
      if (!colorsList.value) {
        return;
      }

      if (colorsList.value.length % 5 !== 0 && colorsList.value.length % 2 === 0) {
        for (let i = 1; i < colorsList.value.length; i++) {
          if (i % 5 === 0) {
            colorsList.value.splice(i - 1, 0, {});
          }
        }
      }
    });

    const getColorStyles = (color) => {
      const style = {};
      if (color.color) {
        style.backgroundColor = color.color;
      }
      if (!color.image?.url && (!color.color || color.color.toLowerCase().indexOf('#fff') > -1)) {
        style.border = '1px solid #8E8E8E';
      }

      if (color.is_image || !color.color) {
        style.backgroundImage = `url(${color.image.url})`;
      }

      if (color.is_image) {
        style.height = '90%';
        style.width = '90%';
      } else {
        style.height = '82%';
        style.width = '82%';
      }

      return style;
    }

    const getBlockStyles = (color) => {
      const style = {};

      if (color.is_image) {
        style.width = '112px';
        style.height = '112px';
      }

      return style;
    };

    return {
      getColorStyles,
      getBlockStyles,
      colorsList
    }
  }
}
</script>


<style lang="scss" scoped>
.color-list {
  margin: 0 -4px;
  padding: 0;
  list-style: none;
  display: flex;
  flex-flow: row wrap;
  width: 320px;

  &__item {
    width: auto;
    margin: 4px;
  }
}

.color-block {
  width: 56px;
  height: 56px;
  box-sizing: border-box;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #fff;
  border-radius: 4px;

  &.selected {
    border-color: #007DEB;
  }

  &__content {
    background-position: center;
    background-size: cover;
    box-sizing: border-box;
    border-radius: 2px;
    width: 38px;
    height: 38px;
  }
}

@media all and (min-width: 768px) {
  .color-block {
    cursor: pointer;
    &:hover {
      border-color: #AABEC8;
    }
  }
  .color-list {
    min-height: 112px
  }
}
</style>
