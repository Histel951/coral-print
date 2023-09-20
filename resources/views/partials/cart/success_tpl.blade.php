<h3>Спасибо за ваш заказ!</h3>
<span>Номер заявки №{{$data['evoShopOrderId']}}</span><br><br>
<span>Состав заказа отправлен Вам на почту.</span><br>
<span>Мы свяжемся с Вами в ближайшее время.</span>
<style>.okhide{display:none}</style>
<script>evoShop.empty();$(".cart_is_empty").show();</script>
{!! $data['YandexMoneyForm'] !!}