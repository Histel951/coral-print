<template>
  <div class="material-field" :class="{'material-field__disabled': readOnly}" v-if="optionsList?.data && activeMaterial">
    <SelectToggler :preview-color="toggleColor?.color" :preview-img="activeMaterial?.spec_icon?.url ?? toggleColor?.image?.url"
                   :label="toggleMaterial?.name" @click="openModal"/>
    <FieldModal :size="optionsList?.data.length > 1 ? 'lg' : 'auto'" :opened="modalOpened" :title="label" :full-height="true" :on-close="closeModal">
      <RadioMaterialSelector :all-colors="options.all_items"
                             :materials="optionsList?.data"
                             :material-field="materialField"
                             :on-submit="onSubmit"
                             :on-open-material="openMaterial"
                             :opened-material="openedMaterial"
                             :on-select-material="selectMaterial"
                             :selected-color="selectedColor"
                             :selected-material="selectedMaterial"/>
    </FieldModal>
  </div>
</template>

<script>
import {computed, onBeforeMount, onBeforeUnmount, onBeforeUpdate, ref, watch} from "vue";
import useForm from "../../composables/useForm";
import useFormSchema from "../../composables/useFormSchema";
import SelectToggler from "./SelectToggler";
import useWindow from "../../composables/useWindow";
import FieldModal from "../modals/FieldModal";
import RadioMaterialSelector from "./RadioMaterialSelector";
import useRoute from "../../composables/useRoute";
import useFieldConditionsHelpers from "@/composables/useFieldConditionsHelpers";

