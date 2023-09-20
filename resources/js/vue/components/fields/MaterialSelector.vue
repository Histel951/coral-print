<template>
  <ModalContent size="lg">
    <div class="material-info">
      <div class="material-info__list">
        <div class="material-info__list-holder">
          <ul class="categories-list">
            <li v-for="category in materials" :key="category.id">
              <div class="categories-list__category">{{ category.category }}</div>
              <ul class="material-list">
                <li class="material-list__item" v-for="material in category.items" :key="material.id">
                  <div class="material-list__material" :ref="el => materialsRefs[material.id] = el"  @click="openMaterial(material)"
                       :class="{opened: material === openedMaterial, selected: material === activeMaterial,
                      colors: material.types.length, disabled: material.disabled, hover: !material.disabled}">
                    <span v-html="material.name"></span>
                    <ColorPreview class="material-list__preview" v-if="material === activeMaterial && windowWidth < 768"
                                  :preview-color="activeColor.color" :preview-img="activeColor.image_url"/>
                  </div>
                  <ColorList v-if="material === openedMaterial && windowWidth < 768 && openedMaterial.types.length"
                             :material="material" :on-select="selectMaterial" :on-open="openMaterial"
                             :selected-color="selectedColor" class="material-list__colors"/>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div class="material-info__content">
        <div v-if="windowWidth > 767 && openedMaterial.desc" class="material-info__desc">
          {{ openedMaterial.desc }}
        </div>
        <div v-if="windowWidth > 767" class="material-info__color">
          <span v-if="selectedMaterial.types.length > 1">Цвет: </span>{{ selectedColor.name }}
        </div>
        <div class="material-info__colors-holder">
          <ColorList v-if="openedMaterial && windowWidth > 767"
                     :selected-color="selectedColor" :material="openedMaterial" :on-select="selectMaterial"
                     :on-open="openMaterial"/>
        </div>
      </div>
    </div>
  </ModalContent>
  <ModalFooter size="lg">
    <div class="material-footer">
      <div class="material-footer__info">
        <span v-html="`${selectedMaterial.name}  ${selectedMaterial.type_name}`"/> <span v-if="selectedMaterial.types.length > 1"></span><span v-html="selectedColor.name"/>
      </div>
      <div class="material-footer__btn">
        <CalcButton class="material-footer__submit" @click="onSubmit(selectedMaterial, selectedColor)">Выбрать</CalcButton>
      </div>
    </div>
  </ModalFooter>
</template>

<script>
import {onMounted, ref} from "vue";
import ModalContent from "../modals/ModalContent";
import useWindow from "../../composables/useWindow";
import ColorList from "./ColorList";
import ColorPreview from "./ColorPreview";
import ModalFooter from "../modals/ModalFooter";
import CalcButton from "../CalcButton";

export default {
  name: "MaterialSelector",
  props: {
    materials: Array,
    activeMaterial: Object,
    activeColor: Object,
    onSubmit: Function,
    submitMaterial: Object,
    isOpened: Boolean
  },
  components: {CalcButton, ModalFooter, ColorPreview, ColorList, ModalContent},
  setup(props) {
    const selectedMaterial = ref(props.activeMaterial);
    const selectedColor = ref(props.activeColor);
    const openedMaterial = ref(props.activeMaterial);
    const {windowWidth} = useWindow();
    const materialsRefs = ref({});

    onMounted(() => {
          if (materialsRefs.value[props.submitMaterial.id]) {
            materialsRefs.value[props.submitMaterial.id].scrollIntoView({
              behavior: 'smooth',
              block: 'center'
            });
          }
    });

    const selectMaterial = (material, color) => {
      selectedMaterial.value = material;
      selectedColor.value = color;
    }

    const openMaterial = (material) => {
      if (!material.disabled) {
        openedMaterial.value = material;
        selectMaterial(material, material.types[0])
      }
    }

    return {
      selectedMaterial,
      selectedColor,
      openedMaterial,
      windowWidth,
      openMaterial,
      selectMaterial,
      materialsRefs
    }
  }
}
</script>


