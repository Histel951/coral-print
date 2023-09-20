<template>
  <div class="type" @click="onClick" :class="{ active: active }">
    <div class="type__img">
      <svg>
        <use :xlink:href="'#' + data.svg_id"></use>
      </svg>
    </div>
    <div class="type__name">{{ data.pagetitle }}</div>
    <div class="type__price">от <span>{{ data.min_price }}</span> ₽</div>
  </div>
</template>

<script>

import useForm from "@/composables/useForm";
import useFormSchema from "@/composables/useFormSchema";

export default {
  name: "Type",
  props: {
    data: Object,
    setActiveType: Function,
    active: Boolean
  },
  setup(props) {
    const {calculator_id} = useFormSchema();
    const {removeField, form} = useForm();

    const onClick = () => {
      if (calculator_id.value !== props.data.id) {
        sessionStorage.removeItem('files');
        sessionStorage.removeItem('comment');
        props.setActiveType(props.data);
        Object.keys(form).forEach(field => removeField(field));
        calculator_id.value = undefined;
      }
    }

    return {
      onClick
    }
  }
}
</script>

<style lang="scss" scoped>
@media all and (min-width: 490px) {
  .type {
    &__img {
      height: 138px;
    }
  }
}

@media all and (min-width: 640px) {
  .type {
    &__img {
      height: 118px;
    }
  }
}

.type {
  text-align: center;
  padding: 8px;
  margin: 0;
  border-radius: 4px;
  min-height: 100%;
  box-sizing: border-box;
  border: 1px solid #fff;

  &__svg {
    min-height: 80px;
  }

  &__img {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto 2px;
    // padding: 0 0 90% 0;
    width: 96%;
    position: relative;

    img {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      max-height: 100%;
      max-width: 100%;
      display: block;

    }
  }

  &__name {
    display: block;
    font-family: "Euclid Circular B", Arial, Tahoma, sans-serif;
    font-weight: 500;
    font-size: 13px;
    line-height: 120%;
    color: #00195A;
    word-wrap: break-word;
    hyphens: auto;
  }

  &__price {
    color: #8E8E8E;
    font-size: 12px;
    line-height: 18px;
    margin-top: 4px;


    span {
      font-size: 16px;
    }

  }

  &.active {
    border: 1px solid #CCCCCC;
  }

}

@media all and (min-width: 768px) {
  .type {
    &__price {
      display: block;
    }

    &__name {
      font-size: 16px;
      line-height: 120%;
    }
  }
}

@media all and (min-width: 1024px) {
  .type {
    &:hover {
      cursor: pointer;
      border-color: #007DEB;

      .type__img {
        svg {
          margin-top: -8px;
        }
      }
    }

    &.active {
      &:hover {
        border-color: #CCCCCC;

        .type__img {
          svg {
            margin-top: 0;
          }
        }
      }
    }
  }
}

@media all and (min-width: 1280px) {
  .type {
    margin: 0 8px;
  }
}

@media all and (min-width: 1400px) {
  .type {
    margin: 0 12px;

    &_slider {
      margin: 0 8px;
    }
  }
}

@media screen and (max-width: 360px) {
  .type {
    &__img {
      display: flex;
      justify-content: center;
      height: 80px;
      align-items: center;
      margin: 0 auto 2px;
      // padding: 0 0 90% 0;
      width: 96%;
      position: relative;
    }
  }
}
</style>
