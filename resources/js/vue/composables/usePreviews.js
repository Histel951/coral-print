import {ref} from "vue";

const images = ref([]);

const maxSizes = ref({
    height: 9999,
    width: 9999
});

const minSizes = ref({
    height: 35,
    width: 55
});

const setImages = (newImages) => {
    images.value = newImages;
};

export default () => ({
    images,
    setImages,
    maxSizes,
    minSizes
});
