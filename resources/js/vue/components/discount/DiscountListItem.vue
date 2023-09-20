<template>
  <div class="discount-list__item">
    <div class="discount-list__item-col">
      <input
        class="custom-radio__input"
        type="radio"
        :value="id"
        :true-value="1"
        :false-value="0"
        :checked="checked"
        :disabled="disabled"
      >
      <label class="custom-radio__label">
        <span class="custom-radio__selector" @click="onCheck(id)"></span>
      </label>
    </div>
    <div class="discount-list__item-col">
        <span class="discount-list__percent list-text">
          {{ percent }}%
        </span>
    </div>
    <div class="discount-list__item-col">
      <span class="discount-list__amount list-text">
        {{ amount }} шт.
      </span>
    </div>
    <div class="discount-list__item-col">
      <span class="discount-list__price-for-one list-text">
        {{ priceForOne }} ₽ за шт
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "DiscountListItem",
  props: {
    id: {
      type: Number,
      default: 0
    },

    percent: {
      type: Number,
      default: 0
    },

    amount: {
      type: Number,
      default: 0
    },

    priceForOne: {
      type: Number,
      default: 0
    },

    checked: {
      type: Boolean,
      default: false
    },

    disabled: {
      type: Boolean,
      default: false
    },

    onCheck: Function
  }
}
</script>

<style lang="scss" scoped>

.custom-radio {
  &__selector {
    margin-right: 0;
  }
}

.discount-list {

  &__item {
    flex-flow: row wrap;
    display: flex;
    border-bottom: 1px solid #E4E4E4;
    padding: 10px 0;
  }

  &__item:last-child {
    border-bottom: none;
  }

  &__item-col {
    display: inline-block;
    margin-left: 5%;
  }

  &__item-col:last-child {
    margin-left: auto;
  }

  &__check {
    -ms-transform: scale(1.5);
    -webkit-transform: scale(1.5);
    transform: scale(1.5);
  }

  &__percent {
    color: #59A471;
    font-size: 16px;
    font-weight: 600;
  }
}

.list-text  {
  font-size: 14px;
  text-align: left;
}

</style>
