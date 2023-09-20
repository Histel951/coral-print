<template>
  <div v-if="visible && !hidden && fieldSchema.type !== 'custom'" class="calc-field"
       :style="{
          'border-top': !topLine ? 'none' : '1px solid #E4E4E4'
       }"
       :class="`calc-field_${fieldSchema.type}`"
  >
    <FieldLabel v-if="label" aditional-class="calc-field__label" :info="fieldSchema.info"
                :label-text="label"
                :label-inner-text="fieldSchema.labelInnerText"
                :field-schema="fieldSchema"
                :field-name="isBlockSelect ? fieldSchema.name : fieldSchema.formField"
    />
    <div class="calc-field__content">
      <InputField v-if="fieldSchema.type==='input'"
                  :input-styles="{width: fieldSchema?.width + 'px'}"
                  :is-error="restrictions[fieldSchema.formField]?.active"
                  :error-message="restrictions[fieldSchema.formField]?.message"
                  :field-name="fieldSchema.formField" :on-rendered="setRendered"
                  :default-value="fieldSchema.default" :numbers-only="fieldSchema.numbersOnly"
                  :read-only="Boolean(fieldReadOnly)"
      />
      <MaterialField v-else-if="fieldSchema.type==='material'" :material-field="fieldSchema.formField"
                     :color-field="fieldSchema.formColorField" :on-rendered="setRendered" :read-only="Boolean(fieldReadOnly)"
                     :deps="fieldSchema.deps" :url="fieldSchema.url" :options="options" :field-schema="fieldSchema"
                     :is-block-select="isBlockSelect"
      />
      <RadioMaterialField v-else-if="fieldSchema.type==='radio-material'"
                          :material-field="fieldSchema.formMaterialField"
                          :color-field="fieldSchema.formColorField" :on-rendered="setRendered"
                          :label="label"
                          :deps="fieldSchema.deps" :url="fieldSchema.url" :options="options"
                          :read-only="Boolean(fieldReadOnly)"/>
      <CountField v-else-if="fieldSchema.type==='count'"
                  :is-multiple="fieldSchema?.isMultiple"
                  :select-style="{width: fieldSchema?.width + 'px'}"
                  :field-schema="fieldSchema"
                  :multiple-round="fieldSchema.multipleRound"
                  :count-field-name="fieldSchema.formCountField"
                  :types-field-name="fieldSchema.formTypesField" :on-rendered="setRendered"
                  :default-value="fieldSchema.default" :predefined-values="fieldSchema.predefinedValues"
                  :hide-types="fieldSchema.hideTypes" :action-option-name="fieldSchema.actionOptionName"
                  :select-style-ul="{width: fieldSchema?.widthUl + 'px'}"
      />
      <RadioBtnField v-else-if="fieldSchema.type==='radio-btns'" :field-name="fieldSchema.formField"
                     :on-rendered="setRendered"
                     :options="options"/>
      <SelectField v-else-if="fieldSchema.type==='select'"
                   :field-name="fieldSchema.formField"
                   :is-use-value="fieldSchema?.isUseValue"
                   :on-rendered="setRendered" :options="options"
                   :deps="fieldSchema.deps" :url="fieldSchema.url" :read-only="Boolean(fieldReadOnly)"
                   :post-text-icon="fieldSchema?.postNameIcon"
                   :is-not-use-post-name-icon="fieldSchema?.isNotUsePostNameIcon"
                   :is-not-use-post-name-text="fieldSchema?.isNotUsePostNameText"
                   :is-not-use-post-text-icon="Boolean(fieldSchema?.isNotUsePostTextIcon)"
                   :select-style="{width: fieldSchema?.width + 'px'}"
                   :select-style-dropdown="{padding: fieldSchema?.paddingDropdown}"
                   :selectStyleUl="{width: fieldSchema?.widthUl + 'px'}"
      />
      <WidthHeightField v-else-if="fieldSchema.type==='width-height'"
                        :field-name="fieldSchema.formField"
                        :on-rendered="setRendered"
                        :is-not-actions="fieldSchema?.isNotActions"
                        :is-error="restrictions[fieldSchema.formField]?.active"
                        :error-message="restrictions[fieldSchema.formField]?.message"
                        :width-field-name="fieldSchema.formWidthField" :default-height="fieldSchema.defaultHeight"
                        :default-width="fieldSchema.defaultWidth" :height-field-name="fieldSchema.formHeightField"
                        :predefined-values="fieldSchema.predefinedValues" :is-scrolling="fieldSchema.isScrolling"
                        :options="getData('width-height')"
      />

      <RadioCheckBtnField
        v-else-if="fieldSchema.type === 'radio-check-btn'"
        :on-rendered="setRendered"
        :field-name="fieldSchema.formField"
        :read-only="Boolean(fieldReadOnly)"
        :options="options"
      />

      <BlockSelectField
        v-if="fieldSchema.type === 'block_select'"
        :read-only="Boolean(fieldReadOnly)"
        :on-rendered="setRendered"
        :field-name="fieldSchema.formField"
        :options="options"
      />

      <SelectColorField
        :select-style="{width: fieldSchema?.width + 'px'}"
        v-else-if="fieldSchema.type==='select-color'"
        :is-use-value="fieldSchema?.isUseValue"
        :field-name="fieldSchema.formField"
        :on-rendered="setRendered"
        :options="options"
        :deps="fieldSchema.deps"
        :url="fieldSchema.url"
        :read-only="Boolean(fieldReadOnly)"
        :default-id="fieldSchema.defaultId"
      />

      <SelectCategory
        v-else-if="fieldSchema.type === 'select-category'"
        :field-name="fieldSchema.formField"
        :name="fieldSchema.name"
        :is-use-value="fieldSchema?.isUseValue"
        :on-rendered="setRendered" :options="options"
        :deps="fieldSchema.deps" :url="fieldSchema.url" :read-only="Boolean(fieldReadOnly)"
        :post-text-icon="fieldSchema?.postNameIcon"
      />

      <ColorfulField
        v-else-if="fieldSchema.type === 'select-material-many-additional'"
        :field-name="fieldSchema.formField"
        :options="getData(fieldSchema.formField).colors"
        :paints="Object.values(getData(fieldSchema.formField).paints)"
        :label="label"
        :color-field="fieldSchema.formField"
        :color-item-field="fieldSchema.formPaintField"
        :on-rendered="setRendered"
        :is-disabled-custom="fieldSchema?.is_disabled_custom"
        :is-disabled="Boolean(fieldSchema?.is_disabled)"
        :is-not-custom="fieldSchema?.isNotCustom"
      />

      <HorizontalMaterialField
        v-else-if="fieldSchema.type === 'select-horizontal-modal'"
        :field-name="fieldSchema.formField"
        :options="getData(fieldSchema.formField)"
        :label="fieldSchema.label_title"
        :on-rendered="setRendered"
      />

      <div v-if="fieldSchema.postText" class="calc-field__post-text">
        {{ fieldSchema.postText }}
      </div>
    </div>
  </div>
