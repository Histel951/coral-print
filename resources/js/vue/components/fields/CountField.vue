<template>
  <div class="count-field" :style="selectStyle">
    <div v-if="showInputs" class="count-field__inputs">
      <InputField
        :field-name="countFieldName"
        :numbers-only="true"
        :displayed-value="displayedProductCount"
        :read-only="form[typesFieldName] && form[typesFieldName].length > 1"
        :on-focus-out="round" :input-styles="{
          width: fieldSchema?.width + 'px'
        }"
        :is-error="allowables[fieldSchema.formField]?.active"
        :error-message="allowables[fieldSchema.formField]?.message"
        :root="false"
      />
      <TooltipShort class="tooltip_btn" v-model="tooltipOpened" :icon-show="false" add-classes="tooltip_count"
                    :content="multipleRound?.message" :no-move-tooltip="true" />
      <div class="count-field__toggler" v-if="predefinedValues"><span @click="toggleMode">→ стандартные</span></div>
    </div>
    <SelectField v-else :root="false" field-name="product_count" :options="getData('product_count')"
                 :toggle-style="{
                    width: fieldSchema?.width + 'px'
                  }"
                 :select-style-ul="selectStyleUl"
                 :action-options="actionOptions"/>
    <div class="count-field__content" v-if="!isHideTypes">
      <div class="count-field__types">{{ typesLabel }}</div>
      <div class="count-field__types-toggler" @click="openTypes">
        <div class="count-field__types-t-text" v-if="form[typesFieldName] && form[typesFieldName].length === 1">
          <PlusIcon class="count-field__types-plus"/>
          <div class="show-mob">Вид</div>
          <div class="show-desktop">Добавить вид</div>
        </div>
        <div class="count-field__types-many-text" v-else>
          <PlusIcon class="count-field__types-plus"/>
          Виды
        </div>
      </div>
    </div>
  </div>
  <CountTypes v-if="typesOpened" :is-multiple="isMultiple" :types="form[typesFieldName]" :on-close="closeTypes"
              :on-save="saveTypes"/>
</template>

<script>
import {computed, onBeforeMount, ref, watch} from "vue";
import useRestrictions from "@/composables/useRestrictions";
import useForm from "../../composables/useForm";
import InputField from "./InputField";
import CountTypes from "./CountTypes";
import PlusIcon from "../icons/PlusIcon";
import SelectField from "@/components/fields/SelectField";
import useInitData from "@/composables/useInitData";
import TooltipShort from "@/components/fields/TooltipShort";
import {cloneDeep} from "lodash";
import useFieldsExtra from "@/composables/useFieldsExtra";
import useTypesDeclinations from "@/composables/useTypesDeclinations";

