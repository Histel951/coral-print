<template>
  <div class="material-field" :class="{'material-field__disabled': readOnly}" v-if="optionsList.length && activeMaterial">
    <SelectToggler
      :preview-img="activeMaterial?.preview?.url"
      :styles-preview="{width: '32px', height: '20px'}"
      :label="activeCategory?.name" @click="openModal"
      :is-img="true"
    />

    <FieldModal size="m" :opened="modalOpened" :title="label" :full-height="true" :on-close="closeModal">
      <HorizontalMaterialSelector
        :options-category="optionsList"
        :on-submit="onSubmit"
        :toggle-option="toggleMaterial"
        :toggle-category="toggleCategory"
        :on-open-option="setToggleValue"
      />
    </FieldModal>
  </div>
</template>

<script>
import SelectToggler from "@/components/fields/SelectToggler";
import FieldModal from "@/components/modals/FieldModal";
import useFormSchema from "@/composables/useFormSchema";
import useForm from "@/composables/useForm";
import {onBeforeMount, ref} from "vue";
import HorizontalMaterialSelector from "@/components/fields/HorizontalMaterialSelector";

export default {
  name: "HorizontalMaterialField",
  components: {HorizontalMaterialSelector, FieldModal, SelectToggler},
  props: {
    fieldName: String,
    options: Array,
    onRendered: Function,
    deps: [Array, Boolean],
    label: {
      type: String,
      default: ''
    },
    readOnly: {
      types: Boolean,
      default: false
    },
    root: {
      types: Boolean,
      default: true
    }
  },
  setup(props) {
    const {form, addFieldValue} = useForm();
    const {isSchemaRendered} = useFormSchema();
    const optionsList = ref(props.options);
    const activeMaterial = ref(null);
    const modalOpened = ref(false);
    const toggleMaterial = ref(null);
    const activeCategory = ref(null);
    const toggleCategory = ref(null);

    const openModal = () => {
      if (!props.readOnly) {
        modalOpened.value = true;
      }
    }

    const closeModal = () => {
      modalOpened.value = false;
    };

    const setValue = (material, category) => {
      addFieldValue(props.fieldName, material.id);
      activeMaterial.value = material;
      activeCategory.value = category;
    }

    const setToggleValue = (material, category) => {
      toggleMaterial.value = material;
      toggleCategory.value = category;
    };

    const onSubmit = (material) => {
      setValue(material, toggleCategory.value);
      setToggleValue(material, toggleCategory.value);
      closeModal();
    }

    const getOptions = async () => {
      if (!isSchemaRendered.value || !props.deps || !props.deps.length) {
        return props.options;
      }
    }

    const findActiveMaterial = () => {
      let tempActiveMaterial = undefined;

      if (form[props.fieldName]) {
        optionsList.value.forEach(category => {
          if (category.items) {
            tempActiveMaterial = category.items.find((material) => material.id === form[props.fieldName]);
          }
        })
        return tempActiveMaterial ?? optionsList.value[0].items[0];
      }

      if (activeMaterial.value) {
        optionsList.value.forEach(category => {
          tempActiveMaterial = category.items.find((material) => material.id === activeMaterial.value.id);
        })
      }

      return tempActiveMaterial ? tempActiveMaterial : optionsList.value[0].items[0];
    }

    const findActiveCategory = () => {
      let tempCategory = undefined;

      if (form[props.fieldName]) {
        optionsList.value.some((category) => {
          let tempActiveMaterial;
          if (category.items) {
            tempActiveMaterial = category.items.find((material) => material.id === form[props.fieldName]);
          }

          if (tempActiveMaterial) {
            tempCategory = category;

            return true;
          }
        });

        return tempCategory ? tempCategory : optionsList.value[0];
      }

      return activeMaterial.value ?? optionsList.value[0];
    };

    const loadDefaultOptions = async () => {
      optionsList.value = await getOptions();
      const newActiveMaterial = findActiveMaterial();
      const newActiveCategory = findActiveCategory();

      if (!form[props.fieldName]) {
        addFieldValue(props.fieldName, newActiveMaterial.id ?? optionsList.value[0]);

        activeMaterial.value = newActiveMaterial;
      }

      if (!activeMaterial.value) {
        activeMaterial.value = newActiveMaterial;
      }

      if (!activeCategory.value) {
        activeCategory.value = newActiveCategory;
      }

      setToggleValue(activeMaterial.value);
    };

    onBeforeMount(async () => {
      await loadDefaultOptions();

      if (props.root) {
        props.onRendered();
      }
    });

    return {
      closeModal,
      setToggleValue,
      openModal,
      onSubmit,
      modalOpened,
      optionsList,
      activeMaterial,
      toggleMaterial,
      activeCategory,
      toggleCategory
    };
  }
}
</script>

<style scoped>

.material-field {
  width: 100%;
}

</style>
