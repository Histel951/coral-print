/**
 * в теории для того чтобы подтягивать все нужные роуты и вызывать по названию, пока просто для получения protocol + domen
 */
import {ref} from "vue";

const origin = ref(null);

const setOrigin = (windowOrigin) => {
    origin.value = windowOrigin
};

export default () => ({
    origin,
    setOrigin
});
