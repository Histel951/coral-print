<template>
  <ModalContent size="lg">
    <div class="material-info">
      <div class="material-info__list" v-if="materials.length > 1">
        <div class="material-info__list-holder">
          <ul class="material-list">
            <li class="material-list__item" v-for="material in materials" :key="material.id">
              <div
                class="material-list__material"
                @click="onOpenMaterial(material)"
                :class="{
                  opened: material === openedMaterial,
                  selected: material === selectedMaterial,
                  disabled: material.disabled
              }">
                <span v-html="material.name"></span>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="material-info__content">
        <div v-if="selectedColor" class="material-info__color">Цвет: {{ selectedColor.name }}</div>
        <div class="material-info__colors-holder">
          <ColorList v-if="openedMaterial && openedMaterial.items.length"
                     :colors="allColors"
                     :selected-color="selectedColor" :material="selectedMaterial" :on-select="onSelectMaterial"
                     :on-open="onOpenMaterial"/>
        </div>
      </div>
    </div>
  </ModalContent>
  <ModalFooter size="lg" :styles="{justifyContent: 'center'}">
    <div class="material-footer">
      <div class="material-footer__btn">
        <CalcButton class="material-footer__submit" @click="onSubmit(selectedMaterial, selectedColor)">Выбрать</CalcButton>
      </div>
    </div>
  </ModalFooter>
</template>

<script>
import ModalContent from "../modals/ModalContent";
import ColorList from "./ColorList";
import ModalFooter from "../modals/ModalFooter";
import CalcButton from "../CalcButton";

export default {
  name: "RadioMaterialSelector",
  props: {
    allColors: Array,
    materials: Array,
    onSubmit: Function,
    onOpenMaterial: Function,
    openedMaterial: Object,
    onSelectMaterial: Function,
    selectedColor: Object,
    selectedMaterial: Object,
    materialField: String
  },
  components: {CalcButton, ModalFooter, ColorList, ModalContent}
}
</script>


<style lang="scss" scoped>
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

    &.opened {
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
      flex: 0 0 224px;
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
