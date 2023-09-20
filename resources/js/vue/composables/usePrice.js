import {ref} from "vue";
import useUserAgent from "@/composables/useUserAgent";

const priceIsLoading = ref(null);
const price = ref(null);
const repeatCirculation = ref(0);
const isBlockedSendPrice = ref(false);
const {isSafari} = useUserAgent();

const setPrice = (newPrice) => {
    price.value = newPrice;
}

// стек действий, который запрещает отправку подсчёта если не пустой, используется например в
// SelectField или MaterialField, при отправке запросов на получение материалов
const waitActionsStack = ref([]);

const addWaitAction = (action = true) => {
    waitActionsStack.value.push(action);
};

const delWaitAction = () => {
    waitActionsStack.value.pop();
}

const setPriceLoading = (val) => {
    priceIsLoading.value = val;
}

const formatter = new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUR',
});

const format = (number, fontSize) => {
    let priceText = formatter.format(number).replace(",00", "");
    if (isSafari()) {
        priceText = priceText.replace("р.", `<span style='font-size: ${fontSize}px'>&#8381;</span>`);
    } else {
        priceText = priceText.replace("RUR", `<span style='font-size: ${fontSize}px'>&#8381;</span>`);
    }

    return priceText;
}

export default () => ({
    waitActionsStack,
    addWaitAction,
    delWaitAction,
    priceIsLoading,
    price,
    formatter,
    format,
    setPrice,
    setPriceLoading,
    isBlockedSendPrice,
    repeatCirculation
});
