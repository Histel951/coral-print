<template>
  <div class="colorful-field">
    <ColorSelector
      class="colorful-field__toggle-colors"
      :read-only="isReadOnly"
      :options="optionsList"
      :field-name="fieldName"
      :on-select-custom-colors="onSelectCustomColors"
      :is-selected-custom-colors="isSelectedCustomColors"
      :custom-color="customColor"
      :toggle-open="toggleOpen"
      :active-option="activeOption"
      :is-opened="isOpened"
      :set-value="setSelectValue"
    />
    <div v-if="!isNotCustom" class="colorful-field__custom-color" @click="openModal">
      <span class="colorful-field__custom-color-text" :class="{'colorful-field__disabled': isReadOnly}">
        свой вариант
      </span>
    </div>

    <FieldModal :size="colors?.length > 1 ? 'lg' : 'auto'" :opened="modalOpened" :title="label" :full-height="true" :on-close="closeModal">
      <ColorfulSelector
          :colors="colors"
          :paints="paints"
          :selected-color="openedColor"
          :selected-color-item="openedColor.activePaint"
          :on-submit="onSubmit"
          :opened-color="openedColor"
          :on-select-color="selectColor"
          :on-open-color="openColor"
          :on-add-color="addColor"
          :on-remove-color="removeColor"
      />
    </FieldModal>
  </div>
</template>

<script>
import ColorSelector from "@/components/fields/ColorSelector";
import {computed, onBeforeMount, ref, watch} from "vue";
import FieldModal from "@/components/modals/FieldModal";
import ColorfulSelector from "@/components/fields/ColorfulSelector";
import useForm from "@/composables/useForm";
import useFormSchema from "@/composables/useFormSchema";
import onClickOutside from "vue-click-outside-hook";
import useDeps from "@/composables/useDeps";

