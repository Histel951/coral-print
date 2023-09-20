<template>
  <div v-if="preview.dependence === 'height'" class="cat-preview-folded"
       :class="{ 'cat-preview-folded-column': isRotate }">
<!--  пружина  -->
    <canvas v-if="preview.bracer.type === 'pruzhina'" id="canvas"></canvas>

<!--  скобы  -->
    <div v-if="preview.bracer.type === 'skobi'" class="preview-canvas-container-staples" ref="staplesContainer">
      <canvas id="canvas-staples"></canvas>
      <canvas id="canvas-staples" style="margin-top: 19px"></canvas>
    </div>

<!-- болты  -->
    <div ref="boltsContainer" v-if="preview.bracer.type === 'bolti'" class="preview-canvas-bolt">
      <canvas data-move-x="150" data-move-y="0" data-line-x="150" data-line-y="170" data-line-width="50" id="canvas-bolt"></canvas>
      <canvas style="margin-top: 36px" data-move-x="280" data-move-y="30" data-line-x="0" data-line-y="130" data-line-width="30" id="canvas-bolt"></canvas>
    </div>
    <div class="cat-preview-folded__img" ref="folded"></div>
  </div>
  <div v-else class="cat-preview-reversal">
    <div class="cat-preview-reversal__img" ref="reversalEl"></div>

<!--  пружина  -->
    <canvas v-if="preview.bracer.type === 'pruzhina'" id="split"></canvas>

<!--  скобы  -->
    <div v-if="preview.bracer.type === 'skobi'" class="preview-canvas-reversal-container-staples" ref="staplesSplitContainer">
      <div class="preview-canvas-reversal-staple">
        <canvas id="split-staples" class="preview-canvas-reversal-staple-item" style="border-radius: 2px 2px 0 0;"></canvas>
        <canvas id="split-staples" class="preview-canvas-reversal-staple-item" style="border-radius: 0 0 2px 2px"></canvas>
      </div>
      <div class="preview-canvas-reversal-staple">
        <canvas id="split-staples" class="preview-canvas-reversal-staple-item" style="border-radius: 2px 2px 0 0;"></canvas>
        <canvas id="split-staples" class="preview-canvas-reversal-staple-item" style="border-radius: 0 0 2px 2px;"></canvas>
      </div>
    </div>
    <div class="cat-preview-reversal__img" ref="reversalEl"></div>
  </div>
</template>

<script>
import useForm from '@/composables/useForm';
import useRestrictions from '@/composables/useRestrictions';
import {onMounted, ref, watch} from 'vue';
import usePreviews from '@/composables/usePreviews';
import cloneDeep from 'lodash/cloneDeep';

