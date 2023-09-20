<template>
  <div v-if="optionsList" :style="selectStyle" class="calc-select" :class="{opened: isOpened, 'calc-select_read-only': isReadOnly}">
    <SelectToggler :label="String(activeOption?.name ?? '')" @click="toggleOpen"/>
    <div v-if="isOpened" class="calc-select__dropdown">
      <div class="select__options-list">
        <div class="select__options" v-for="option in optionsList" :key="option.category">
          <div class="category__container">
            <span class="category__text">{{ option.category }}</span>
          </div>
          <ul class="category__items-list">
            <li
              v-for="option in actionOptions"
              class="calc-select__options__item"
              :key="option.name"
              @click="option.action(option)"
              v-html="option.name"
            />
            <li v-for="item in option.items" :key="item.id"
                :class="{
                active: item === activeOption,
                'calc-select__options__item': !item?.disabled,
                'calc-select__options__item-disabled': item?.disabled
              }"
                @click="setValue(item)">
              <span><span v-html="item.name" /> <svg style="padding-top: 1px" width="18" height="18" v-if="item?.isUsePostTextIcon"><use :xlink:href="'#' + postTextIcon"></use></svg> {{ item?.postText }}</span>
              <CheckIcon v-if="item === activeOption" aditional-class="calc-select__checked"/>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SelectToggler from "@/components/fields/SelectToggler";
import CheckIcon from "@/components/icons/CheckIcon";
import useInitData from "@/composables/useInitData";
import useForm from "@/composables/useForm";
import {computed, onBeforeMount, onBeforeUnmount, onBeforeUpdate, ref, watch, watchEffect} from "vue";
import useFormSchema from "@/composables/useFormSchema";
import onClickOutside from "vue-click-outside-hook";
import useDeps from "@/composables/useDeps";

export default {
  name: "SelectCategory",
  components: {CheckIcon, SelectToggler},
  props: {
    postTextIcon: {
      type: String,
      default: ''
    },
    readOnly: {
      types: Boolean,
      default: false
    },
    actionOptions: {
      types: Array,
      default: []
    },
    selectStyle: {
      type: Object,
      default: () => {}
    },
    deps: [Array, Boolean],
    onRendered: Function,
    altSelectHandler: Function,
    options: Array,
    fieldName: String,
    root: {
      types: Boolean,
      default: true
    },
    isUseValue: {
      type: Boolean,
      default: false
    },
    name: {
      type: String,
      default: ''
    }
  },
  setup(props) {
    const {getData} = useInitData();
    const {addFieldValue, form} = useForm();
    const activeOption = ref(undefined);
    const optionsList = ref(undefined);
    const {isSchemaRendered} = useFormSchema();
    const opened = ref(false);
    const {activeDeps} = useDeps();

    const getAllMaterialsCount = () => {
      let count = 0;

      if (optionsList.value) {
        optionsList.value.forEach(category => count += category.items.length);
      }

      return count;
    };

    const isReadOnly = computed(()=> props.readOnly || (optionsList.value && getAllMaterialsCount() < 2));
    const isOpened = computed(() => !props.readOnly && opened.value);

    const findActiveOption = () => {
      let activeIndex = -1;
      let categoryIndex = -1;
      if (form[props.fieldName] && !props.isUseValue) {
        optionsList.value.some((category, index) => {
          activeIndex = category.items.findIndex(item => form[props.fieldName] === item.id);

          if (activeIndex !== -1) {
            categoryIndex = index;

            return true;
          }
        });
      } else if (form[props.fieldName]) {
        optionsList.value.some((category, index) => {
          activeIndex = category.items.findIndex(item => form[props.fieldName] === item.value);

          if (activeIndex !== -1) {
            categoryIndex = index;

            return true;
          }
        });
      }

      if (optionsList.value) {
        return activeIndex > -1 ? optionsList.value[categoryIndex].items[activeIndex] : optionsList.value[0].items[0];
      }

      return null;
    }

    onClickOutside(() => {
      opened.value = false;
    });

    const stopWatchVal = watchEffect(() => {
      if (form[props.fieldName] && activeOption.value && (form[props.fieldName] !== activeOption.value.id)) {
        activeOption.value = findActiveOption();
      }
    });

    onBeforeUpdate(async () => {
      if (!props.deps) {
        optionsList.value = await getOptions();
      }
    });

    const setOptions = async () => {
      optionsList.value = await getOptions();
      setValue(findActiveOption());
    }

    const setValue = (option) => {
      if (option?.disabled) {
        return;
      }

      if (props.altSelectHandler) {
        props.altSelectHandler(option);
      } else {
        if (option) {
          if (props.isUseValue) {
            addFieldValue(props.fieldName, option.value);
          } else {
            addFieldValue(props.fieldName, option.id);
          }
        }
      }

      activeOption.value = option;
      opened.value = false;
    }

    const getOptions = async () => {
      if (activeDeps.value[props.name]) {
        return activeDeps.value[props.name];
      }

      if (!isSchemaRendered.value || !props.deps || !props.deps.length) {
        return props.options;
      }

      return getData(props.fieldName);
    }

    const toggleOpen = () => {
      if (!isReadOnly.value) {
        opened.value = !opened.value
      }
    }

    onBeforeMount(async () => {
      await setOptions();

      if (activeDeps.value[props.name]) {
        watch(activeDeps, async () => {
          optionsList.value = activeDeps.value[props.name];
        }, {deep: true});
      }

      if (props.root) {
        props.onRendered();
      }
    });

    onBeforeUnmount(() => {
      stopWatchVal();
    });

    return {
      optionsList,
      activeOption,
      isReadOnly,
      setValue,
      isOpened,
      toggleOpen
    }
  }
}
</script>

<style lang="scss" scoped>

.category {
  &__container {
    margin: 0 8px 0 8px;
    height: 40px;
    line-height: 40px;
    font-weight: 600;
    border-bottom: 1px solid #E4E4E4;
  }

  &__text {
    font-size: 16px;
    font-weight: 600;
    color: #00195A;
  }

  &__items-list {
    margin: 0;
  }
}

.select {
  &__options-list {
    box-shadow: 0 2px 15px rgba(45, 45, 45, 0.2);
  }

  &__options {
    max-height: 352px;
    margin: 0;
    padding: 0;
    background: #FFFFFF;
    border-radius: 4px;
    font-size: 15px;
    line-height: 20px;
    color: #1E1E1E;
    list-style: none;
    overflow: auto;

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
    width: 100%;
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

    &__item {
      position: relative;
      padding: 6px 36px 6px 10px;
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
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
  }
}

@media all and (min-width: 1024px) {
  .calc-select {
    &__dropdown {
      top: 100%;
      padding: 7px 0 0 32px;
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
