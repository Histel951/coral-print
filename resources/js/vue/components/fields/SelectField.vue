<template>
  <div v-if="optionsList" :style="selectStyle" class="calc-select" :class="{opened: isOpened, 'calc-select_read-only': isReadOnly}">
    <SelectToggler
      :is-error="isError"
      :label="String(activeOption?.name ?? '')"
      @click="toggleOpen"
      :prev-text="activeOption?.prevText"
      :post-text="activeOption?.postText"
      :post-text-icon="activeOption?.isUsePostTextIcon ? postTextIcon : ''"
      :post-name-text="activeOption?.postNameText"
      :is-not-use-post-text-icon="isNotUsePostTextIcon"
      :is-use-post-text-icon="activeOption?.isUsePostTextIcon"
      :toggle-style="toggleStyle"
    />
    <div v-if="isOpened" class="calc-select__dropdown" :style="selectStyleDropdown">
      <ul :style="selectStyleUl" :class="{'calc-select__options': true, 'calc-select__options__max-height': isScrolling}">
        <li v-for="option in !isNotActions ? actionOptions : []" class="calc-select__options__item" :key="option.name" @click="option.action(option)">
          {{ option.name }}
        </li>
        <li v-for="option in optionsList" :key="option.id"
            :class="{
              active: option === activeOption,
              'calc-select__options__item': !option?.disabled,
              'calc-select__options__item-disabled': option?.disabled
            }"
            @click="setValue(option)">
          <span>
            <span v-if="option?.prevText">{{ option?.prevText }}</span>
            {{ option.name }}<span v-if="option?.postNameText?.length && option?.isUsePostTextIcon && !isNotUsePostTextIcon && option?.postText?.length" v-html="option?.postNameText"></span>
            <svg style="padding-top: 1px" width="18" height="18" v-if="option?.isUsePostTextIcon && postTextIcon && !isNotUsePostTextIcon && option?.postText?.length">
              <use :xlink:href="'#' + postTextIcon"></use>
            </svg><span v-if="option?.postText?.length" v-html="option?.postText"></span>
          </span>
          <CheckIcon v-if="option === activeOption" aditional-class="calc-select__checked"/>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import {computed, onBeforeMount, onBeforeUnmount, onBeforeUpdate, ref, watch, watchEffect} from "vue";
import useForm from "../../composables/useForm";
import useFormSchema from "../../composables/useFormSchema";
import SelectToggler from "./SelectToggler";
import CheckIcon from "../icons/CheckIcon";
import onClickOutside from 'vue-click-outside-hook';
import useInitData from "@/composables/useInitData";
import useFieldConditionsHelpers from "@/composables/useFieldConditionsHelpers";
import usePrice from "@/composables/usePrice";
import useDeps from "@/composables/useDeps";

export default {
  name: "SelectField",
  props: {
    isNotUsePostTextIcon: {
      type: Boolean,
      default: false
    },
    selectStyleDropdown: {
      type: Object,
      default: () => {}
    },
    toggleStyle: {
      type: Object,
      default: () => {}
    },
    selectStyleUl: {
      type: Object,
      default: () => {}
    },
    postTextIcon: {
      type: String,
      default: ''
    },
    isUseValue: {
      type: Boolean,
      default: false
    },
    selectStyle: {
      type: Object,
      default: () => {}
    },
    isError: {
      type: Boolean,
      default: false
    },
    fieldName: String,
    actionOptions: {
      types: Array,
      default: []
    },
    isScrolling: {
      type: Boolean,
      default: true
    },
    deps: [Array, Boolean],
    url: String,
    optionsUrl: String,
    options: Array,
    altSelectHandler: Function,
    onRendered: Function,
    readOnly: {
      types: Boolean,
      default: false
    },
    updateCalcImg: {
      types: Boolean,
      default: false
    },
    root: {
      types: Boolean,
      default: true
    },
    isNotUsePostNameIcon: {
      type: Boolean,
      default: false
    },
    isNotUsePostNameText: {
      type: Boolean,
      default: false
    },
    isNotActions: {
      type: Boolean,
      default: false
    }
  },
  components: {SelectToggler, CheckIcon},
  setup(props) {
    const {getData} = useInitData();
    const {addFieldValue} = useForm();
    const activeOption = ref(undefined);
    const optionsList = ref(undefined);
    const {isSchemaRendered, calculator_id} = useFormSchema();
    const opened = ref(false);
    const {disabledItems} = useFieldConditionsHelpers();
    const isOpened = computed(() => !props.readOnly && opened.value);
    const {form} = useForm();
    const depsReadOnly = ref(false);
    const {addWaitAction, delWaitAction} = usePrice();
    const {activeDeps} = useDeps();

    const isReadOnly = computed(() => props.readOnly || (optionsList.value && optionsList.value.length < 2) || depsReadOnly.value);

    const toggleOpen = () => {
      if (!isReadOnly.value) {
        opened.value = !opened.value
      }
    }

    watch(form, () => {
      if (disabledItems.value[props.fieldName]) {
        optionsList.value.forEach(item => {
          item.disabled = disabledItems.value[props.fieldName].items.includes(item.id);
        });

        if (activeOption.value.disabled) {
          setValue(optionsList.value[0]);
        }
      } else if (optionsList.value) {
        optionsList.value.forEach(item => {
          item.disabled = false;
        });
      }
    });

    onClickOutside(() => {
      opened.value = false;
    });

    const prepareParams = () => new URLSearchParams(
        Object.fromEntries(
            props.deps.map((item) => [item, form[item]])
        )
    ).toString();

    const loadOoptions = async () => {
      depsReadOnly.value = true;
      const urlParams = prepareParams();
      try {
        if (calculator_id.value) {
          console.log('load options');
          const response = await fetch(`${props.url}/${calculator_id.value}?${urlParams}`);
          return response.json();
        }
      } catch (e) {
        console.log('error load options');
        throw Error("Can't load options list");
      }
    }

    const getOptions = async () => {
      if (activeDeps.value[props.fieldName]) {
        return activeDeps.value[props.fieldName];
      }

      if (!isSchemaRendered.value || !props.deps || !props.deps?.length) {
        return props.options;
      } else {
        return await loadOoptions();
      }
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

    const findActiveOption = () => {
      let activeIndex = -1;
      if (form[props.fieldName] && !props.isUseValue) {
        activeIndex = optionsList.value.findIndex((item) => form[props.fieldName] === item.id);
      } else if (form[props.fieldName]) {
        activeIndex = optionsList.value.findIndex((item) => form[props.fieldName] === item.value);
      }

      if (optionsList.value) {
          return activeIndex > -1 ? optionsList.value[activeIndex] : optionsList.value[0];
      }

      return null;
    }

    const setOptions = async () => {
      addWaitAction();
      optionsList.value = await getOptions();
      delWaitAction();
      depsReadOnly.value = false;
      setValue(findActiveOption());
    }

    const stopWatchVal = watchEffect(() => {
      if (form[props.fieldName] && activeOption.value && (form[props.fieldName] !== activeOption.value.id)) {
        activeOption.value = findActiveOption();
      }
    });

    watch(() => activeDeps.value[props.fieldName], async () => {
      await setOptions();
    });

    onBeforeUpdate(async () => {
      if (!props.deps) {
        optionsList.value = getData(props.fieldName);
      }
    });

    onBeforeMount(async () => {
      await setOptions();
      if (props.root) {
        props.onRendered();
      }
    });

    onBeforeUnmount(() => {
      stopWatchVal();
      // removeField(props.fieldName);
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
      white-space: nowrap;
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