export default {
  name: 'PreviewDynamic',
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
  setup(props) {
    const {form} = useForm();
    const {images} = usePreviews();
    const {restrictions} = useRestrictions();
    const folded = ref(null);
    const boltsContainer = ref(null);
    const reversal = ref(null);
    const reversalEl = ref(null);
    const staplesContainer = ref(null);
    const staplesSplitContainer = ref(null);
    const reversalSpring = ref(null);
    const isSpring = ref(false);
    const isRotate = ref(false);

    /**
     * Возвращает высоту/ширину в зависимости от пикселей в базе
     * @return [number, number]
     */
    const getPixels = () => {
      const pixelsWidth = [];
      const pixelsHeight = [];
      let usedSizes;

      if (props.preview.pixels) {
        props.preview.pixels.forEach(pixelSize => {
          if (pixelSize.width_px > pixelSize.height_px) {
            pixelsWidth.push(pixelSize);
          } else {
            pixelsHeight.push(pixelSize);
          }
        });
      }

      const isAlbum = form.width > form.height;

      if (isAlbum) {
        usedSizes = cloneDeep(pixelsWidth);
      } else {
        usedSizes = cloneDeep(pixelsHeight);
      }

      usedSizes = usedSizes.reverse();

      const maxSize = {
        width: 0,
        height: 0,
        pixels_w: 0,
        pixels_h: 0
      };

      usedSizes.some(size => {
        if (form.width <= size.print_size.width && !maxSize.width) {
          maxSize.width = cloneDeep(size.print_size.width);
          maxSize.pixels_w = cloneDeep(size.width_px);
        }

        if (form.height <= size.print_size.height && !maxSize.height) {
          maxSize.height = cloneDeep(size.print_size.height);
          maxSize.pixels_h = cloneDeep(size.height_px);
        }

        if (maxSize.width && maxSize.height) {
          return true;
        }
      });

      if (!maxSize.pixels_h) {
        maxSize.pixels_h = usedSizes.pop().height_px;
      }

      if (!maxSize.pixels_w) {
        maxSize.pixels_w = usedSizes.pop().width_px;
      }

      const biggerFormSize = Math.max(form.height, form.width);
      const minFormSize = Math.min(form.height, form.width);
      const coef = minFormSize / biggerFormSize;

      const checkMinSizes = (size) => {
        if (size < 55) {
          return 55;
        }

        return size;
      };

      if (isAlbum) {
        const maxSizePixels = Math.min(maxSize.pixels_h, maxSize.pixels_w);

        return [
          maxSizePixels,
          checkMinSizes(maxSizePixels * coef)
        ];
      } else {
        const maxSizePixels = Math.max(maxSize.pixels_h, maxSize.pixels_w);

        return [
          checkMinSizes(maxSizePixels * coef),
          maxSizePixels
        ];
      }
    };

    const checkRestrictions = () => {
      let check = true;

      Object.keys(restrictions.value).forEach(key => {
        if (restrictions.value[key].active) {
          check = false;
        }
      });

      return check;
    };

    const scaleSpring = (context, size) => {
      const marginCtx = 7;
      const spring = 3;
      const count = Math.floor(size / (spring + marginCtx));
      let sizeCoordinate = (size - ((count * (spring + marginCtx)) - marginCtx)) / 2;

      for (let i = 1; i <= count; i++) {
        context.moveTo(0, sizeCoordinate);
        context.lineTo(9, sizeCoordinate);
        context.moveTo(0, sizeCoordinate + 3);
        context.lineTo(9, sizeCoordinate + 3);

        sizeCoordinate = sizeCoordinate + 10;
      }
    };

    const scalePreview = () => {
      isRotate.value = form.sprint_position === 1;

      images.value.forEach((image) => {
        // console.log(image);
        if (Number(image.is_split) === 1) {
          isSpring.value = true;
        }
      });

      const [width, height] = getPixels();

      if (folded.value) {
        folded.value.style.width = width + 'px';
        folded.value.style.height = height + 'px';
      }

      const reversal = document.querySelectorAll('.cat-preview-reversal__img');
      const split = document.getElementById("split");

      if (split) {
        const splitCtx = split.getContext("2d");

        if (isRotate.value) {
          split.width = 9;
          split.height = width;

          splitCtx.beginPath();
          scaleSpring(splitCtx, width);
          splitCtx.stroke();
        } else {
          split.width = 9;
          split.height = height;

          splitCtx.beginPath();
          scaleSpring(splitCtx, height);
          splitCtx.stroke();
        }
      }

      reversal.forEach(el => {
        if (isRotate.value) {
          el.style.width = height + 'px';
          el.style.height = width + 'px';

        } else {
          el.style.width = width + 'px';
          el.style.height = height + 'px';
        }
      });

      const canvas = document.getElementById("canvas");

      if (canvas) {
        const ctx = canvas.getContext("2d");

        ctx.lineWidth = 0.5; // толщина линии
        ctx.lineCap = 'round';

        if (isRotate.value) {
          canvas.height = 9;
          canvas.width = width;
          canvas.style.marginRight = '0';
          canvas.style.marginBottom = '-5px';

          const marginCtx = 7;
          const spring = 3;
          const count = Math.floor(width / (spring + marginCtx));
          let x = (width - ((count * (spring + marginCtx)) - marginCtx)) / 2;

          ctx.beginPath();
          for (let i = 1; i <= count; i++) {
            ctx.moveTo(x, 0);
            ctx.lineTo(x, 9);
            ctx.moveTo(x + 3, 0);
            ctx.lineTo(x + 3, 9);

            x = x + 10;
          }

          ctx.stroke();
        } else {
          canvas.width = 9;
          canvas.height = height;
          canvas.style.marginRight = '-5px';
          canvas.style.marginBottom = '0';

          const marginCtx = 7;
          const spring = 3;
          const count = Math.floor(height / (spring + marginCtx));
          let y = (height - ((count * (spring + marginCtx)) - marginCtx)) / 2;

          ctx.beginPath();
          for (let i = 1; i <= count; i++) {
            ctx.moveTo(0, y);
            ctx.lineTo(9, y);
            ctx.moveTo(0, y + 3);
            ctx.lineTo(9, y + 3);

            y = y + 10;
          }

          ctx.stroke();
        }
      }


      const canvasStaples = document.querySelectorAll("#canvas-staples");

      if (canvasStaples.length) {
        canvasStaples.forEach(staples => {
          const ctxCanvasStaples = staples.getContext("2d");

          ctxCanvasStaples.lineWidth = 0.5

          if (staplesContainer.value) {
            staples.height = 13;
            staples.width = 2;
            staples.style.marginRight = '0';
            staples.style.borderRadius = '2px 0px 0px 2px';
            staples.style.backgroundColor = '#A1A1A1';
            staples.style.marginBottom = '-5px';
          }
        });
      }

      const splitStaples = document.querySelectorAll("#split-staples");

      if (splitStaples.length) {
        splitStaples.forEach(staple => {
          const ctxCanvasSplitStaples = staple.getContext("2d");

          ctxCanvasSplitStaples.lineWidth = 0.5;

          if (staplesSplitContainer.value) {
            staple.height = 6;
            staple.width = 3;
            staple.style.marginRight = '0';
            staple.style.backgroundColor = '#A1A1A1';
            staple.style.marginBottom = '-5px';
          }
        });
      }

      const bolts = document.querySelectorAll('#canvas-bolt');

      if (bolts.length) {
        bolts.forEach(bolt => {
          const ctxBolt = bolt.getContext("2d");

          if (boltsContainer.value && boltsContainer.value.style.display !== 'none') {
            bolt.style.width = '7px';
            bolt.style.height = '7px';
            bolt.style.borderRadius = '50%';
            bolt.style.marginRight = '0';
            bolt.style.backgroundColor = '#A1A1A1';
            bolt.style.marginBottom = '-5px';

            ctxBolt.beginPath();
            ctxBolt.strokeStyle = "#ffffff";
            ctxBolt.moveTo(Number(bolt.dataset.moveX), Number(bolt.dataset.moveY));
            ctxBolt.lineTo(Number(bolt.dataset.lineX), Number(bolt.dataset.lineY));
            ctxBolt.lineWidth = Number(bolt.dataset.lineWidth);
            ctxBolt.stroke();

            boltsContainer.value.style.height = height - 2 + 'px';
          }

          if (boltsContainer.value) {

            if (folded.value) {
              folded.value.style.marginLeft = '-12px';
            }

            boltsContainer.value.style.display = 'flex';
          }
        });
      }
    }

    watch(() => props.isLoading, async newValue => {

      if (newValue && checkRestrictions()) {
        return;
      }

      await scalePreview();
    }, {
      flush: 'post',
    });

    onMounted(() => {
      scalePreview();
    });

    return {
      folded,
      reversal,
      reversalSpring,
      isSpring,
      isRotate,
      staplesContainer,
      staplesSplitContainer,
      boltsContainer,
      reversalEl
    };

  },
};
</script>

