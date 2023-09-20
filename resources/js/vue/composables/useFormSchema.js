import {computed, ref} from "vue";
import useBlockSelect from "@/composables/useBlockSelect";

const {optionActive} = useBlockSelect();

const fields = ref([]);
const config = ref(undefined);
const priceUrl = ref(undefined);
const checkboxes = ref([]);
const isLoading = ref(true);
const renderedFieldsNum = ref(null);
const previewImg = ref([]);
const schemaIndex = ref(0);
const calculator_id = ref(0);
const minPrice = ref(0);
const tooltips = ref([]);
const page = ref({});
const previews = ref([]);

const setSchema = (newSchema) => {
  //config.value = newSchema.config;
  const formFields = newSchema.fields.length ? newSchema.fields : Object.values(newSchema.fields);
  fields.value = formFields.sort((a, b) => a.sequence - b.sequence);
  checkboxes.value = newSchema.checkboxes.length ? newSchema.checkboxes : Object.values(newSchema.checkboxes);
  isLoading.value = false;
  minPrice.value = newSchema.min_price;
  calculator_id.value = newSchema.calculator_id;
  //renderedFieldsNum.value = 0;
  previewImg.value = newSchema.routes.mainImg;
  priceUrl.value = newSchema.routes.count.url;
  schemaIndex.value += 1;
  tooltips.value = newSchema.tooltips;
  previews.value = newSchema.previews;
}

const setSchemaLoading = () => {
  isLoading.value = true;
}

const fieldIsRendered = () => {
  renderedFieldsNum.value += 1;
}

const fieldIsHidden = () => {
  renderedFieldsNum.value -= 1;
}



const isSchemaRendered = computed(() => {

    let blockSelectFieldsCount = 0;
    if (optionActive.value.fields) {
        blockSelectFieldsCount += optionActive.value.fields.length;
    }

    if (optionActive.value.checkboxes) {
        blockSelectFieldsCount += optionActive.value.checkboxes.length;
    }

    return renderedFieldsNum.value === fields.value.filter((v) => v.type !== 'custom').length
        + checkboxes.value.length + blockSelectFieldsCount;
})

export default () => {

  return {
    setSchemaLoading,
    setSchema,
    fieldIsRendered,
    fieldIsHidden,
    isSchemaRendered,
    fields,
    config,
    checkboxes,
    isLoading,
    previewImg,
    schemaIndex,
    priceUrl,
    minPrice,
    calculator_id,
    renderedFieldsNum,
    tooltips,
    page,
    previews
  };
};
