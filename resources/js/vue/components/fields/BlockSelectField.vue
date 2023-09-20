<template>
  <div class="calc-block-select">
    <div class="calc-block-select__selects">

      <div class="calc-block-select__selects-container">
        <div
          v-for="option in optionsList"
          :key="option.id"
          :class="{
              'calc-block-select__select-item__active': option.active,
              'calc-block-select__select-item': true
            }"
          @click="setActiveOption(option)"
        >
          <span class="calc-block-select__select-item__name">{{ option.name }}</span>
        </div>
      </div>

      <div
        v-if="optionActive.fields.length > 0"
        class="calc-block-select__fields"
      >
        <Field
          v-for="field in optionActive.fields"
          :key="`${field.label}${field.type}`"
          :field-schema="field"
          :is-block-select="true"
          :disabled-fields="disabledFields"
        />
      </div>

      <div v-if="optionActive.checkboxes.length" class="calc-content__checkboxes">
        <div v-for="chunk in Math.ceil(optionActive.checkboxes.length / 2)" :key="'chunk-'+chunk+schemaIndex" class="checkbox-line">
          <CheckboxWrap v-for="checkbox in optionActive.checkboxes.slice((chunk - 1) * 2, chunk * 2)" :field-schema="checkbox"
                        :key="`${checkbox.label}${schemaIndex}`" :field-name="checkbox.formField"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import useFormSchema from "../../composables/useFormSchema";
import {defineAsyncComponent, onBeforeMount, onBeforeUnmount, onBeforeUpdate} from "vue";
import CheckboxWrap from "@/components/fields/CheckboxWrap";
import useBlockSelect from "@/composables/useBlockSelect";
import useFieldConditionsHelpers from "@/composables/useFieldConditionsHelpers";
import useFieldsExtra from "@/composables/useFieldsExtra";

const Field = defineAsyncComponent(
  () => import('./../fields/Field')
);

export default {
  name: "BlockSelectField",
  components: {
    Field,
    CheckboxWrap
  },
  props: {
    options: Array,
    fieldName: String,
    onRendered: Function,
    readOnly: {
      types: Boolean,
      default: false
    },
  },
  setup(props) {
    const {schemaIndex, fields} = useFormSchema();
    const {setExtraLabel} = useFieldsExtra();
    const {onMountDefaultOptions, setActiveOption, setOptions, optionsList, optionActive} = useBlockSelect();
    const {disabledFields} = useFieldConditionsHelpers();

    setOptions(props.options)
    setActiveOption(optionsList.value[0]);

    onMountDefaultOptions(() => {
      props.onRendered();
    });

    onBeforeUnmount(() => {
      optionActive.value = {};
    });

    const setFieldDefaultOptions = () => {
      const blockField = fields.value.find(field => field.formField === props.fieldName);

      if (blockField?.fields) {
        Object.keys(blockField?.fields)?.forEach(formField => {
          if (blockField.fields[formField]?.label) {
            setExtraLabel(blockField.fields[formField]?.label, formField);
          }
        });
      }
    };

    onBeforeMount(() => setFieldDefaultOptions());
    onBeforeUpdate(() => setFieldDefaultOptions());

    return {
      optionsList,
      optionActive,
      setActiveOption,
      schemaIndex,
      disabledFields
      // Field
    };
  }
}
</script>

<style scoped lang="scss">

.checkbox-line {
  border-top: 1px solid #E4E4E4;
  padding: 12px 0;
  display: flex;
}

@media all and (max-width: 480px) {
  .checkbox-line {
    flex-direction: column;
    border: none;
    padding: 0;
  }
}

.calc-block-select {
  width: 100%;

  &__selects {
    width: 100%;
    display: inline-block;
  }

  &__selects-container {
    display: flex;
    justify-content: flex-start;
    border-bottom: 1px solid #E4E4E4;
    padding-top: 20px;
  }

  &__select-item:first-child {
    margin-left: 0;
  }

  &__select-item {
    width: auto;
    padding: 4px 0 4px 0;
    text-align: center;
    line-height: 22px;
    cursor: pointer;
    margin-left: 24px;

    &__active {
      color: #007DEB;
      border-bottom: 3px solid #007DEB;
    }

    &__name {
      font-family: 'Euclid Circular B';
      font-weight: 500;
      size: 17px;
    }
  }
}

</style>
