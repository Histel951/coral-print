<template>
  <div class="container">
    <div v-if="preview.form_type === 'rectangle'">
      <div style="text-align: center; font-size: 12px; width: calc(100% - 24px)">{{ form.width }} мм</div>
      <div style="border-left: 1px solid #6C6C6C; border-right: 1px solid #6C6C6C; height: 24px; width: calc(100% - 24px);">
        <div class="arrow-top-left-container">
          <div class="arrow arrow-top-left"></div>
        </div>
        <div style="padding-top: 8px; border-bottom: 1px solid #6C6C6C">
        </div>
        <div class="arrow-top-right-container">
          <div class="arrow arrow-top-right"></div>
        </div>
      </div>
      <div style="display: flex">
        <svg width="220" height="119">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div style="border-bottom: 1px solid #6C6C6C; width: 24px; border-top: 1px solid #6C6C6C; display: flex">
          <div class="arrow-left-top-container">
            <div class="arrow arrow-left-top"></div>
          </div>
          <div style="border-left: 1px solid #6C6C6C; height: 100%; margin-left: 16px"></div>
          <div class="arrow-left-bottom-container">
            <div class="arrow arrow-left-bottom"></div>
          </div>
          <div style="font-size: 12px; display: flex; justify-content: center; margin-left: 8px; flex-direction: row; writing-mode: vertical-lr">{{ form.height }} мм</div>
        </div>
      </div>
    </div>
    <div class="svg-center-container" v-if="preview.form_type === 'rounded'">
      <div>
        <div class="rounded-lines-top">
          <div class="arrow-top-left-rounded-container">
            <div class="arrow arrow-top-left-rounded"></div>
          </div>
          <div style="text-align: center; font-size: 12px; margin-top: -15px; padding-bottom: 1px; border-bottom: 1px solid #6C6C6C">{{ form.diameter }} мм</div>
          <div class="arrow-top-right-rounded-container">
            <div class="arrow arrow-top-right-rounded"></div>
          </div>
        </div>
        <svg width="150" height="150" class="svg-center">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div class="rounded-lines-right">
          <div class="arrow-left-top-rounded-container">
            <div class="arrow arrow-left-top-rounded"></div>
          </div>
          <div style="height: 149px; float: right; font-size: 12px; margin-right: -15px; text-align: center; border-left: 1px solid #6C6C6C; writing-mode: vertical-lr">{{ form.diameter }} мм</div>
          <div class="arrow-left-bottom-rounded-container">
            <div class="arrow arrow-left-bottom-rounded"></div>
          </div>
        </div>
      </div>
    </div>
    <div style="margin-top: 6%" v-if="preview.form_type === 'complex'">
      <div>
        <div class="complex-line-top">
          <div class="arrow-top-left-complex-container">
            <div class="arrow arrow-top-left-complex"></div>
          </div>
          <div style="text-align: center; font-size: 12px; margin-top: -15px; padding-bottom: 1px; border-bottom: 1px solid #6C6C6C">{{ form.width }} мм</div>
          <div class="arrow-top-right-complex-container">
            <div class="arrow arrow-top-right-complex"></div>
          </div>
        </div>
        <svg width="200" height="200" class="svg-center">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div class="complex-lines-right">
          <div class="arrow-left-top-complex-container">
            <div class="arrow arrow-left-top-complex"></div>
          </div>
          <div style="height: 199px; float: right; font-size: 12px; margin-right: -15px; text-align: center; border-left: 1px solid #6C6C6C; writing-mode: vertical-lr">{{ form.height }} мм</div>
          <div class="arrow-left-bottom-complex-container">
            <div class="arrow arrow-left-bottom-complex"></div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="preview.form_type === 'visitki-rectangle-preview'">
      <div class="birki-preview-container" style="margin-right: 14px; width: 280px">
        <svg :style="{height: preview.height + 'px'}">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div class="visitki-rectangle-top-size no-wrap">
          {{ form.height }} мм
        </div>
      </div>
      <div class="visitki-rectangle-bottom-size" style="margin-top: -155px; padding-right: 3px">
        {{ form.width }} мм
      </div>
    </div>
    <div v-if="preview.form_type === 'visitki-rectangle-rounded-preview'" style="margin-right: 14px;">
      <div class="birki-preview-container" style="width: 280px">
        <svg :style="{height: preview.height + 'px'}">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div class="visitki-rectangle-top-size no-wrap">
          {{ form.height }} мм
        </div>
      </div>
      <div class="visitki-rectangle-bottom-size" style="margin-top: -155px; margin-left: 51px">
        {{ form.width }} мм
      </div>
    </div>
    <div v-if="preview.form_type === 'visitki-rounded-preview'">
      <div class="birki-preview-container" style="margin-right: 62px">
        <svg :style="{height: preview.height + 'px'}">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div class="visitki-rounded-top-size no-wrap" style="margin-left: -62px; margin-top: 80px">
          {{ form.diameter }} мм
        </div>
      </div>
      <div class="visitki-rounded-bottom-size" style="margin-top: -184px; margin-left: 134px">
        {{ form.diameter }} мм
      </div>
    </div>
    <div v-if="preview.form_type === 'visitki-complex-preview'">
      <div class="birki-preview-container" style="margin-right: 50px;">
        <svg :style="{height: preview.height + 'px'}">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div class="visitki-rounded-top-size no-wrap" style="margin-top: 75px; margin-left: -72px">
          {{ form.height }} мм
        </div>
      </div>
      <div class="complex-rectangle-bottom-size" style="margin-top: -184px; padding-left: 10px">
        {{ form.width }} мм
      </div>
    </div>
    <div v-if="preview.form_type === 'birki-rectangle'">
      <div class="birki-preview-container">
        <svg width="200" height="200">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div class="birki-rectangle-top-size no-wrap">
          {{ form.height }} мм
        </div>
      </div>
      <div class="birki-rectangle-bottom-size">
        {{ form.width }} мм
      </div>
    </div>
    <div v-if="preview.form_type === 'birki-rounded'">
      <div class="birki-preview-container">
        <svg width="200" height="200">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div class="birki-rounded-top-size">
          {{ form.diameter }} мм
        </div>
      </div>
      <div class="birki-rounded-bottom-size">
        {{form.diameter }} мм
      </div>
    </div>
    <div v-if="preview.form_type === 'birki-complex'">
      <div class="birki-preview-container">
        <svg width="200" height="200">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div class="birki-complex-top-size no-wrap">
          {{ form.height }} мм
        </div>
      </div>
      <div class="birki-complex-bottom-size">
        {{ form.width }} мм
      </div>
    </div>
    <div v-if="preview.form_type === 'birki-henger'">
      <div class="birki-preview-container">
        <svg width="200" height="200">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div class="birki-henger-top-size no-wrap">
          {{ form.height }} мм
        </div>
      </div>
      <div class="birki-henger-bottom-size">
        {{ form.width }} мм
      </div>
    </div>
    <div v-if="preview.form_type === 'booklets-leaflets-preview'">
      <div class="booklets-preview-container">
        <div class="birki-henger-bottom-size" style="margin-bottom: -6px; margin-right: 23px">
          {{ form.width }} мм
        </div>
        <svg width="120" height="160">
          <use :xlink:href="'#' + preview.svg_id"></use>
        </svg>
        <div class="birki-henger-top-size no-wrap" style="margin-left: 128px; margin-top: -88px">
          {{ form.height }} мм
        </div>
      </div>
    </div>
    <div v-if="preview.form_type === 'booklets'">
      <PreviewSizeBooktelt
        :svg-id="preview.svg_id"
        :width-styles="{marginBottom: '-5px', marginRight: '15px'}"
        :height-styles="{marginLeft: '172px', marginTop: '-70px'}"
      />
    </div>
    <div v-if="preview.form_type === 'booklets_bigger'">
      <PreviewSizeBooktelt
        :svg-id="preview.svg_id"
        :svg-width="252"
        :svg-height="144"
        :width-styles="{marginBottom: '-5px', marginRight: '15px'}"
        :height-styles="{marginLeft: '263px', marginTop: '-80px'}"
      />
    </div>
    <div v-if="preview.form_type === 'booklets_down'">
      <PreviewSizeBottomBooktelt :folds="preview.folds" :svg-id="preview.svg_id" />
    </div>
    <div v-if="preview.form_type === 'booklets_down_bigger'">
      <PreviewSizeBottomBooktelt
        :svg-height="118"
        :folds="preview.folds"
        :size-div-style="{marginLeft: '0'}"
        :svg-width="60"
        :svg-id="preview.svg_id"
      />
    </div>
  </div>
