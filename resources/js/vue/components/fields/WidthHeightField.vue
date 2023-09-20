<template>
  <div class="w-h">
    <transition name="fade">
      <div v-if="tooltipOpened" class="tooltip__container" ref="tooltipContainer">
          <TooltipShortContent :tooltip-opened="tooltipOpened" :content="errorMessage" />
      </div>
    </transition>
    <div class="fields-container" ref="fieldsContainer">
      <div class="w-h__inputs" v-if="showInputs">
        <div class="w-h__input"
             :class="{
              'w-h__input__error': isError
            }">
          <InputField
            :field-name="widthFieldName"
            :ref="ref => input1 = ref"
            :root="false"
            :default-value="defaultWidth"
          />
        </div>
        <div class="w-h__sep">✗</div>
        <div class="w-h__input"
             :class="{
              'w-h__input__error': isError
            }">
          <InputField
            :field-name="heightFieldName"
            :root="false"
            :default-value="defaultHeight"
          />
        </div>
        <div class="w-h__text">мм</div>
        <div class="w-h__toggler" v-if="predefinedValues"><span @click="toggleMode">→ стандартные</span></div>
      </div>
      <SelectField :is-not-actions="isNotActions" :is-error="isError" v-else :root="false" field-name="width-height" :options="optionsList" :alt-select-handler="updateValue"
                   :action-options="actionOptions" :is-scrolling="isScrolling"/>
    </div>
  </div>
</template>

<script>
import {onBeforeMount, ref, watch, watchEffect} from "vue";
import useForm from "../../composables/useForm";
import SelectField from "./SelectField";
import InputField from "./InputField";
import useInitData from "../../composables/useInitData";
import TooltipShortContent from "@/components/fields/TooltipShortContent";
import {computePosition} from "@floating-ui/dom";
import useFieldConditionsHelpers from "@/composables/useFieldConditionsHelpers";
import useFieldsExtra from "@/composables/useFieldsExtra";

export default {
  name: "WidthHeightField",
  props: {
    fieldName: String,
    widthFieldName: String,
    heightFieldName: String,
    defaultHeight: Number,
    defaultWidth: Number,
    predefinedValues: Boolean,
    options: {
      type: Array,
      default: () => []
    },
    isNotActions: {
      type: Boolean,
      default: false
    },
    onRendered: Function,
    errorMessage: {
      type: String,
      default: ''
    },
    isError: {
      type: Boolean,
      default: false
    },
    isScrolling: {
      type: Boolean,
      default: true
    }
  },
  components: {TooltipShortContent, SelectField, InputField},
  setup(props) {
    const {addFieldValue, form} = useForm();
    const {disabledActions} = useFieldConditionsHelpers();
    const showInputs = ref(!props.predefinedValues);
    const {getData} = useInitData();
    const tooltipOpened = ref(false);
    const tooltipContainer = ref(null);
    const fieldsContainer = ref(null);
    const input1 = ref(null);
    const optionsList = ref(props.options);
    const {extraPredefinedValue} = useFieldsExtra();

    watchEffect(() => {
      if (typeof extraPredefinedValue.value[props.fieldName] !== 'undefined') {
        showInputs.value = !extraPredefinedValue.value[props.fieldName];
      }
    });

    const toggleMode = () => {
      showInputs.value = !showInputs.value;
    }

    const actionOptions = ref([
      {name: "Свой размер", action: toggleMode}
    ]);

    watchEffect(() => {
      if (disabledActions.value[props.fieldName]) {
        actionOptions.value = [];
      }
    });

    const updateValue = (option) => {
      addFieldValue(props.widthFieldName, option.width);
      addFieldValue(props.heightFieldName, option.height);
    }

    const changeTooltipPosition = () => {
      if (fieldsContainer.value && tooltipContainer.value) {
        computePosition(fieldsContainer.value, tooltipContainer.value, {
          placement: 'top'
        }).then(({x, y, strategy}) => {
          Object.assign(tooltipContainer.value.style, {
            position: strategy,
            left: `${x + (input1.value?.fieldsContainer.offsetWidth / 4)}px`,
            top: `${y + 20}px`,
          })
        });
      }
    };

    watch(() => [props.isError, form[props.heightFieldName], form[props.widthFieldName]], ([newValue]) => {
      tooltipOpened.value = newValue;
    });

    onBeforeMount(async () => {
      if (optionsList.value && props.predefinedValues) {
        optionsList.value = getData('width-height');
      }

      addFieldValue(props.widthFieldName, props.defaultWidth || 100);
      addFieldValue(props.heightFieldName, props.defaultHeight || 100);
      props.onRendered();
    })

    watchEffect(() => changeTooltipPosition());

    return {
      getData,
      showInputs,
      updateValue,
      actionOptions,
      toggleMode,
      tooltipContainer,
      fieldsContainer,
      tooltipOpened,
      input1,
      optionsList
    }
  }
}
</script>


<style lang="scss" scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .2s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

.w-h {
  flex: 1 1 100%;

  &__inputs {
    display: flex;
    align-items: center;
    flex-flow: row wrap;
  }

  &__toggler {
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

  &__input {
    //width: 50px;
    transition: 0.2s;

    &__error {
      border: 1px solid #eb444c;
      transition: 0.2s;
      border-radius: 4px;
    }
  }

  &__sep {
    font-size: 15px;
    line-height: 130%;
    margin: 0 8px;
  }

  &__text {
    font-size: 15px;
    line-height: 130%;
    margin: 0 0 0 8px;
  }
}

@media all and (min-width: 500px) {
  .w-h {
    &__input {
      //width: 64px;
    }
  }
}

@media all and (min-width: 1024px) {

}
</style>
