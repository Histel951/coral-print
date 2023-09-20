<h3>Спасибо что сделали заказ в нашем интернет магазине!</h3>
<p><a href="www.stickerstore.ru">www.stickerstore.ru</a></p>


<p>Наши менеджеры свяжутся с Вами в самое ближайшее время.<br>
    Сроки изготовления Вашего заказа уточняйте у наших менеджеров.</p>
<hr>
<p>Номер Вашей заявки: <b>{{$data['evoShopOrderId']}}</b></p>

<p>В ближайшее время мы проверим Вашу заявку, и ей будет присвоен номер заказа.<br>
    Дата: {{$data['date']}}</p>

{!! $data['evoShopItems'] !!}

<h3>Данные покупателя:</h3>

<p>Имя: {{$data['name.value']}}</p>
<p>Email: {{$data['email.value']}}</p>
<p>Телефон: {{$data['phone.value']}}</p>
<p>Сообщение: {{$data['comment.value']??''}}</p>
<p>Способ оплаты: {{$data['payment.value']}}</p>
<p>Способ доставки: {{$data['delivery.value']}}</p>
@if (!empty ($data['index']))
    <p>Индекс: {{ $data['index.value'] }}</p>
    <p>Город: {{ $data['city.value'] }}</p>
    <p>Улица: {{ $data['street.value'] }}</p>
    <p>Дом: {{ $data['house.value'] }}</p>
@else
    <p>Адрес доставки:	{{$data['address.value']}}</p>
@endif


<br>
<hr>
<p>http://www.stickerstore.ru/<br>
    +7 (495) 663-73-81</p>