<style lang="scss" scoped>
#canvas {
  z-index: 2;
}

#split {
  position: absolute;
  z-index: 2;
  margin-left: -1px;
}

.preview {
  &-canvas {

    &-reversal {

      &-staple {
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        align-content: space-between;
        height: 25px;

        &-item {
          height: 6px;
          width: 3px;
        }
      }

      &-container {

        &-staples {
          position: absolute;
          z-index: 2;
          margin-left: -1px;
        }
      }
    }

    &-container {
      &-staples {
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex-wrap: wrap;
      }
    }

    &-bolt {
      z-index: 2;
      display: flex;
      flex-wrap: nowrap;
      flex-direction: column;
      height: 40px;
      justify-content: center;
      padding-left: 2px;
      padding-right: 2px;
      border-right: 1px solid #C4C4C4;
    }
  }
}

.cat-preview {
  min-height: 210px;

  &-folded {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 8px;

    &-column {
      flex-direction: column;
    }

    &-spring {
      z-index: 2;
    }

    &__img {
      transition: 0.2s;
      padding: 0;
      background-color: #fff;
      border: 1px solid #6C6C6C;
    }
  }

  &-reversal {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 8px;

    &-spring {
      z-index: 2;
    }

    &__img {
      transition: 0.2s;
      padding: 0;
      background-color: #fff;
      border: 1px solid #6C6C6C;

      &:last-child {
        border-left: 0;
      }

      &-no-spring-border {
        border-left: none;
      }
    }
  }
}

</style>
