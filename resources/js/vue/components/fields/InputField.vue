<template>
  <transition name="fade">
    <div v-if="tooltipOpened" class="tooltip__container" ref="tooltipContainer">
      <TooltipShortContent :tooltip-opened="tooltipOpened" :content="errorMessage" />
    </div>
  </transition>
  <div ref="fieldsContainer">
    <input
      v-if="displayedValue"
      :style="inputStyles"
      ref="inputRef"
      v-model="displayedValueRef"
      class="input-field"
      :class="{
        'input-field__error': isError
      }"
      :readonly="readOnly"
      @focusout="onFocusOut"
    />
    <input
      v-if="numbersOnly && !displayedValue"
      :style="inputStyles"
      ref="inputRef"
      v-model.number="form[fieldName]"
      type="number"
      :min="0"
      @keypress="checkVal"
      class="input-field input-field__number"
      :class="{
        'input-field__error': isError
      }"
      :readonly="readOnly"
      @focusout="onFocusOut"
    >
    <input
      v-else-if="!displayedValue"
      :style="inputStyles"
      ref="inputRef"
      v-model="form[fieldName]"
      class="input-field"
      :class="{
        'input-field__error': isError
      }"
      :readonly="readOnly"
    >
  </div>
</template>

<script>

import {onBeforeMount, ref, watch, watchEffect} from "vue";
import useForm from "../../composables/useForm";
import onClickOutside from "vue-click-outside-hook";
import TooltipShortContent from "@/components/fields/TooltipShortContent";
import {computePosition} from "@floating-ui/dom";

export default {
  name: "InputField",
  components: {TooltipShortContent},
  props: {
    displayedValue: [String, Number],
    isError: {
      type: Boolean,
      default: false
    },
    errorMessage: {
      type: String,
      default: ''
    },
    inputStyles: {
      type: Object,
      default: () => {}
    },
    fieldName: String,
    defaultValue: [String, Number],
    numbersOnly: Boolean,
    readOnly: {
      type: Boolean,
      default: false
    },
    onRendered: Function,
    root: {
      types: Boolean,
      default: true
    },
    onFocusOut: {
      type: Function,
      default: () => () => {}
    },
    components: {TooltipShortContent}
  },
  setup(props) {
    const {form, addFieldValue} = useForm();
    const tooltipOpened = ref(false);
    const fieldsContainer = ref(null);
    const tooltipContainer = ref(null);
    const displayedValueRef = ref(props.displayedValue);
    const inputRef = ref(null);

    watchEffect(() => {
      displayedValueRef.value = props.displayedValue;
    });

    onClickOutside(() => {
      if (props.isError) {
        tooltipOpened.value = false;
      }
    });

    watch(() => [props.isError, form[props.fieldName]], ([newValue]) => {
      tooltipOpened.value = newValue;
    });

    const changeTooltipPosition = () => {
      if (fieldsContainer.value && tooltipContainer.value) {
        computePosition(fieldsContainer.value, tooltipContainer.value, {
          placement: 'top-start'
        }).then(({x, y, strategy}) => {
          Object.assign(tooltipContainer.value.style, {
            position: strategy,
            left: `${x + (inputRef.value.offsetWidth / 4  - 8)}px`,
            top: `${y + 20}px`,
          })
        });
      }
    };

    watchEffect(() => changeTooltipPosition());

    if (props.root) {
      onBeforeMount(() => {
        addFieldValue(props.fieldName, props.defaultValue);
        props.onRendered();
      })

      // onBeforeUnmount(() => {
//        removeField(props.fieldName);
//      })
    }

    const checkVal = (event) => {
      if (isNaN(Number(event.key)) || event.key === ' ') {
        event.preventDefault();
      }
    }

    return {
      form,
      checkVal,
      tooltipOpened,
      fieldsContainer,
      tooltipContainer,
      inputRef,
      displayedValueRef
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

.input-field {
  background: #FFFFFF;
  border: 1px solid #CCCCCC;
  box-sizing: border-box;
  box-shadow: inset 0 2px 4px rgba(30, 30, 30, 0.15);
  border-radius: 4px;
  width: 64px;
  height: 40px;
  padding: 0 10px;
  font-size: 15px;
  line-height: 120%;
  outline: none;
  &:read-only {
    cursor: default;
    opacity: 0.5;
    &:focus {
      outline: none;
    }
  }

  &__error {
    border: 1px solid #eb444c;
    transition: 0.2s;
  }

  &__number::-webkit-inner-spin-button,
  &__number::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
    -moz-appearance: textfield;
  }
}

@media all and (min-width: 1024px) {
  .input-field {
    width: 64px;
    height: 32px;
  }
}

</style>
