<template>
  <ModalContent size="lg">
    <div class="color__description">
      Вы можете выбрать суммарно до 5-ти цветов <br>
      и слоев лака для печати вашей этикетки
    </div>
    <div class="material-info">
      <div class="material-info__list" v-if="colors.length">
        <div class="material-info__list-holder">
          <ul class="material-list">
            <li class="color__item"
                :class="{'color__item__opened': color.id === openedColor.id}"
                v-for="color in colors" :key="color.id">
              <div
                @click="onOpenColor(color)"
                class="color__item__container"
                :class="{
                  selected: color === selectedColor,
                  disabled: color.disabled
              }">
                <span class="color__item__text" v-html="color.name"></span>
                <div class="color__min-preview" :class="{
                  'color__min-preview__no-preview': !color?.activePaint.image?.url
                }" :style="{backgroundImage: `url(${color?.activePaint.image?.url})`}"></div>
                <div class="color__remove" @click="onRemoveColor(color)">
                  <svg v-if="color.id > 1" width="12" height="12">
                    <use xlink:href="#red-remove-icon"></use>
                  </svg>
                </div>
              </div>
            </li>
            <li class="color__item">
              <div v-if="colors.length < 5" @click="onAddColor()" class="color__item__container">
                <span class="color__item__text-link">
                  <svg class="color__add-color" width="23" height="23">
                    <use xlink:href="#blue-plus-icon"></use>
                  </svg> цвет</span>
              </div>
            </li>
          </ul>

        </div>
      </div>
      <div class="material-info__content">
        <div v-if="selectedColorItem" class="material-info__color">Цвет: {{ selectedColorItem.name }}</div>
        <div class="material-info__colors-holder">
          <ColorList v-if="paints.length"
                     :colors="paints"
                     :selected-color="selectedColorItem" :material="selectedColor" :on-select="onSelectColor"
                     :on-open="onOpenColor"/>
        </div>
      </div>
    </div>
  </ModalContent>
  <ModalFooter size="lg" :styles="{justifyContent: 'center'}">
    <div class="material-footer">
      <div class="material-footer__btn">
        <CalcButton class="material-footer__submit" @click="onSubmit(selectedColor, selectedColorItem)">Выбрать</CalcButton>
      </div>
    </div>
  </ModalFooter>
</template>

<script>
import ModalContent from "@/components/modals/ModalContent";
import ModalFooter from "@/components/modals/ModalFooter";
import ColorList from "@/components/fields/ColorList";
import CalcButton from "@/components/CalcButton";

export default {
  name: "ColorfulSelector",
  components: {CalcButton, ColorList, ModalFooter, ModalContent},
  props: {
    onSubmit: Function,
    onOpenColor: Function,
    openedColor: Object,
    onSelectColor: Function,
    onAddColor: Function,
    onRemoveColor: Function,
    selectedColor: {
      type: Object,
      default: () => {}
    },
    paints: {
      type: Array,
      default: () => []
    },
    selectedColorItem: {
      type: Object,
      default: () => {}
    },
    colors: {
      type: Array,
      default: () => []
    }
  }
}
</script>

<style lang="scss" scoped>
.opened {
  background: #0b4e58;
}

.material-footer {
  display: flex;
  flex-flow: row wrap;
  align-items: center;

  &__btn {
    flex: 1 1 100%;
    display: flex;
    justify-content: center;
  }

  &__submit {
    width: 136px;
  }
}

.material-list {
  list-style: none;
  margin: 0;
  padding: 0;

  &__material {
    position: relative;
    font-size: 14px;
    line-height: 130%;
    padding: 1px;
    display: flex;
    align-items: center;

    &.disabled {
      cursor: default;
      opacity: 0.4;
    }


    &:before {
      content: '';
      width: 25px;
      height: 25px;
      border: 4px solid #fff;
      box-shadow: 0 0 0 1px #AABEC8;
      box-sizing: border-box;
      border-radius: 50%;
      flex: 0 0 auto;
      margin: 0 5px 0 0;
    }

    &.selected {
      &:before {
        background: #007DEB;
        box-shadow: 0 0 0 1px #007DEB;
      }
    }
  }


  &__item {
    + .material-list__item {
      margin: 14px 0 0 0;
    }
  }
}

.color {

  &__min-preview {
    border-radius: 50%;
    width: 12px;
    height: 12px;
    margin-left: 4px;
    margin-right: 4px;
    display: inline-block;
    background-size: cover;

    &__no-preview {
      border: 1px solid #999;
    }
  }

  &__remove {
    cursor: pointer;
    padding: 4px;
    display: inline;
  }

  &__add-color {
    cursor: pointer;
    margin-right: 6px;
  }

  &__description {
    font-size: 14px;
    margin-bottom: 20px;
  }

  &__item {
    cursor: pointer;
    height: 42px;
    line-height: 42px;
    border-right: 1px solid #C4C4C4;

    &__container {
      padding-left: 12px;
    }

    &__opened {
      border-top: 1px solid #C4C4C4;
      border-left: 1px solid #C4C4C4;
      border-bottom: 1px solid #C4C4C4;
      border-right: none;
      color: #007DEB;
    }

    &__text {
      font-weight: 600;
      font-size: 16px;
      color: #00195A;
    }

    &__text-link {
      color: #007DEB;
      font-size: 16px;
      font-weight: 600;
      display: flex;
      align-items: center;
    }
  }
}

.material-info {
  &__color {
    margin: 0 0 10px 0;
    flex: 0 0 auto;
    font-family: Euclid Circular B, Arial, sans-serif;
    color: #00195A;
    font-weight: 600;
    font-size: 16px;
    line-height: 120%;
  }
  &__list {
    margin: 20px 0 27px;
  }
}

@media all and (min-width: 768px) {
  .material-info {
    display: flex;
    max-height: 420px;


    &__list {
      //flex: 0 0 224px;
      margin: 0 32px 0 0;
      display: flex;
      flex-flow: column;
    }

    &__content {
      display: flex;
      flex-flow: column;
    }

    &__list-holder {
      flex: 1 1 100%;
      min-height: 0;
      overflow: auto;
      padding: 0 8px 0 0;

      &::-webkit-scrollbar {
        width: 6px;
      }

      &::-webkit-scrollbar-thumb {
        border-radius: 3px;
        background-color: #007DEB;
      }

      &::-webkit-scrollbar-track {
        border-radius: 3px;
        background-color: #D6DEE3;
      }
    }

    &__colors-holder {
      max-width: 350px;
      flex: 1 1 100%;
      min-height: 0;
      overflow: auto;
      overflow-x: hidden;
      padding: 0 8px 0 0;

      &::-webkit-scrollbar {
        width: 6px;
      }

      &::-webkit-scrollbar-thumb {
        border-radius: 3px;
        background-color: #007DEB;
      }

      &::-webkit-scrollbar-track {
        border-radius: 3px;
        background-color: #D6DEE3;
      }
    }
  }

  .material-list {
    width: 120px;

    &__item {
    }

    &__material {
      cursor: pointer;
    }
  }
  .material-footer {
    width: 100%;

    &__btn {
      flex: 0 0 auto;
      margin: 0 0 0 auto;
    }
  }
}
</style>
