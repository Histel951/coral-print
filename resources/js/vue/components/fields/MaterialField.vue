<template>
  <div v-if="optionsList" :class="{'material-field__read-only': readOnly, 'material-field': true}">
    <SelectToggler :preview-color="activeColor?.color" :preview-img="activeColor?.image?.url"
                   :label="isFindActiveMaterial ? `${activeMaterial.name ?? ''}  ${activeMaterial.type_name ?? ''}` : ''" @click="openModal"/>
    <FieldModal size="lg" :opened="modalOpened" title="Материал" :full-height="true" :on-close="closeModal">
      <MaterialSelector :materials="optionsList" :active-material="activeMaterial"
                        :active-color="activeColor" :on-submit="onSubmit"
                        :submit-material="submitMaterial"
                        :is-opened="modalOpened"/>
    </FieldModal>
  </div>
</template>

<script>
import {computed, onBeforeMount, onBeforeUnmount, onBeforeUpdate, ref, watch, watchEffect} from "vue";
import useForm from "../../composables/useForm";
import useFormSchema from "../../composables/useFormSchema";
import SelectToggler from "./SelectToggler";
import useWindow from "../../composables/useWindow";
import FieldModal from "../modals/FieldModal";
import MaterialSelector from "./MaterialSelector";
import useInitData from "@/composables/useInitData";
import useFieldConditionsHelpers from "@/composables/useFieldConditionsHelpers";
import {watchDebounced} from "@vueuse/core";
import useCheck from "@/composables/useCheck";
import usePrice from "@/composables/usePrice";
import useDeps from "@/composables/useDeps";

