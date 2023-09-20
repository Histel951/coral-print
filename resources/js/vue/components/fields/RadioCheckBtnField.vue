<template>
  <div class="custom-radio" v-for="option in optionsList" :key="option.id">
    <input
      class="custom-radio__input"
      type="radio"
      :value="option.id"
      :true-value="1"
      :false-value="0"
      :checked="option.active"
      v-model="form[fieldName]"
    >
    <label class="custom-radio__label">
      <span class="custom-radio__selector custom-radio__selector-component" @click="setActiveBtn(option)"></span>
      <span class="custom-radio__description">{{ option.name }}</span>
    </label>
  </div>
</template>

<script>
import useForm from "@/composables/useForm";
import {onBeforeMount, onMounted, ref} from "vue";
// import CustomRadio from "@/components/ui/CustomRadio.vue";

export default {
  name: "RadioCheckBtnField",
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
    const {form} = useForm();

    const optionsList = ref(props.options);

    const setActiveBtn = (sendOption) => {
      optionsList.value.forEach(option => {

        if (sendOption.id === option.id) {
          option.active = true;
          form[props.fieldName] = option.id;
        } else {
          option.active = false;
        }

        return option;
      });
    };

    onMounted(() => {
      setActiveBtn(optionsList.value[0]);
    });

    onBeforeMount(() => {
      props.onRendered();
    })

    return {
      optionsList,
      setActiveBtn,
      form
    };
  }
}
</script>

<style scoped lang="scss">

.custom-radio {
  cursor: pointer;
  position: relative;
  margin-right: 24px;
  flex: none;

  &__description {
    line-height: 20px;
  }

  &__selector {
    &-component {
      background-color: #fff;
    }
  }
}

.custom-radio:last-child {
  margin-right: 0;
}

.radio-check-btn {
  margin: 0 0;
  display: flex;

  &__item:first-child {
    display: flex;
    padding: 0 0;
  }

  &__item {
    display: flex;
    padding: 0 14px;
  }

  &__item-input {
    transform: scale(1.6);
  }

  &__item-name {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 400;
    font-size: 15px;
    line-height: 130%;
    color: #1E1E1E;
    display: block;
    margin-left: 10px;
  }
}

</style>