export default {
  name: "RadioMaterialField",
  props: {
    materialField: String,
    colorField: String,
    deps: [Array, Boolean],
    url: String,
    options: Object,
    onRendered: Function,
    label: String,
    readOnly: {
      types: Boolean,
      default: false
    }
  },
  components: {RadioMaterialSelector, FieldModal, SelectToggler},
  setup(props) {
    const {origin} = useRoute();
    const {addFieldValue} = useForm();
    const activeMaterial = ref(undefined);
    const activeColor = ref(undefined);
    const optionsList = ref(undefined);
    const {isSchemaRendered, calculator_id} = useFormSchema();
    const openedMaterial = ref(activeMaterial);
    const selectedMaterial = ref(activeMaterial);
    const selectedColor = ref(activeColor);
    const modalOpened = ref(false);
    const isOpened = computed(() => !props.readOnly && modalOpened.value);
    const {form} = useForm();
    const {windowWidth} = useWindow();
    const {disabledItems} = useFieldConditionsHelpers();
    const toggleMaterial = ref({});
    const toggleColor = ref({});

    const openModal = () => {
      if (!props.readOnly) {
        modalOpened.value = true;
      }
    }

    const closeModal = () => {
      if (!props.readOnly) {
        optionsList.value.data.forEach(material => {
          if (material.id === form[props.materialField]) {
            activeMaterial.value = material;
          }
        });

        activeColor.value = findActiveColor();

        modalOpened.value = false;
      }
    }

    const prepareParams = () => new URLSearchParams(
        Object.fromEntries(
            props.deps.map((item) => [item, form[item]])
        )
    ).toString();

    const loadOoptions = async () => {
      const urlParams = prepareParams();
      try {
        if (calculator_id.value) {
          const response = await fetch(`${origin.value}${props?.url}&${urlParams}`);
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

    const setValue = (material, color = null) => {
      addFieldValue(props.materialField, material.id);
      addFieldValue(props.colorField, color ? color.id : '');
      activeMaterial.value = material;
      activeColor.value = color;
    }

    const selectMaterial = (material, color = null) => {

      const choseMaterial = material.items.filter(itemColor => itemColor.id === color.id);

      if (choseMaterial.length) {
        selectedMaterial.value = material;
      } else {
        optionsList.value.data.some(material => {
          if (!material.disabled) {
            const activeColor = material.items.filter(itemColor => color.id === itemColor.id);

            if (activeColor.length) {
              selectedMaterial.value = material;
              return true;
            }
          }
        });
      }

      if (color) {
        selectedColor.value = color;
      }
    }

    const openMaterial = (material) => {
      if (!material.disabled) {
        openedMaterial.value = material;

        const itemIndex = material.items.findIndex(item => item.id === selectedColor.value?.id);
        selectMaterial(material, material.items[itemIndex < 0 ? 0 : itemIndex]);
      }
    }

    const findActiveMaterial = (options) => {
      let tempActiveMaterial = undefined;

      if (form[props.materialField]) {
        tempActiveMaterial = options.data.find(material => material.id === form[props.materialField]);

        return tempActiveMaterial ?? options.data[0];
      }

      if (activeMaterial.value) {
        tempActiveMaterial = options.data.find((material) => material.id === activeMaterial.value.id);
      }
      return tempActiveMaterial ? tempActiveMaterial : options.data[0];
    }

    const findActiveColor = () => {
      let tempActiveColor = undefined;

      if (form[props.colorField]) {
        tempActiveColor = props.options.all_items.find(color => color.id === form[props.colorField]);

        return tempActiveColor;
      }

      if (activeColor.value && props.options.all_items.length > 1) {
        tempActiveColor = props.options.all_items.find((color) => color.id === activeColor.value.id)
      }
      return tempActiveColor ? tempActiveColor : props.options.all_items[0];
    }

    const setOptions = async () => {
      optionsList.value = await getOptions();
      const newActiveMaterial = findActiveMaterial(optionsList.value);
      const newActiveColor = findActiveColor();
      setValue(newActiveMaterial, newActiveColor);
    }

    const setToggleValue = (material, color) => {
      toggleMaterial.value = material;
      toggleColor.value = color;
    };

    const onSubmit = (material, color) => {
      setValue(material, color);
      setToggleValue(material, color);
      closeModal();
    }

    let depsTimeout = null;

    if (props.deps) {
      watch(() => props.deps.map((item) => form[item]), () => {
        if (depsTimeout) {
          clearTimeout(depsTimeout);
        }

        depsTimeout = setTimeout(async () => {
          await setOptions();
          depsTimeout = null;
        }, 50);

      });
    }

    watch(() => form[props.materialField], async newValue => {
      if (newValue && activeMaterial.value) {
        optionsList.value = await getOptions();
        const activeMaterial = optionsList.value.data.find(material => material.id === newValue);
        const activeColor = findActiveColor();

        setValue(activeMaterial, activeColor);
        openMaterial(activeMaterial);
      }
    });

    const setDisabled = () => {
      if (optionsList.value) {
        optionsList.value.data.forEach(material => {
          if (typeof material.disabled === 'undefined') {
            material.disabled = false;
          }
        });
      }
    };

    const loadDefaultOptions = async () => {
      optionsList.value = await getOptions();
      const newActiveMaterial = findActiveMaterial(optionsList.value);
      const newActiveColor = findActiveColor(newActiveMaterial);

      if (!form[props.materialField]) {
        addFieldValue(props.materialField, newActiveMaterial.id ?? optionsList.value.data[0]);
        addFieldValue(props.colorField, newActiveColor ? newActiveColor.id : '');

        activeMaterial.value = newActiveMaterial;
        activeColor.value = newActiveColor;
      }

      if (!activeMaterial.value) {
        activeMaterial.value = newActiveMaterial;
      }

      if (!activeColor.value) {
        activeColor.value = newActiveColor;
      }

      setToggleValue(activeMaterial.value, activeColor.value);
    };

    onBeforeUpdate(() => {
      loadDefaultOptions();
    });

    onBeforeMount(async () => {
      await loadDefaultOptions();

      selectMaterial(activeMaterial.value, activeColor.value);
      await setDisabled();
      props.onRendered();
    });

    watch(form, () => {
      if (disabledItems.value[props.materialField]) {
        optionsList.value.data.forEach(material => {
          material.disabled = disabledItems.value[props.materialField].items.includes(material.id);
        });
      }

      if (activeMaterial.value && activeMaterial.value.disabled) {
        optionsList.value.data.forEach(material => {
          if (!material.disabled) {
            activeMaterial.value = material;
          }
        });
      }
    });

    onBeforeUnmount(() => {
      // removeField(props.materialField);
      // removeField(props.colorField);
    });

    return {
      optionsList,
      activeMaterial,
      activeColor,
      isOpened,
      closeModal,
      openModal,
      windowWidth,
      modalOpened,
      onSubmit,
      openMaterial,
      openedMaterial,
      selectMaterial,
      selectedColor,
      selectedMaterial,
      toggleMaterial,
      toggleColor
    }
  }
}
</script>


<style lang="scss" scoped>
.material-field {
  width: 100%;

  &__disabled {
    opacity: 0.4;
  }
}

@media all and (min-width: 1024px) {

}
</style>