<style lang="scss" scoped>
.material-footer {
  display: flex;
  flex-flow: row wrap;
  align-items: center;

  &__info {
    flex: 0 0 100%;
    font-size: 15px;
    line-height: 130%;
    text-align: center;
    color: #8E8E8E;
    margin: 0 0 12px 0;
  }

  &__price {
    flex: 1 1 50%;
    text-align: center;
    font-family: Euclid Circular B, Arial, sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 22px;
    line-height: 26px;
    color: #00195A;
  }

  &__btn {
    flex: 1 1 100%;
    display: flex;
    justify-content: center;
  }

  &__submit {
    width: 136px;
  }
}

.categories-list {
  list-style: none;
  margin: 0;
  padding: 0;

  &__category {
    border-bottom: 1px solid #E4E4E4;
    padding: 8px 0;
    font-family: Euclid Circular B, Arial, sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 120%;
    display: flex;
    align-items: center;
    color: #00195A;
  }
}

.material-list {
  list-style: none;
  margin: 0;
  padding: 0 0 0 24px;

  &__colors {
    margin: 0 0 8px 0;
  }

  &__material {
    padding: 8px 50px 8px 0;
    position: relative;
    font-size: 15px;
    line-height: 130%;

    &.opened {
      color: #007DEB
    }

    &.disabled {
      cursor: default;
      color: #9b9b9b;
    }

    &.colors {
      &:before {
        width: 7px;
        height: 11px;
        display: block;
        content: '';
        position: absolute;
        top: 50%;
        margin: -5px 0 0 0;
        left: -15px;
        background-image: url("data:image/svg+xml,%3Csvg width='7' height='11' viewBox='0 0 7 11' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M-5.12243e-08 9.07812L3.82812 5.25L-3.8589e-07 1.42188L1.17187 0.25L6.17187 5.25L1.17188 10.25L-5.12243e-08 9.07812Z' fill='%230073D2'/%3E%3C/svg%3E%0A");
      }

      &.opened {
        &:before {
          transform: rotate(90deg);
        }
      }
    }



    &.selected {
      &:after {
        content: '';
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        display: block;
        width: 12px;
        height: 10px;
        background-position: center;
        background-repeat: no-repeat;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='10' viewBox='0 0 12 10' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4.2439 9.36585L0 5.12195L1.53659 3.58537L4.2439 6.21951L10.4634 0L12 1.53659L4.2439 9.36585Z' fill='%23007DEB'/%3E%3C/svg%3E%0A");
      }
    }
  }

  &__preview {
    position: absolute;
    right: 28px;
    top: 50%;
    transform: translateY(-50%);
  }

  &__item {
    border-top: 1px solid #E4E4E4;

    &:first-child {
      border: none;
    }
  }
}

@media all and (min-width: 768px) {
  .material-info {
    display: flex;
    max-height: 350px;

    &__desc {
      font-size: 14px;
      line-height: 120%;
      flex: 0 0 auto;
      margin: 0 0 20px 0;
    }

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

    &__color {
      margin: 0 0 10px 0;
      flex: 0 0 auto;
      font-family: Euclid Circular B, Arial, sans-serif;
      color: #00195A;
      font-weight: 600;
      font-size: 16px;
      line-height: 120%;
    }
  }
  .material-list {
    padding: 8px 0 0 0;

    &__item {
      border: none;
    }

    &__material {
      padding: 6px 28px 6px 6px;
      cursor: pointer;

      &.hover:hover {
        background: #E5EBEF;
      }

      &.colors {
        &:before {
          display: none;
        }
      }
    }
  }
  .material-footer {
    width: 100%;

    &__info {
      flex: 1 1 1px;
      min-width: 0;
      text-align: left;
      margin: 0 30px 0 0;
    }

    &__price {
      flex: 0 0 auto;
      margin: 0 16px 0 25px;
    }

    &__btn {
      flex: 0 0 auto;
    }
  }
}
</style>
