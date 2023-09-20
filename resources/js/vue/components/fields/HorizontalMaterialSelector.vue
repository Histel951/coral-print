<template>
  <ModalContent size="lg">
    <div v-for="category in optionsCategory" :key="category.id">
      <div class="material__category-title">
        <span>{{ category?.name }}</span>
      </div>
      <div class="material__category-container">
        <div
          v-for="item in category.items" :key="item.id"
          class="material__category-item"
          :class="{'material__category-item__active': toggleOption.id === item.id}"
          @click="onOpenOption(item, category)"
        >
          <img :src="item?.image?.url" alt="">
        </div>
      </div>
    </div>
  </ModalContent>
  <ModalFooter size="lg">
    <div class="material-footer">
      <div class="material-footer__btn">
        <CalcButton class="material-footer__submit" @click="onSubmit(toggleOption, toggleCategory)">Готово</CalcButton>
      </div>
    </div>
  </ModalFooter>
</template>

<script>
import ModalContent from "@/components/modals/ModalContent";
import ModalFooter from "@/components/modals/ModalFooter";
import CalcButton from "@/components/CalcButton";

export default {
  name: "HorizontalMaterialSelector",
  components: {CalcButton, ModalFooter, ModalContent},
  props: {
    optionsCategory: {
      type: Array,
      default: () => []
    },
    onSubmit: Function,
    onOpenOption: Function,
    toggleCategory: {
      type: Object,
      default: () => {}
    },
    toggleOption: {
      type: Object,
      default: () => {}
    }
  }
}
</script>

<style lang="scss" scoped>

.material-footer {
  display: flex;
  width: 100%;
  justify-content: center;
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

.material {
  &__category-container {
    display: flex;
    margin: 12px 0;
  }

  &__category-item {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    margin-right: 8px;
    cursor: pointer;

    &:hover {
      border: 1px solid #AABEC8;
      border-radius: 4px;
    }

    &__active {
      border: 1px solid #007DEB;
      border-radius: 4px;
    }
  }

  &__category-item:last-child {
    margin-right: 0;
  }
}

</style>