</template>

<script>
// import usePreviews from "@/composables/usePreviews";
import useForm from "@/composables/useForm";
import PreviewSizeBottomBooktelt from "@/components/PreviewSizeBottomBooktelt";
import PreviewSizeBooktelt from "@/PreviewSizeBooktelt";

export default {
  name: "PreviewSizes",
  components: {PreviewSizeBooktelt, PreviewSizeBottomBooktelt},
  props: {
    preview: {
      type: Object,
      default: () => {
      },
    },
    isLoading: {
      type: Boolean,
      default: false,
    },
  },
  setup() {
    const {form} = useForm();

    return {
      form
    };
  }
}
</script>

<style lang="scss" scoped>

.no-wrap {
  white-space: nowrap;
  min-height: 36px;
  max-height: 36px;
}

.booklets-bottom-preview-size {
  margin-top: 28px;
  margin-left: 28px;
}

.booklets-bottom-preview-size-container {
  display:flex;
  flex-direction: row;
  place-content: center space-evenly;
  flex-wrap: nowrap;
  justify-content: flex-start;
  align-content: center;
  align-items: baseline;
  width: 70%;
}

.booklets-bottom-preview-text {
  margin-left: 16px;
  white-space: nowrap;
  font-size: 12px;
}

.booklets-bottom-preview-svg {
  display: flex;
  flex-direction: row;
  align-content: center;
  justify-content: center;
  align-items: normal
}

