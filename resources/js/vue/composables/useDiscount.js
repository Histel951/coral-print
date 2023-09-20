import {ref} from "vue";

const discountVisible = ref(false);
const discountsList = ref([]);
const discountActive = ref(null);
const minProductCount = ref(0);
const isLoadingDiscount = ref(false);
const isLockButtonChangeEdition = ref(false);

const setLockButton = (bool) => isLockButtonChangeEdition.value = bool;

const setLoading = (bool) => isLoadingDiscount.value = bool;

const setVisible = (visible) => discountVisible.value = visible;

const setDiscounts = (discounts) => discountsList.value = discounts;

const setMinProductCount = (productCount) => minProductCount.value = productCount;

const setActiveDiscount = (id) => {
    discountsList.value.map(discount => {
        if (id === discount.id) {
            discount.active = true;
            discountActive.value = discount;
        } else {
            discount.active = false;
        }

        return discount;
    });
};

const disabledDiscounts = (bool) => {
    if (discountsList.value[0]) {
        discountsList.value.map(discount => {
            discount.disabled = bool;
            return discount;
        })
    }
};

export default () => ({
    setVisible,
    discountVisible,
    setDiscounts,
    discountsList,
    disabledDiscounts,
    setActiveDiscount,
    discountActive,
    minProductCount,
    setMinProductCount,
    isLoadingDiscount,
    setLoading,
    isLockButtonChangeEdition,
    setLockButton
});
