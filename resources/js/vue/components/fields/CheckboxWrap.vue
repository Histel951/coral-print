<template>
  <CheckboxField v-if="visible && !hidden" :field-name="fieldName" :on-rendered="setRendered" :disabled="Boolean(readOnly)"
                 :checked="Number(activeChecked)" :label="fieldSchema.label" :field-schema="fieldSchema" />
</template>

<script>
import {onBeforeMount, onBeforeUnmount, ref, watchEffect} from "vue";
import useForm from "../../composables/useForm";
import useFormSchema from "../../composables/useFormSchema";
import useFieldConditions from "../../composables/useFieldConditions";
import CheckboxField from "./CheckboxField";
import useFieldConditionsHelpers from "@/composables/useFieldConditionsHelpers";
import useDisabled from "@/composables/useDisabled";

export default {
  name: "CheckboxWrap",
  components: {CheckboxField},
  props: {
    fieldSchema: Object,
    fieldName: String
  },
  setup(props) {
    const {form} = useForm();
    const activeChecked = ref(props.fieldSchema.checked);
    const {fieldIsRendered, fieldIsHidden} = useFormSchema();
    const {readOnly, visible, hidden} = useFieldConditions(props.fieldSchema.conditions, props.fieldSchema.formField, form);
    const {disabledFields} = useFieldConditionsHelpers();
    const rendered = ref(false);
    const {isDisabled, disabledDefaultValue} = useDisabled(props.fieldSchema.disableds);

    watchEffect(() => {
      if (isDisabled.value) {
        if (disabledDefaultValue.value) {
          form[props.fieldSchema.formField] = disabledDefaultValue.value;
        } else {
          delete form[props.fieldSchema.formField];
        }
      }

      readOnly.value = isDisabled.value;

      if (!visible.value) {
        delete form[props.fieldSchema.formField];
      }
    });

    const setRendered = () => {
      if (!rendered.value) {
        fieldIsRendered();
        rendered.value = true;
      }
    }

    if (!visible.value || hidden.value) {
      setRendered();
    }

    const checkReadonlyFields = () => {
      if (disabledFields.value[props.fieldSchema.formField]) {

        readOnly.value = !!disabledFields.value[props.fieldSchema.formField].conditions.filter(condition => condition.status).length;
      }
    };

    const checkActiveCheckbox = () => {
      activeChecked.value = !!form[props.fieldName];
    };

    onBeforeMount(() => {
      checkActiveCheckbox();
      checkReadonlyFields();
    });

    watchEffect(() => {
      checkActiveCheckbox();
      checkReadonlyFields();
    });

    onBeforeUnmount(() => {
      fieldIsHidden();
    });

    return {
      readOnly,
      visible,
      hidden,
      setRendered,
      activeChecked
    }
  }
}
</script>