export default {
  name: "CountField",
  props: {
    selectStyle: {
      type: Object,
      default: () => {
      }
    },
    selectStyleUl: {
      type: Object,
      default: () => {
      }
    },
    fieldSchema: {
      type: Object,
      default: () => {
      }
    },
    countFieldName: String,
    typesFieldName: String,
    defaultValue: {
      type: [String, Number],
      default: 100
    },
    onRendered: Function,
    predefinedValues: Boolean,
    hideTypes: Boolean,
    actionOptionName: String,
    multipleRound: {
      type: Object,
      default: () => {
      }
    },
    isMultiple: {
      type: Boolean,
      default: false
    }
  },
  components: {TooltipShort, SelectField, PlusIcon, CountTypes, InputField},
  setup(props) {
    const {form, addFieldValue} = useForm();
    const {getExtraHideTypes, extraHideTypes} = useFieldsExtra();
    const {allowableRestriction, allowables} = useRestrictions();
    const {getData} = useInitData();
    const {declination} = useTypesDeclinations();

    const isHideTypes = ref(props.hideTypes);
    const displayedProductCount = ref(0);
    const typesOpened = ref(false);
    const showInputs = ref(!props.predefinedValues);
    const isAllowedValue = ref(false);

    const toggleMode = () => {
      showInputs.value = !showInputs.value;
    }
    const actionOptions = ref([
      {name: props.actionOptionName ?? "Свой размер", action: toggleMode}
    ]);

    const openTypes = () => {
      typesOpened.value = true;
    }

    const closeTypes = () => {
      typesOpened.value = false;
    }

    watch(() => extraHideTypes.value[props.fieldSchema.formField], () => {
      const newIsHideFields = getExtraHideTypes(props.fieldSchema.formField);

      if (newIsHideFields) {
        isHideTypes.value = newIsHideFields;
      }
    });

    const round = () => {
      if (props.multipleRound) {
        const prevNum = Math.trunc(form[props.countFieldName] / props.multipleRound.multiple) * props.multipleRound.multiple;
        const nextNum = (Math.trunc(form[props.countFieldName] / props.multipleRound.multiple) + 1) * props.multipleRound.multiple;
        const oldValue = form[props.countFieldName];
        form[props.countFieldName] = ((+form[props.countFieldName] - prevNum) > (nextNum - +form[props.countFieldName])) || !prevNum ? nextNum : prevNum;
        if (form[props.countFieldName] !== oldValue) {
          tooltipOpened.value = true;
          setTimeout(() => tooltipOpened.value = false, 3000)
        }
      }
    }

    watch(() => form[props.countFieldName], newValue => {
      const isActive = newValue > 0;
      allowableRestriction([props.fieldSchema.formField], "Укажите количество продуктов, минимально 1.", !isActive);
      isAllowedValue.value = !isActive;
    });

    const typesLabel = computed(() => {
      return `${declination(form[props.typesFieldName]?.length, true)}`;
    })

    const tooltipOpened = ref(false);

    onBeforeMount(() => {
      addFieldValue(props.countFieldName, props.defaultValue);
      addFieldValue(props.typesFieldName, [props.defaultValue]);
      props.onRendered();
    })

    const setFirstType = (event) => {
      addFieldValue(props.typesFieldName, [+event.target.value]);
    }

    const saveTypes = (newTypes) => {
      addFieldValue(props.typesFieldName, newTypes);

      if (!props.isMultiple) {
        addFieldValue(props.countFieldName, newTypes.reduce((a, b) => a + b, 0));
      }

      if (props.isMultiple && newTypes.length > 1) {
        displayedProductCount.value = newTypes.length * form.product_count;
      } else if (props.isMultiple) {
        displayedProductCount.value = 0;
      }
    }

    onBeforeMount(() => {
      if (props.isMultiple) {
        watch(() => form.product_count, newProductCount => {
          if (!form[props.typesFieldName]) {
            return;
          }

          const allTypes = cloneDeep(form[props.typesFieldName]);

          Object.keys(allTypes).forEach(key => {
            allTypes[key] = newProductCount;
          });

          saveTypes(allTypes);
        });
      }
    })

    return {
      form,
      typesLabel,
      openTypes,
      closeTypes,
      typesOpened,
      saveTypes,
      setFirstType,
      getData,
      showInputs,
      actionOptions,
      toggleMode,
      round,
      tooltipOpened,
      displayedProductCount,
      isHideTypes,
      allowables,
      isAllowedValue
    }
  }
}
</script>


<style lang="scss" scoped>
.count-field {
  display: flex;
  align-items: center;

  &__types-many-text {
    cursor: pointer;
    display: flex;
    flex-direction: row;
    align-items: center;
  }

  &__content {
    margin: 0 0 0 8px;
  }

  &__types {
    font-size: 15px;
    line-height: 130%;
  }

  &__types-toggler {
    display: flex;
    align-items: center;
    font-size: 14px;
    line-height: 120%;
    color: #007DEB;
  }

  &__types-t-text {
    cursor: pointer;
    display: flex;
    align-items: center;
  }

  &__types-plus {
    margin: 0 5px 0 0;
  }

  &__inputs {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
  }

  &__toggler {
    width: max-content;
    font-size: 15px;
    line-height: 30px;
    margin: 0 0 0 8px;

    span {
      color: #007DEB;
      cursor: pointer;

      &:hover {
        text-decoration: underline;
      }
    }
  }
}

.show-desktop {
  display: none;
}

@media all and (max-width: 768px) {
  .count-field {
    &__content {
      display: flex;
      align-items: center;
      white-space: nowrap;
      width: max-content;
    }

    &__types {
      margin-right: 8px;
    }
  }
}

@media all and (min-width: 768px) {
  .count-field {
    &__content {
      display: flex;
      align-items: center;
      white-space: nowrap;
    }

    &__types-toggler {
      margin: 0 0 0 30px;
    }
  }
}


@media all and (min-width: 1024px) {

  .count-field {
    &__types-toggler {
      cursor: pointer;
      font-size: 15px;
      line-height: 130%;
    }
  }
}

@media all and (min-width: 1100px) {
  .show-mob {
    display: none;
  }
  .show-desktop {
    display: block;
  }
}

</style>