</template>

<script>
import FieldLabel from "./FieldLabel";
import InputField from "./InputField";
import SelectField from "./SelectField";
import useInitData from "../../composables/useInitData";
import WidthHeightField from "./WidthHeightField";
import RadioBtnField from "./RadioBtnField";
import {onBeforeMount, onBeforeUnmount, onBeforeUpdate, ref, watch, watchEffect} from "vue";
import useFormSchema from "../../composables/useFormSchema";
import CountField from "./CountField";
import MaterialField from "./MaterialField";
import RadioMaterialField from "./RadioMaterialField";
import useFieldConditions from "../../composables/useFieldConditions";
import useForm from "../../composables/useForm";
import BlockSelectField from "@/components/fields/BlockSelectField";
import RadioCheckBtnField from "@/components/fields/RadioCheckBtnField";
import SelectColorField from "@/components/fields/SelectColorField";
import useFieldConditionsHelpers from "@/composables/useFieldConditionsHelpers";
import useRestrictions from "@/composables/useRestrictions";
import {watchDebounced} from "@vueuse/core";
import useCheck from "@/composables/useCheck";
import cloneDeep from "lodash/cloneDeep";
import useDisabled from "@/composables/useDisabled";
import SelectCategory from "@/components/fields/SelectCategory";
import ColorfulField from "@/components/fields/ColorfulField";
import HorizontalMaterialField from "@/components/fields/HorizontalMaterialField";
import useFieldsExtra from "@/composables/useFieldsExtra";