.birki-henger-bottom-size {
  text-align: center;
  font-size: 12px;
  margin-top: -6px;
  margin-right: -14px;
}

.birki-henger-top-size {
  font-size: 12px;
  writing-mode: vertical-lr;
  margin-left: -50px;
  text-align: center;
}

.birki-rectangle-top-size {
  font-size: 12px;
  writing-mode: vertical-lr;
  margin-top: 106px;
  margin-left: -20px;
}

.complex-rectangle-bottom-size {
  text-align: center;
  padding-right: 28px;
  font-size: 12px;
  margin-top: -212px;
}

.visitki-rounded-top-size {
  font-size: 12px;
  writing-mode: vertical-lr;
  margin-top: 45px;
  margin-left: -8px;
}

.visitki-rounded-bottom-size {
  font-size: 12px;
  margin-top: -212px;
  margin-left: 65px;
}

.visitki-rectangle-top-size {
  font-size: 12px;
  writing-mode: vertical-lr;
  margin-left: -30px;
  margin-top: 60px
}

.birki-complex-top-size {
  font-size: 12px;
  writing-mode: vertical-lr;
  margin-top: 106px;
  margin-left: -36px;
}

.birki-complex-bottom-size {
  text-align: center;
  font-size: 12px;
  margin-top: -6px;
}

.birki-rounded-bottom-size {
  text-align: center;
  font-size: 12px;
  margin-top: -6px;
}

.birki-rectangle-bottom-size {
  text-align: center;
  padding-right: 24px;
  font-size: 12px;
  margin-top: -6px;
}

.visitki-rectangle-bottom-size {
  text-align: center;
  font-size: 12px;
  padding-right: 40px;
  margin-top: -172px;
}

.birki-rounded-top-size {
  font-size: 12px;
  writing-mode: vertical-lr;
  margin-top: 106px;
  margin-left: -36px;
}

.birki-preview-container {
  display: -webkit-box;
}

.booklets-preview-container {
  flex-direction: column;
  align-content: center;
  justify-content: center;
  align-items: center;
  display: inline-flex;
}

.arrow-left-top-rounded {
  margin-top: 1px;
  transform: rotate(315deg);

  &-container {
    width: 100%;
    margin-left: 86.5px;
    position: absolute;
  }
}

.arrow-left-top-complex {
  margin-top: 1px;
  transform: rotate(315deg);

  &-container {
    width: 100%;
    margin-left: 131.5px;
    position: absolute;
  }
}

