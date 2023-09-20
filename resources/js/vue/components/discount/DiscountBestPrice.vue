<template>
  <div class="discount-best-price__content">
    <div class="discount-best-price__head-text">
      Лучшая цена
    </div>

    <div class="discount-best-price__content__image">
      <img src="/images/icon-max-discount.svg" alt="" width="50">
    </div>

    <div>
      Стоимость вашего тиража мы уже рассчитали с минимально возможной ценой единицы товара. Спасибо за ваш заказище!
    </div>
  </div>
</template>

<script>
export default {
  name: "DiscountBestPrice"
}
</script>

<style lang="scss" scoped>

.discount-best-price {
  &__content {

    &__image {
      padding: 16px 0 16px 0;
    }
  }

  &__head-text {
    font-family: 'Euclid Circular B';
    font-style: normal;
    font-weight: 600;
    font-size: 20px;
    line-height: 120%;
    color: #00195A;
  }
}

</style>
