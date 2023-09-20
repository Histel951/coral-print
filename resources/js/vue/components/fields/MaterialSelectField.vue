<template>
  <div v-if="optionsList" class="calc-select" :class="{opened: opened}">
    <SelectToggler
      :label="!isBlockSelect ? activeOption?.name ?? optionsList[0].items[0] : activeOption[optionActive.id]?.name ?? optionsList[0].items[0].name"
      @click="toggleOpen"
    />
    <div v-if="opened" class="calc-select__dropdown">
      <div class="calc-select__list">
        <div v-for="option in optionsList" :key="option.id">
            <ul :class="{'calc-select__options': true, 'calc-select__options__max-height': true}">
              <div class="calc-select__category-title">
                <span class="calc-select__category-title-text">{{ option.category }}</span>
              </div>
              <li v-for="item in option.items" :key="item.id" :class="{active: item.id === activeOptionId}"
                  @click="setValue(item)">
                <span v-html="item.name"></span>
                <CheckIcon v-if="item.id === activeOptionId" aditional-class="calc-select__checked"/>
              </li>
            </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {onBeforeMount, onBeforeUpdate, ref} from "vue";
import CheckIcon from "@/components/icons/CheckIcon";
import useForm from "@/composables/useForm";
import onClickOutside from "vue-click-outside-hook";
import SelectToggler from "@/components/fields/SelectToggler";
import useBlockSelect from "@/composables/useBlockSelect";
import useInitData from "@/composables/useInitData";

export default {
  name: "MaterialSelectField",
  components: {SelectToggler, CheckIcon},
  props: {
    isBlockSelect: {
      type: Boolean,
      default: false
    },
    fieldName: String,
    options: {
      type: Array,
      default: () => []
    },
    actionOptions: {
      types: Array,
      default: []
    },
  },
  setup(props) {
    const {addFieldValue, form} = useForm();
    const {optionActive} = useBlockSelect();

    const {getData} = useInitData();

    const opened = ref(false);
    const activeOption = ref({});
    const optionsList = ref(getData(props.fieldName));

    const toggleOpen = () => {
      // if (!isReadOnly.value) {
        opened.value = !opened.value
      // }
    }

    onClickOutside(() => {
      opened.value = false;
    })

    const findActiveOption = () => {
      let activeIndex = -1;
      let categoryIndex = -1;

      optionsList.value.forEach((category, index) => {
        if (activeIndex === -1) {
          activeIndex = category.items.findIndex(material => form[props.fieldName] === material.id);
          categoryIndex = index;
        }
      });

      if (optionsList.value) {
        const option = activeIndex > -1 ? optionsList.value[categoryIndex].items[activeIndex] : optionsList.value[0].items[0];

        if (props.isBlockSelect) {
          activeOption.value[optionActive.value.id] = option;
        } else {
          activeOption.value = option;
        }
      }
    }

    onBeforeUpdate(() => {
      optionsList.value = getData(props.fieldName);
      findActiveOption();
    });

    const setOptions = async () => {
      setValue();
    }

    onBeforeMount(async () => {
      await setOptions();
    });

    const setValue = (option) => {
      findActiveOption();
      if (option) {
        addFieldValue(props.fieldName, option.id);
      }

      if (option) {
        if (props.isBlockSelect) {
          activeOption.value[optionActive.value.id] = option;
        } else {
          activeOption.value = option;
        }
      }

      opened.value = false;
    };

    return {
      activeOption,
      optionActive,
      setValue,
      toggleOpen,
      opened,
      optionsList,
      activeOptionId: form[props.fieldName]
    };
  }
}
</script>

<style lang="scss" scoped>

.calc-select {
  width: 100%;
  position: relative;

  &__list {
    box-shadow: 0 2px 15px rgba(45, 45, 45, 0.2);
  }

  &__category-title {
    padding: 0 12px;
    line-height: 2;
    min-height: 32px;
    color: #00195A;
    font-weight: 600;
    font-family: 'Euclid Circular B';
  }

  &__category-title-text {
    display: block;
    border-bottom: 1px solid #E4E4E4;
    font-size: 16px;
  }

  &_read-only {
    opacity: 0.5;
  }

  &.opened {
    z-index: 99;
  }

  &__options {
    margin: 0;
    padding: 0;
    background: #FFFFFF;
    border-radius: 4px;
    font-size: 15px;
    line-height: 20px;
    color: #1E1E1E;
    list-style: none;
    overflow: auto;
  }

  &__max-height {
    max-height: 192px;
  }

  &__dropdown {
    top: 100%;
    padding: 7px 0 0 32px;
    width: 100%;
    box-sizing: border-box;
    position: absolute;
    max-height: 292px;
    overflow-y: scroll;

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
  }

  li {
    position: relative;
    padding: 10px 36px 10px 10px;
    cursor: pointer;

    &:hover {
      background: #E5EBEF;
    }

    &.active {
      background: #F1F2F0;
      display: flex;
      justify-content: space-between;
      padding-right: 10px;
    }
  }

  &__checked {
    fill: #007DEB;;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
  }
}

</style>