export default {
  name: "MaterialField",
  props: {
    isBlockSelect: {
      type: Boolean,
      default: false
    },
    materialField: String,
    colorField: String,
    deps: [Array, Boolean],
    url: String,
    options: Array,
    onRendered: Function,
    fieldSchema: {
      type: Object,
      default: () => {}
    },
    readOnly: {
      types: Boolean,
      default: false
    }
  },
  components: {MaterialSelector, FieldModal, SelectToggler},
  setup(props) {
    const {addFieldValue} = useForm();
    const activeMaterial = ref(undefined);
    const activeColor = ref(undefined);
    const optionsList = ref(undefined);
    const {isSchemaRendered} = useFormSchema();
    const modalOpened = ref(false);
    const isOpened = computed(() => !props.readOnly && modalOpened.value);
    const {form} = useForm();
    const {windowWidth} = useWindow();
    const {calculator_id} = useFormSchema();
    const {disabledItems, disableItems, dropDisabledItemsByField} = useFieldConditionsHelpers();
    const {getData} = useInitData();
    const isFindActiveMaterial = ref(true);
    const submitMaterial = ref({});
    const {getParams} = useCheck();
    const {addWaitAction, delWaitAction} = usePrice();
    const {activeDeps} = useDeps();

    const openModal = () => {
      if (!props.readOnly) {
        modalOpened.value = true;
      }
    }

    const closeModal = () => {
      if (!props.readOnly) {
        modalOpened.value = false;
      }
    }

    const prepareParams = () => {
      let params = props.deps.map((item) => [item, form[item]])

      params = params.filter(item => typeof item[1] !== "undefined");

      return new URLSearchParams(Object.fromEntries(params)).toString();
    };

    const loadOoptions = async () => {
      const urlParams = prepareParams();
      try {
        const response = await fetch(`/api/calculator/materials/${calculator_id.value}?${urlParams}`);
        return response.json();
      } catch (e) {
        throw Error("Can't load options list");
      }
    }

    const getOptions = async () => {
      if (!isSchemaRendered.value || !props.deps || !props.deps.length) {
        return props.options;
      } else {
        if (activeDeps.value[props.fieldSchema.formField]) {
          return activeDeps.value[props.fieldSchema.formField];
        }

        return await loadOoptions();
      }
    }

    const setValue = (material, color = null) => {
      addFieldValue(props.materialField, material.id);
      activeMaterial.value = material;

      addFieldValue(props.colorField, color ? color.id : '');
      activeColor.value = color;
    }

    const findActiveMaterial = (options) => {
      let tempActiveMaterial = undefined;

      if (form[props.materialField]) {
        options.forEach((category) => {
          if (category.items) {
            tempActiveMaterial = category.items.find((material) => material.id === form[props.materialField]);
          }
        })
        return tempActiveMaterial ?? options[0].items[0];
      }

      if (activeMaterial.value) {
        options.forEach((category) => {
          tempActiveMaterial = category.items.find((material) => material.id === activeMaterial.value.id);
        })
      }
      return tempActiveMaterial ? tempActiveMaterial : options[0].items[0];
    }

    const findActiveColor = (material) => {
      let tempActiveColor = undefined;
      if (activeColor.value && material.types.length > 1) {
        tempActiveColor = material.types.find((color) => color.id === activeColor.value.id)
      }
      return tempActiveColor ? tempActiveColor : material.types[0];
    }

    const getOptionsFromCategory = (options) => {
      let all = [];

      options.forEach(category => {
        category.items.forEach(material => {
          all.push(material);
        });
      });

      return all;
    };

    const setOptions = async () => {
      let isNewOptions = false;
      addWaitAction();
      const newOptions = await getOptions();
      delWaitAction();

      let allOptions = getOptionsFromCategory(optionsList.value);
      let allNewOptions = getOptionsFromCategory(newOptions);

      if (allOptions.length !== allNewOptions.length) {
        isNewOptions = true
      }

      if (allOptions && allOptions.length && !isNewOptions) {
        allNewOptions.some((option, index) => {
          if (option.id !== allOptions[index].id) {
            isNewOptions = true;
          }
        });
      }

      if (isNewOptions) {
        optionsList.value = newOptions;
        const newActiveMaterial = findActiveMaterial(optionsList.value);
        const newActiveColor = findActiveColor(newActiveMaterial);
        setValue(newActiveMaterial, newActiveColor);
      }
    }

    const onSubmit = (material, color) => {
      setValue(material, color);
      submitMaterial.value = material;
      closeModal();
    }

    const getDefaultOptions = async () => {
      if (calculator_id.value) {
        optionsList.value = await getOptions();
        const newActiveMaterial = findActiveMaterial(optionsList.value);
        const newActiveColor = findActiveColor(newActiveMaterial);

        if (!form[props.materialField]) {
          addFieldValue(props.materialField, newActiveMaterial.id);
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

        props.onRendered();
      }
    };

    if (props.deps) {
      watchDebounced(() => props.deps.map((item) => form[item]), async () => {

        if (calculator_id.value) {
          await setOptions();
        }
      }, {debounce: 300});
    }

    watch(activeMaterial, (newActiveMaterial) => {
      const newActiveColor = findActiveColor(newActiveMaterial);
      setValue(newActiveMaterial, newActiveColor);
    });

    watch(() => form[props.materialField], (newValue) => {
      isFindActiveMaterial.value = false;
      if (optionsList.value) {
        optionsList.value.forEach(materialCategory => {
          materialCategory.items.forEach(material => {
            if (newValue === material.id) {
              activeMaterial.value = material;
              isFindActiveMaterial.value = true;
            }
          });
        });
      }
    });

    watch(() => [isFindActiveMaterial, props.readOnly], async (newValue) => {
      if (newValue && !props.readOnly) {
        const newActiveMaterial = optionsList.value[0].items[0];
        const newActiveColor = findActiveColor(newActiveMaterial);

        addFieldValue(props.materialField, newActiveMaterial.id);
        addFieldValue(props.colorField, newActiveColor ? newActiveColor.id : '');

        activeMaterial.value = newActiveMaterial;
        activeColor.value = newActiveColor;
      }
    })

    onBeforeUpdate(async () => {
      const data = getData(props.fieldSchema.formField)

      if (data && !props.deps) {
        optionsList.value = data;
      }
    });

    watch(optionsList, newOptionList => {

      if (!newOptionList) {
        return;
      }

      newOptionList.forEach(category => {
        category.items.forEach(material => {
          if (material.id === form[props.fieldSchema.formField]) {
            activeMaterial.value = material;

            const newActiveColor = findActiveColor(material);

            addFieldValue(props.materialField, material.id);
            addFieldValue(props.colorField, newActiveColor ? newActiveColor.id : '');

            activeColor.value = newActiveColor;
            isFindActiveMaterial.value = true;
          }
        });
      });
    });

    onBeforeMount(async () => {

      await getDefaultOptions();

      if (props.fieldSchema.checks) {
        props.fieldSchema.checks.map(item => {

          watchDebounced(() => item.deps.map(formField => form[formField]), async () => {
            if (item.disable === "readOnlyItemsIn" && calculator_id.value) {

              const params = getParams(props.fieldSchema.formField, item);

              const response = await fetch(`api/calculator/check/readonly-items-in/${calculator_id.value}?${params}`);
              const data = await response.json();
              dropDisabledItemsByField(props.fieldSchema.formField);

              let readOnlyItems = [];
              if (data.data && data.result) {
                optionsList.value.forEach(category => {
                  category.items.forEach(material => {
                    if (!data.data[props.fieldSchema.formField].includes(material.id)) {
                      readOnlyItems.push(material.id);
                    }
                  });
                });

                disableItems(props.fieldSchema.formField, readOnlyItems);
              }
            }
          }, {debounce: 300});
        });
      }

      if (disabledItems) {

        watchEffect(() => {
          optionsList.value.forEach(category => {
            if (category.items) {
              category.items.forEach(material => {
                if (disabledItems.value[props.fieldSchema.formField]) {
                  material.disabled = disabledItems.value[props.fieldSchema.formField].items.includes(material.id);
                } else {
                  material.disabled = false;
                }
              });
            }
          });

          if (activeMaterial.value.disabled) {
            optionsList.value.some(category => {
              if (category.items && activeMaterial.value.disabled) {
                category.items.some(material => {
                  if (!material.disabled) {
                    activeMaterial.value = material;
                    return true;
                  }
                });
              } else {
                return true;
              }
            });
          }
        });
      }
    })

    onBeforeUnmount(() => {
      // removeField(props.materialField);
      // removeField(props.colorField);
    })

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
      isFindActiveMaterial,
      submitMaterial
    }
  }
}
</script>


<style lang="scss" scoped>
.material-field {
  width: 100%;

  &__read-only {
    opacity: 0.5;
  }
}

@media all and (min-width: 1024px) {

}
</style>
