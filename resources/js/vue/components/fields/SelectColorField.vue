<template>
  <div v-if="optionsList" class="calc-select" :style="selectStyle" :class="{opened: isOpened, 'calc-select_read-only': isReadOnly}">
    <SelectToggler :label="activeOption?.name" @click="toggleOpen"
    />
    <div v-if="isOpened" class="calc-select__dropdown">
      <ul class="calc-select__options">
        <li class="calc-select__option" v-for="option in optionsList" :key="option?.id" :class="{active: option === activeOption}"
            @click="setValue(option)">
          <span class="calc-select__option__name">{{ option?.name }}</span>
          <CheckIcon v-if="option === activeOption" aditional-class="calc-select__checked"/>
        </li>
        <li v-for="option in actionOptions" :key="option.name" @click="option.action(option)">
          {{ option?.name }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import {computed, inject, onBeforeMount, onBeforeUnmount, ref, watch, watchEffect} from "vue";
import useForm from "../../composables/useForm";
import useFormSchema from "../../composables/useFormSchema";
import SelectToggler from "./SelectToggler";
import CheckIcon from "../icons/CheckIcon";
import onClickOutside from 'vue-click-outside-hook';

export default {
  name: "SelectColorField",
  props: {
    isUseValue: {
      type: Boolean,
      default: false
    },
    selectStyle: {
      type: Object,
      default: () => {}
    },
    fieldName: String,
    actionOptions: {
      types: Array,
      default: []
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
    defaultId: Number,
  },
  components: {SelectToggler, CheckIcon},

  setup(props) {
    const colorCount = inject('colorCount')
    const {addFieldValue} = useForm();
    const activeOption = ref(undefined);
    const optionsList = ref(undefined);
    const {isSchemaRendered, calculator_id} = useFormSchema();
    const opened = ref(false);
    const isOpened = computed(() => !props.readOnly && opened.value);
    const {form} = useForm();

    const isReadOnly = computed(()=> props.readOnly || (optionsList.value && optionsList.value.length < 2));

    const toggleOpen = () => {
      if (!isReadOnly.value) {
        opened.value = !opened.value
      }
    }

    onClickOutside(() => {
      opened.value = false;
    });

    watchEffect(() => {
      // фикс индексации и длины массива
      if (optionsList.value) {
        let optionsLength = 0;
        optionsList.value.forEach((item, index) => {
          optionsList.value[index] = item;
          optionsLength = index + 1;
        });

        optionsList.value.length = optionsLength;

        if (!activeOption.value) {
          activeOption.value = optionsList.value[0];
        }
      }
    });

    const prepareParams = () => new URLSearchParams(
      Object.fromEntries(
        props.deps.map((item) => [item, form[item]])
      )
    ).toString();

    const loadOoptions = async () => {
      const urlParams = prepareParams();
      try {
        if (calculator_id.value) {
          const response = await fetch(`${props.url}/${calculator_id.value}?${urlParams}`);
          return response.json();
        }
      } catch (e) {
        throw Error("Can't load options list");
      }
    }

    const getOptions = async () => {
      if (!isSchemaRendered.value || !props.deps || !props.deps.length) {
        return props.options;
      } else {
        return await loadOoptions();
      }
    }

    const setValue = (option) => {
      if (props.altSelectHandler) {
        props.altSelectHandler(option);
      } else {

        if (option) {
          addFieldValue(props.fieldName, option.id);
        } else {
          addFieldValue(props.fieldName, optionsList.value[0].id);
        }

      }
      activeOption.value = option;
      opened.value = false;
    }

    const findActiveOption = () => {
      let activeIndex = -1;
      if (form[props.fieldName]) {
        activeIndex = optionsList.value.findIndex((item) => form[props.fieldName] === item.id);
      }

      if (optionsList.value) {
        if (props.defaultId) {
          activeIndex = props.defaultId;
        }

        return activeIndex > -1 ? optionsList.value[activeIndex] : optionsList.value[0];
      }

      return null;
    }

    const setOptions = async () => {
      optionsList.value = await getOptions();
      setValue(findActiveOption());
    }

    const stopWatchVal = watchEffect(() => {
      activeOption.value && (colorCount.value = activeOption.value);

      if (form[props.fieldName] && activeOption.value && (form[props.fieldName] !== activeOption.value.id)) {
        activeOption.value = findActiveOption();
      }

    });

    if (props.deps) {
      watch(() => props.deps.map((item) => form[item]), () => {
        setOptions();
      });
    }

    watch(colorCount, () => {
      if (colorCount.value && colorCount.value !== activeOption.value) {
        optionsList.value = props.options.slice(0, props.options.length - colorCount.value.id + 1)
      }
    });

    onBeforeMount(async () => {
      if (form[props.fieldName]) {
        optionsList.value = await getOptions();
        const newActiveValue = optionsList.value.find(el => el?.id === form[props.fieldName]);

        setValue(newActiveValue);
      } else {
        await setOptions();
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

  &__option {
    display: flex;
    justify-content: space-between;
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
    max-height: 192px;

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

    li {
      position: relative;
      padding: 10px;
      cursor: pointer;

      &:hover {
        background: #E5EBEF;
      }

      &.active {
        background: #F1F2F0;
      }
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
