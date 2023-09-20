import {ref} from "vue";

const issetActiveTooltip = ref(false);

const tooltips = ref({});

const getTooltip = (field = '') => tooltips.value[field];

export default () => ({
    tooltips,
    issetActiveTooltip,
    getTooltip
});
