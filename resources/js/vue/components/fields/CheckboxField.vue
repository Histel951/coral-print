<template>
  <div class="checkbox_container">
    <label class="checkbox" :class="{'checkbox_disabled': disabled}">
      <input type="checkbox" :id="fieldName" v-model="form[fieldName]" :disabled="disabled" :true-value="1"
             :false-value="0"/>
      <span class="checkbox__box"></span>
      <span class="checkbox__text" :class="{'checkbox__dashed': issetTooltip()}" @click="toggleTooltip($event)">{{ label }}</span>
    </label>
    <div class="tooltip_container" v-if=" issetTooltip()">
      <TooltipShort class="tooltip_btn" v-model="tooltipOpened"
                    v-if="issetTooltip() && getTooltip(fieldSchema.name)?.type === 'short'"
                    :content="getTooltip(fieldSchema.name)?.content"/>
    </div>
  </div>
</template>

<script>
import {onBeforeMount, ref} from "vue";
import useForm from "../../composables/useForm";
import TooltipShort from "@/components/fields/TooltipShort";
import useTooltips from "@/composables/useTooltips";
import onClickOutside from "vue-click-outside-hook";

export default {
  name: "CheckboxField",
  components: {
    TooltipShort
  },
  props: {
    fieldSchema: {
      type: Object,
      default: () => {}
    },
    fieldName: String,
    label: String,
    onRendered: Function,
    disabled: {
      type: Boolean,
      default: false
    },
    checked: {
      type: Number,
      default: 0
    },
    root: {
      types: Boolean,
      default: true
    },
  },

  setup(props) {
    const {form, addFieldValue} = useForm();
    const {tooltips, getTooltip} = useTooltips();
    const issetTooltip = () => tooltips && getTooltip(props.fieldSchema.name);
    const tooltipOpened = ref(false);

    onClickOutside(() => {
      tooltipOpened.value = false;
    });

    const toggleTooltip = (e) => {
      tooltipOpened.value = !tooltipOpened.value;
      e.preventDefault();
    }

    if (props.root) {
      onBeforeMount(() => {
        addFieldValue(props.fieldName, props.checked);
        props.onRendered();
      })

      // onBeforeUnmount(() => {
//        removeField(props.fieldName);
//      })
    }

    return {
      form,
      toggleTooltip,
      issetTooltip,
      tooltipOpened,
      getTooltip
    }
  }
}
</script>


<style lang="scss" scoped>
.checkbox_container:first-child {
  margin-left: 0;
}

.checkbox_container {
  margin-left: 20px;
}

.tooltip_btn {
  font-weight: 600;
  line-height: 115%;
  font-size: 14px;
}

.tooltip_container {
  margin-top: 2px;
  position: relative;
}

.checkbox {
  display: inline-flex;
  align-items: center;
  font-weight: 600;
  font-size: 15px;
  line-height: 115%;

  &__text {
    white-space: nowrap;
  }

  &_container {
    display: flex;
  }

  &__dashed {
    border-bottom: 1px dashed #6e6e6e;
    padding-bottom: 2px;
    width: min-content;
  }

  &_disabled {
    opacity: 0.5;
  }

  input {
    display: block;
    opacity: 0;
    width: 0;
    height: 0;
    border: 0;
    background: 0;

    &:checked + span {
      background: #007DEB;
      border-color: #007DEB;
    }
  }

  &__box {
    width: 24px;
    height: 24px;
    flex: 0 0 auto;
    background: #FFFFFF;
    border: 1px solid #CCCCCC;
    box-sizing: border-box;
    border-radius: 3px;
    margin: 0 8px 0 0;
    display: flex;
    align-items: center;
    justify-content: center;

    &:before {
      content: '';
      background-image: url("data:image/svg+xml,%3Csvg width='17' height='13' viewBox='0 0 17 13' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M6.02124 13L0.130615 7.10938L2.26343 4.97656L6.02124 8.63281L14.6541 0L16.7869 2.13281L6.02124 13Z' fill='white'/%3E%3C/svg%3E%0A");
      width: 17px;
      height: 13px;
      flex: 0 0 auto;
    }
  }
}

@media all and (max-width: 480px) {
  .checkbox_container:first-child {
    margin-left: 0;
    padding-bottom: 8px;
    padding-top: 8px;
  }

  .checkbox_container {
    border-top: 1px solid #E4E4E4;
    margin-left: 0;
    padding-bottom: 8px;
    padding-top: 8px;
  }

  .checkbox {
    white-space: nowrap;
  }
}

@media all and (min-width: 768px) {
  .radio-btns {
    width: auto;
  }
  .radio-btn {
    span {
      white-space: nowrap;
      height: 40px;
    }
  }
  .checkbox__dashed {
    width: auto;
  }
}
</style>