export default {
  name: "ColorfulField",
  components: {ColorSelector, ColorfulSelector, FieldModal},
  props: {
    isNotCustom: {
      type: Boolean,
      default: false
    },
    root: {
      types: Boolean,
      default: true
    },
    isDisabledCustom: {
      type: Boolean,
      default: false
    },
    isDisabled: {
      type: Boolean,
      default: false
    },
    fieldName: {
      type: String,
      default: ''
    },
    options: {
      type: Array,
      default: () => []
    },
    paints: {
      type: Array,
      default: () => []
    },
    label: {
      type: String,
      default: ''
    },
    readOnly: {
      types: Boolean,
      default: false
    },
    onRendered: Function,
    colorField: String,
    colorItemField: String
  },
  setup(props) {

    const colors = ref([{
      id: 1,
      name: 'Цвет 1:',
      isCustomColor: true,
      activePaint: props.paints[0]
    }]);

    const optionsList = ref(props.options);
    const customColor = ref({});
    const modalOpened = ref(false);
    const activeOption = ref(undefined);
    const opened = ref(false);
    const activeColor = ref(undefined);
    const {isSchemaRendered} = useFormSchema();
    const activeColorItem = ref(undefined);
    const {addFieldValue} = useForm();
    const toggleColor = ref(undefined);
    const toggleColorItem = ref(undefined);
    const openedColor = ref(undefined);
    const isSelectedCustomColors = ref(false);
    const {form} = useForm();
    const {activeDeps} = useDeps();
    const disabled = ref(false);

    const getOptionsItemsCount = () => {
      let count = 0;
      optionsList.value.forEach(category => {
        count += category.items.length;
      });

      return count;
    };

    const isReadOnly = computed(()=> props.readOnly || (optionsList.value && getOptionsItemsCount() < 1) || props.isDisabled || disabled.value);
    const isOpened = computed(() => !props.readOnly && opened.value);

    const addColor = () => {
      colors.value.push({
        id: colors.value.length + 1,
        name: `Цвет ${colors.value.length + 1}:`,
        activePaint: props.paints[0],
        isCustomColor: true
      });

      openColor(colors.value[colors.value.length - 1]);
    };

    const orderingColorsIds = () => {
      colors.value.forEach((color, index) => {
        color.id = index + 1;
        color.name = `Цвет ${index + 1}:`;
        color.isCustomColor = true;
      });
    };

    const removeColor = (color) => {
      if (color.id <= 1) {
        return;
      }

      const removeIndex = colors.value.findIndex(item => item.id === color.id);

      colors.value.splice(removeIndex, 1);
      orderingColorsIds();

      if (colors.value[removeIndex]) {
        setTimeout(() => openColor(colors.value[removeIndex]), 100);
      } else {
        setTimeout(() => openColor(colors.value[removeIndex - 1]), 100);
      }
    };

    const closeModal = () => {
        modalOpened.value = false;
    };

    const openModal = () => {
      if (isReadOnly.value) {
        return;
      }

      if (!props.isDisabledCustom) {
        modalOpened.value = true;
      }

      if (!isSelectedCustomColors.value) {
        colors.value = [];

        activeOption.value.items.forEach(item => {
          colors.value.push({
            id: colors.value.length + 1,
            name: `Цвет ${colors.value.length + 1}:`,
            activePaint: props.paints[props.paints.findIndex(paint => item.id === paint.id)],
            isCustomColor: true
          });
        });

        openColor(colors.value[0]);
      }
    };

    const selectColor = (color, colorItem) => {
        const index = colors.value.findIndex(item => item.id === color.id);

        colors.value[index].activePaint = colorItem;
        openedColor.value = colors.value[index];
    };

    const openColor = (color) => {
      openedColor.value = color;
    };

    const addColorsInForm = () => {
      const allColors = colors.value.map(item => ({id: item.activePaint.id, name: item.activePaint.name}));
      addFieldValue(props.fieldName, activeOption.value.id);

      let customColorPaints = [];
      allColors.forEach((paint) => {
        customColorPaints.push(paint);
      });

      addFieldValue(props.colorItemField, JSON.stringify(customColorPaints));
    };

    const setValue = (color, colorItem = null) => {
      activeColor.value = color;
      activeColorItem.value = colorItem;
      isSelectedCustomColors.value = color?.isCustomColor;

      addColorsInForm();

      // добавляет флаг, который обозначает отправляются кастомные цвета или нет
      addFieldValue('is_custom_color', Number(isSelectedCustomColors.value));
    }

    const onSelectCustomColors = (customColor) => {
      isSelectedCustomColors.value = true;
      opened.value = false;

      activeOption.value = customColor;
      opened.value = false;

      addColorsInForm();
      addFieldValue('is_custom_color', Number(isSelectedCustomColors.value));
    };

    const setToggleValue = (color, colorItem) => {
      toggleColor.value = color;
      toggleColorItem.value = colorItem;
    };

    const onSubmit = (material, color) => {
      setValue(material, color);
      setToggleValue(material, color);
      delete form[props.fieldName];
      closeModal();

      const allColors = colors.value.map(item => item.activePaint);

      let labelText;
      if (colors.value.length === 1) {
        labelText = 'цвет';
      } else if (colors.value.length >= 2 && colors.value.length <= 4) {
        labelText = 'цвета';
      } else {
        labelText = 'цветов';
      }

      customColor.value = {
        name: `${colors.value.length} ${labelText}`,
        items: allColors
      };

    }

    const toggleOpen = () => {
      if (!isReadOnly.value) {
        opened.value = !opened.value
      }
    }

    const getOptions = async () => {
      if (activeDeps.value[props.fieldName]) {
        return activeDeps.value[props.fieldName].colors;
      }

      if (!isSchemaRendered.value) {
        return props.options;
      }
    };

    const findActiveOption = () => {
      const activeOptionIndex = optionsList.value.findIndex(item => form[props.fieldName] === item.id);

      if (optionsList.value) {
        return optionsList.value[activeOptionIndex] ?? optionsList.value[0];
      }

      return null;
    };

    const setSelectValue = (option) => {
      activeOption.value = option;
      opened.value = false;

      addFieldValue(props.fieldName, activeOption.value.id);
      form[props.colorItemField] = JSON.stringify([]);

      isSelectedCustomColors.value = option?.isCustomColor ?? false;

      addFieldValue('is_custom_color', Number(isSelectedCustomColors.value));
    };

    const setOptions = async () => {
      optionsList.value = await getOptions();
      setSelectValue(findActiveOption());
    }

    onClickOutside(() => {
      opened.value = false;
    });

    onBeforeMount(async () => {
      openColor(colors.value[0]);

      watch(optionsList, newOptionsList => {
        disabled.value = !(newOptionsList.length > 1);
      });

      watch(() => activeDeps.value[props.fieldName], async () => {
        await setOptions();
      });

      colors.value.forEach(color => {
        color.activePaint = props.paints[0];
      });

      await setOptions();
      if (props.root) {
        props.onRendered();
      }
    });

    return {
      openColor,
      colors,
      modalOpened,
      closeModal,
      openModal,
      onSubmit,
      openedColor,
      selectColor,
      toggleColor,
      toggleColorItem,
      addColor,
      removeColor,
      optionsList,
      onSelectCustomColors,
      isSelectedCustomColors,
      customColor,
      toggleOpen,
      activeOption,
      isOpened,
      setSelectValue,
      isReadOnly
    };
  }
}
</script>

<style lang="scss" scoped>
.colorful-field {
  display: flex;
  width: 100%;
  align-items: center;

  &__toggle-colors {
    width: 208px;
  }

  &__custom-color {
    cursor: pointer;
    margin-left: 8px;
    display: inline-block;
    align-items: center;
    color: #007DEB;
    font-size: 15px;
  }

  &__disabled {
     opacity: 0.4;
    cursor: default;
   }
}
</style>
