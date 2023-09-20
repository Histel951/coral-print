<template>
  <FieldModal
    :opened="true"
    :on-close="onClose"
    title="Количество видов"
    :header-text-styles="{
      fontSize: '20px',
      fontWeight: '600',
    }"
    :header-styles="{
      padding: `16px 8px ${isMultiple ? '0px' : '8px'} 16px`
    }">
    <ModalContent :styles="{padding: '6px 16px'}">
      <CountTypesMultiple
        v-if="isMultiple"
        :types="newTypes"
        :decrement-types-count="decrementTypesCount"
        :increment-types-count="incrementTypesCount"
        :is-block-minus="isBlockDeleteTypes"
      />
      <div class="count-types" v-if="!isMultiple">
        <div class="count-types__items">
          <div class="type-item" v-for="(val, index) in newTypes" :key="'item' + index">
            <div class="type-item__label">Вид {{ index + 1 }}</div>
            <input class="input-field" v-model.number="newTypes[index]" @keypress="checkVal">
            <div class="type-item__post">шт</div>
            <div class="type-item__del" v-if="index > 0" @click="delType(index)">
              <CloseIcon v-if="windowWidth >= 768"/>
              <span v-else class="type-item__del-text">удалить</span>
            </div>
          </div>
        </div>
        <div class="count-types__add" v-if="newTypes.length < 7">
          <div @click="addType">
            <PlusIcon class="count-types__add-icon"/>
            Добавить вид
          </div>
        </div>
        <div class="type-item no-add-type-item" v-else>
            Если больше 7 видов, <a class="type-item__link" href="#">добавьте</a> в дизайне персонализацию
        </div>
        <div class="count-types__total">
          Общий тираж: {{ total }} шт
        </div>
      </div>
    </ModalContent>
    <ModalFooter align="center">
      <CalcButton class="submit-btn unselectable" @click="save">Готово</CalcButton>
    </ModalFooter>
  </FieldModal>
</template>

<script>
import FieldModal from "../modals/FieldModal";
import {computed, ref, watchEffect} from "vue";
import ModalContent from "../modals/ModalContent";
import CloseIcon from "../icons/CloseIcon";
import PlusIcon from "../icons/PlusIcon"
import ModalFooter from "../modals/ModalFooter";
import CalcButton from "../CalcButton";
import useForm from "@/composables/useForm";
import CountTypesMultiple from "@/components/fields/CountTypesMultiple.vue";
import useWindow from "@/composables/useWindow";

export default {
  name: "CountTypes",
  components: {CountTypesMultiple, CalcButton, ModalFooter, PlusIcon, CloseIcon, ModalContent, FieldModal},
  props: {
    types: Array,
    onSave: Function,
    onClose: Function,
    isMultiple: {
      type: Boolean,
      default: false
    }
  },
  setup(props) {
    const {form} = useForm();
    const isBlockDeleteTypes = ref(false);
    const newTypes = ref([...props.types]);
    const {windowWidth} = useWindow();

    const incrementTypesCount = () => {
      newTypes.value.push(form.product_count);
    }

    const decrementTypesCount = () => {
      if (!isBlockDeleteTypes.value) {
        delType(newTypes.value.length - 1);
      }
    }

    watchEffect(() => {
      isBlockDeleteTypes.value = newTypes.value.length <= 1;
    });

    const addType = () => {
      newTypes.value.push(100);
    }

    const delType = (index) => {
      delete newTypes.value.splice(index, 1)
    }

    const total = computed(() => newTypes.value.reduce((a, b) => (a ? a : 0) + (b ? b : 0), 0));

    const save = () => {
      props.onSave(newTypes.value.filter((item) => item));
      props.onClose();
    }

    const checkVal = (event) => {
      if (isNaN(Number(event.key)) || event.key === ' ') {
        event.preventDefault();
      }
    }

    return {
      checkVal,
      newTypes,
      addType,
      delType,
      save,
      total,
      incrementTypesCount,
      decrementTypesCount,
      isBlockDeleteTypes,
      windowWidth
    }
  }
}
</script>


<style lang="scss" scoped>
.unselectable {
  user-select: none;
  -moz-user-select: none;
  -khtml-user-select: none;
  -webkit-user-select: none;
  -o-user-select: none;
}

.no-add-type-item {
  border-top: 1px solid #E4E4E4;
  font-size: 14px;
  color: #404040;
}

.type-item {
  display: flex;
  align-items: center;
  padding: 7px 0;

  &__link {
    color: #69A3BE;
    display: contents;
  }

  + .type-item {
    border-top: 1px solid #E4E4E4;
  }

  &:first-child {
    padding-top: 0;
  }

  &__label {
    width: 48px;
    margin: 0 8px 0 0;
    flex: 0 0 auto;
    font-size: 14px;
    line-height: 130%;
  }

  &__post {
    margin: 0 0 0 8px;
    font-size: 14px;
    line-height: 130%;
  }

  &__del {
    margin: 0 0 0 auto;

    &-text {
      color: #EB444C;
      font-size: 14px;
      cursor: pointer;
    }
  }
}

.input-field {
  background: #FFFFFF;
  border: 1px solid #CCCCCC;
  box-sizing: border-box;
  box-shadow: inset 0 2px 4px rgba(30, 30, 30, 0.15);
  border-radius: 4px;
  width: 90px;
  height: 40px;
  padding: 0 10px;
  font-size: 15px;
  line-height: 120%;
  outline: none;
}
.count-types {
  &__add {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 15px;
    line-height: 130%;
    color: #007DEB;
    margin: 20px 0 0 0;

    div {
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
    }
  }

  &__add-icon {
    margin: 0 5px 0 0;
  }

  &__total {
    font-weight: 600;
    font-size: 16px;
    line-height: 120%;
    color: #1E1E1E;
    text-align: center;
    margin: 28px 0 0 0;
  }
}

.submit-btn {
  width: 124px;
}

@media all and (min-width: 1024px) {
  .input-field {
    width: 96px;
    height: 32px;
  }
}

</style>

<style lang="scss">
@media all and (min-width: 1024px) {
  .type-item {
    &__del {
      cursor: pointer;

      &:hover {
        path {
          stroke: #EB444C;
        }
      }
    }
  }
}
</style>
