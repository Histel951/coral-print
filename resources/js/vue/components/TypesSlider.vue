<template>
  <div class="types-slider-wrap">
    <div class="types-slider">
      <div :key="type.value" v-for="type in types">
        <Type class="type_slider" :data="type" :set-active-type="setActiveType" :active="type === activeType"/>
      </div>
    </div>
  </div>
</template>

<script>
import {onMounted} from 'vue';
import {tns} from "tiny-slider/src/tiny-slider";
import Type from "./Type";
import 'tiny-slider/src/tiny-slider.scss';
import useTypes from "../composables/useTypes";

export default {
  components: {Type},
  setup() {
    const {types, setActiveType, activeType} = useTypes();

    onMounted(() => {
      const startIndex = types.value.findIndex((element) => element === activeType.value);
      tns({
        container: '.types-slider',
        items: 3,
        navPosition: 'bottom',
        startIndex: startIndex > -1 ? startIndex : 0,
        controlsText: [
          '<svg><use xlink:href="#calculator-arrow-left"></use></svg>',
          '<svg><use xlink:href="#calculator-arrow-right"></use></svg>',
        ],
        loop: false,
        nav: true,
        controls: false,
        responsive: {
          640: {
            items: 4
          },
          768: {
            controls: true,
            items: 5,
            nav: false
          },
          1024: {
            items: 6
          },
          1280: {
            items: 7
          }
        }
      });
    });

    return {
      types,
      setActiveType,
      activeType
    }
  }
};
</script>

<style lang="scss">
.types-slider-wrap {
  .tns-horizontal {
    display: flex;
  }

  .tns-nav {
    margin: 17px 0 0 0;
    display: flex;
    align-items: center;
    justify-content: center;

    button {
      width: 6px;
      height: 6px;
      opacity: 1;
      border-radius: 50%;
      background-color: #AABEC8;
      padding: 0;
      margin: 0;
      border: none;

      + button {
        margin: 0 0 0 6px;
      }
    }

    .tns-nav-active {
      background-color: #007DEB;
      width: 10px;
      height: 10px;
    }
  }

  .tns-controls {
    button {
      padding: 0;
      margin: 0;
      border: none;
      background: none;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);

      &[data-controls=prev] {
        left: 0;
      }

      &[data-controls=next] {
        right: 0;
      }

      svg {
        display: block;
        fill: #007DEB;
        width: 30px;
        height: 26px;
      }

      &:hover {
        svg {
          fill: #00195A
        }
      }

      &:disabled {
        svg {
          fill: #D6DEE3;
        }
      }
    }
  }
}

@media all and (min-width: 1280px) {
  .types-slider-wrap {
    .tns-controls {
      button {
        &[data-controls=prev] {
          left: -46px;
        }

        &[data-controls=next] {
          right: -46px;
        }
      }
    }
    .tns-inner {
      margin: 0 -8px !important;
    }
  }
}
</style>

<style lang="scss" scoped>
@media all and (min-width: 768px) {
  .types-slider-wrap {
    position: relative;
    padding: 0 48px;
  }
}

@media all and (min-width: 1280px) {
  .types-slider-wrap {
    padding: 0;
  }
}
</style>