.arrow-left-top {
  margin-top: 1px;
  transform: rotate(315deg);

  &-container {
    width: 100%;
    margin-left: 13px;
    position: absolute;
  }
}

.arrow-left-bottom-rounded {
  transform: rotate(135deg);

  &-container {
    width: 100%;
    margin-left: 88px;
    position: absolute;
    margin-top: 141px;
  }
}

.arrow-left-bottom-complex {
  transform: rotate(135deg);

  &-container {
    width: 100%;
    margin-left: 133px;
    position: absolute;
    margin-top: 192px;
  }
}

.arrow-left-bottom {
  transform: rotate(135deg);

  &-container {
    width: 100%;
    margin-left: 15px;
    position: absolute;
    margin-top: 111px;
  }
}

.arrow {
  width: 5px;
  height: 5px;
  box-sizing: border-box;
  position: absolute;

  &::before {
    content: '';
    width: 100%;
    height: 100%;
    border-width: 1px 1px 0 0;
    border-style: solid;
    border-color: #6C6C6C;
    transition: .2s ease;
    display: block;
    transform-origin: 100% 0;
  }


  &:after {
    content: '';
    float: left;
    position: relative;
    top: -100%;
    width: 100%;
    height: 100%;
    border-width: 0 1px 0 0;
    border-style: solid;
    border-color: #6C6C6C;
    transform-origin: 100% 0;
    transition: .2s ease;
  }
}

.arrow-top-left {
  margin-top: -2px;
  transform: rotate(225deg);
  margin-left: 1px;

  &-container {
    width: 100%;
    padding-top: 9px;
    position: absolute;
  }
}

.arrow-top-left-rounded {
  margin-top: -4px;
  transform: rotate(225deg);
  margin-left: 1px;

  &-container {
    width: 100%;
    padding-top: 9px;
    position: absolute;
  }
}

.arrow-top-left-complex {
  margin-top: -4px;
  transform: rotate(225deg);
  margin-left: 1px;

  &-container {
    width: 100%;
    padding-top: 9px;
    position: absolute;
  }
}

.arrow-top-right-complex {
  margin-top: -4px;
  transform: rotate(45deg);
  margin-right: 1px;
  margin-left: 192px;

  &-container {
    width: 100%;
    position: absolute;
  }
}

.arrow-top-right-rounded {
  margin-top: -4px;
  transform: rotate(45deg);
  margin-right: 1px;
  margin-left: 140px;

  &-container {
    width: 100%;
    position: absolute;
  }
}

.arrow-top-right {
  margin-top: -4px;
  transform: rotate(45deg);
  margin-right: 1px;
  margin-left: 212px;

  &-container {
    width: 100%;
    position: absolute;
  }
}

.svg-center-container {
  margin-top: 10%;
}

.svg-center {
  position: absolute;
  transform: translate(-50%);
}

.complex-line-top {
  position: absolute;
  transform: translate(-50%);
  width: 200px;
  margin-top: -30px;
  height: 130px;
  border-left: 1px solid #6C6C6C;
  border-right: 1px solid #6C6C6C;
}

.complex-lines-right {
  position: absolute;
  transform: translate(-50%);
  width: 140px;
  height: 200px;
  margin-left: 70px;
  border-top: 1px solid #6C6C6C;
  border-bottom: 1px solid #6C6C6C;
}

.rounded-lines-top {
  position: absolute;
  transform: translate(-50%);
  width: 149px;
  margin-top: -30px;
  height: 95px;
  border-left: 1px solid #6C6C6C;
  border-right: 1px solid #6C6C6C;
}

.rounded-lines-right {
  position: absolute;
  transform: translate(-50%);
  width: 95px;
  height: 150px;
  margin-left: 45px;
  border-top: 1px solid #6C6C6C;
  border-bottom: 1px solid #6C6C6C;
}

.container {
  display: flex;
  width: auto;
  flex-direction: column;
  padding: 10px;
  align-items: center;
  justify-content: center;
}

.img {
  display: flex;
  justify-content: center;
  transition: 0.2s;
  background-repeat: no-repeat;
  background-size: contain;
  padding: 0;
  background-position: center;
  margin: 0 auto calc(100% - 98%);
}
</style>
