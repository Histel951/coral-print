<template>
  <div class="cat-preview">
    <div class="cat-preview__item" v-for="preview in images" :key="preview.id">

        <PreviewImg v-if="preview.type === 'default' && preview.svg_id && calculator_id" :preview="preview" />
        <PreviewDynamic
          v-if="preview.type === 'changeable' && calculator_id"
          :preview="preview"
          :is-loading="isLoading"
        />
        <PreviewSizes
          v-if="preview.type === 'sizing' && calculator_id"
          :preview="preview"
          :is-loading="isLoading"
        />

      <div
        v-if="preview.description && calculator_id"
        class="cat-preview__description"
      >
          <span class="cat-preview__description__text">
            {{ preview.descriptionText }}
          </span>
      </div>
      </div>
    </div>
</template>

<script>
import {onBeforeMount, ref, watch, watchEffect, onBeforeUnmount} from "vue";
import useFormSchema from "@/composables/useFormSchema";
import PreviewImg from "@/components/PreviewImg";
import PreviewDynamic from "@/components/PreviewDynamic";
import useForm from "@/composables/useForm";
import usePreviews from "@/composables/usePreviews";
import PreviewSizes from "@/components/PreviewSizes";
import useRestrictions from "@/composables/useRestrictions";
import cloneDeep from "lodash/cloneDeep";

export default {
  name: "Preview",
  components: {PreviewSizes, PreviewDynamic, PreviewImg},
  props: {
    isLoading: {
      type: Boolean,
      default: false
    },
    previews: {
      type: Array,
      default: () => []
    }
  },
  setup(props) {
    const {previews, calculator_id} = useFormSchema();
    const {images} = usePreviews();
    const {form} = useForm();
    const {restrictions} = useRestrictions();
    const peviewsList = ref(props.previews);

    const restrictionSizes = ref({
      maxSize: 0,
      minSize: 0
    });

    const findActivePreviews = () => {
      images.value = [];

      previews.value.some(preview => {

        if (!Object.keys(form).length) {
          return true;
        }

        let check = true;

        Object.keys(preview.parameters).some(parameterField => {
          if (typeof form[parameterField] !== 'undefined' && form[parameterField] !== preview.parameters[parameterField]) {
            check = false;
          }

          return !check;
        });

        if (check) {
          images.value.push(preview);
        }
      });
    };

    const checkRestrictions = () => {
      let check = true;

      Object.keys(restrictions.value).some(key => {
        if (restrictions.value[key].active) {
          check = false;

          restrictionSizes.value = {
            maxSize: restrictions.value[key].maxSize,
            minSize: restrictions.value[key].minSize
          };
        }

        return !check;
      });

      return check;
    };

    onBeforeMount(() => {
      findActivePreviews();
      watch(form, () => {
        findActivePreviews();
      });
    });

    onBeforeUnmount(() => {
      images.value = [];
    });

    const getMaxSizeByValue = (size) => {
      if (size < restrictionSizes.value.minSize) {
        size = cloneDeep(restrictionSizes.value.minSize);
      }

      if (size > restrictionSizes.value.maxSize) {
        size = cloneDeep(restrictionSizes.value.maxSize);
      }

      return size;
    };

    watchEffect(() => {
      const check = checkRestrictions();

      peviewsList.value.forEach(preview => {

        if (!preview.description) {
          return;
        }

        if (!check) {
          const width = getMaxSizeByValue(form.width);
          const height = getMaxSizeByValue(form.height);

          preview.descriptionText = preview.description.replace(`#width#`, width);
          preview.descriptionText = preview.descriptionText.replace(`#height#`, height);
        } else {
          let width;
          let height = form.height;

          if (preview.dependence === 'width') {
            width = form.width * 2;
          } else {
            width = form.width;
          }

          if (preview.dependence === 'reversal' && form.sprint_position === 1) {
            width = form.height * 2;

            height = form.width;
          }

          preview.descriptionText = preview.description.replace(`#width#`, width);
          preview.descriptionText = preview.descriptionText.replace(`#height#`, height);
        }
      });
    });

    return {
      images,
      calculator_id
    };
  }
}
</script>

<style lang="scss" scoped>
.cat-preview {
  min-height: 210px;

  &__item {
    margin-bottom: 20px;
  }

  &__item:last-child {
    margin-bottom: 0;
  }

  &__description {
    //padding-top: 8px;
    text-align: center;
    width: 100%;

    &__text {
      font-size: 12px;
      font-style: normal;
      font-family: 'Inter';
      color: #1E1E1E;
    }
  }
}
</style>
