<template>
  <div class="radio-btns">
    <label v-for="option in options" class="radio-btn" :for="option.id" :key="option.id">
      <input type="radio" :id="option.id" :value="option.id" v-model="form[fieldName]"/>
      <span>{{ option.name }}</span>
    </label>
  </div>
</template>

<script>
import {onBeforeMount} from "vue";
import useForm from "../../composables/useForm";

export default {
  name: "RadioBtnField",
  props: {
    fieldName: String,
    aditionalClass: String,
    options: Array,
    onRendered: Function,
    root: {
      types: Boolean,
      default: true
    }
  },
  setup(props) {
    const {form, addFieldValue} = useForm();

    if (props.root) {
      onBeforeMount(() => {
        addFieldValue(props.fieldName, props.options[0].id);

        if (props.root) {
          props.onRendered();
        }
      })

      // onBeforeUnmount(() => {
//        removeField(props.fieldName);
//      })
    }

    return {
      form
    }
  }
}
</script>


<style lang="scss" scoped>
.radio-btns {
  display: flex;
  width: 100%;
}

.radio-btn {
  position: relative;
  flex: 1 1 50%;
  height: 32px;

  + .radio-btn {
    margin: 0 0 0 16px;
  }

  span {
    font-family: "Euclid Circular B", Arial, Tahoma, sans-serif;
    border: 1px solid #CCCCCC;
    box-sizing: border-box;
    border-radius: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 44px;
    padding: 5px 16px;
    font-weight: 500;
    font-size: 16px;
    line-height: 120%;
    color: #00195A;
    text-align: center;
  }

  input {
    width: 0;
    height: 0;
    opacity: 0;
    position: absolute;
    left: 0;
    top: 0;

    &:checked {
      + span {
        background: #007DEB;
        border-color: #007DEB;
        color: #fff;
      }
    }
  }

}

@media all and (min-width: 768px) {
  .radio-btns {
    width: auto;
  }
  .radio-btn {
    span {
      white-space: nowrap;
      height: 32px;
    }
  }
}

@media all and (min-width: 1024px) {
  .radio-btn {
    cursor: pointer;
  }
}
</style>