export default {
  name: "Field",
  props: {
    topLine: {
      type: Boolean,
      default: true
    },
    fieldSchema: Object,
    isBlockSelect: {
      type: Boolean,
      default: false
    },
    disabledFields: {
      type: Object,
      default: () => {}
    }
  },
  components: {
    HorizontalMaterialField,
    ColorfulField,
    SelectCategory,
    SelectColorField,
    RadioCheckBtnField,
    BlockSelectField,
    RadioMaterialField,
    MaterialField,
    CountField,
    RadioBtnField,
    WidthHeightField,
    SelectField,
    InputField,
    FieldLabel,
  },
  setup(props) {
    const {getData} = useInitData();
    const rendered = ref(false);
    const {fieldIsRendered, fieldIsHidden, calculator_id} = useFormSchema();
    const {form} = useForm();
    const {disabledFields} = useFieldConditionsHelpers();
    const options = ref({});
    const error = ref(false);
    const {getParams} = useCheck();
    const {restrictions} = useRestrictions();
    const fieldReadOnly = ref(false);
    const checkReadonly = ref(false);
    const {isDisabled, disabledDefaultValue} = useDisabled(props.fieldSchema.disableds);
    const {getExtraLabel, extraLabels} = useFieldsExtra();
    const label = ref(props.fieldSchema.label);

    const {
      readOnly,
      visible,
      hidden
    } = useFieldConditions(props.fieldSchema.conditions, props.fieldSchema.formField, form);

    const setRendered = () => {
      if (!rendered.value) {
        fieldIsRendered();
        rendered.value = true;
      }
    }

    watch(() => [readOnly.value, checkReadonly.value], ([newReadOnly, newCheckReadOnly]) => {
      fieldReadOnly.value = cloneDeep(newReadOnly);

      if (!newReadOnly) {
        fieldReadOnly.value = cloneDeep(newCheckReadOnly);
      }
    });

    watchEffect(() => {
      const extraLabel = getExtraLabel(props.fieldSchema.formField);

      if (extraLabel) {
        label.value = extraLabel;
      }
    });

    if (!visible.value || hidden.value) {
      setRendered();
    }

    const checkReadonlyFields = () => {
      if (disabledFields.value[props.fieldSchema.formField]) {

        readOnly.value = !!disabledFields.value[props.fieldSchema.formField].conditions.filter(
          condition => condition.status
        ).length;
      } else {
        readOnly.value = false;
      }
    };

    onBeforeMount(() => {
      options.value = getData(props.fieldSchema.formField);

      watchEffect(() => {
        if (isDisabled.value) {
          if (disabledDefaultValue.value) {
            form[props.fieldSchema.formField] = disabledDefaultValue.value;
          } else {
            delete form[props.fieldSchema.formField];
          }
        }

        readOnly.value = isDisabled.value;
      });

      if (props.fieldSchema.checks) {
        props.fieldSchema.checks.map(item => {

          watchDebounced(() => item.deps.map(formField => form[formField]), async () => {
            setTimeout(async () => {
              if (readOnly.value) {
                return;
              }

              if (item.disable === "readOnly" && calculator_id.value) {

                const params = getParams(props.fieldSchema.formField, item);

                const response = await fetch(`api/calculator/check/readonly/${calculator_id.value}?${params}`);
                const data = await response.json();

                if (data) {
                  checkReadonly.value = Number(data.result);

                  if (props.fieldSchema.default && readOnly.value) {
                    form[props.fieldSchema.formField] = props.fieldSchema.default;
                  }
                }
              }
            }, 300);
          }, {debounce: 300});
        });
      }

      checkReadonlyFields();
    });

    watchEffect(() => {
      checkReadonlyFields();
    })

    onBeforeUpdate(() => {
      options.value = getData(props.fieldSchema.formField);
    });

    onBeforeUnmount(() => {
      delete extraLabels.value[props.fieldSchema.formField];
      if (props.fieldSchema.type !== 'custom') {
        fieldIsHidden();
      }

    })

    return {
      getData,
      setRendered,
      options,
      fieldReadOnly,
      visible,
      hidden,
      restrictions,
      error,
      label
    }
  }
}
</script>

<style lang="scss" scoped>
.calc-field:first-child {
  border-top: none !important;
}

.calc-field {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  padding: 8px 0;

  &_block_select {
    padding: 0;
  }

  &_radio-btns {
    padding: 8px 0;

    + .calc-field {
      border-top: none;
    }
  }

  &__content {
    flex: 1 1 1px;
    min-width: 0;
    display: flex;
    align-items: center;
  }

  &__label {
    margin: 0 8px 0 0;
  }

  &__post-text {
    font-weight: normal;
    font-size: 15px;
    line-height: 130%;
    margin: 0 0 0 8px;
  }

  &_count {
    .calc-field__content {
      flex: 1 1 100%;
      display: block;
    }
  }
}
</style>
