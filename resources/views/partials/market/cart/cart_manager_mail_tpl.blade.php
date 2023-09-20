<h3>Спасибо что сделали заказ в нашем интернет магазине!</h3>
<p><a href="www.stickerstore.ru">www.stickerstore.ru</a></p>


<p>Новая заявка: <b>{{$data['evoShopOrderId']}}</b><br>
    Дата: {{$data['date']}}</p>

{!! $data['evoShopItems'] !!}

<h3>Данные покупателя:</h3>

<p>Имя: {{$data['name.value']}}</p>
<p>Email: <a href="mailto:{{$data['email.value']}}?subject=RE: Заказ с сайта Stickerstore Заявка: {{$data['evoShopOrderId']}}">{{$data['email.value']}}</a></p>
<p>Телефон: {{$data['phone.value']}}</p>
<p>Сообщение: {{$data['comment.value']??''}}</p>
<p>Способ оплаты: {{$data['payment.value']}}</p>
<p>Способ доставка: {{$data['delivery.value']}}</p>
@if (!empty ($data['index']))
    <p>Индекс: {{ $data['index.value'] }}</p>
    <p>Город: {{ $data['city.value'] }}</p>
    <p>Улица: {{ $data['street.value'] }}</p>
    <p>Дом: {{ $data['house.value'] }}</p>
@else
    <p>Адрес доставки:	{{$data['address.value']}}</p>
@endif
<p>Контактное лицо:	</p>
<p>Телефон контактного лица: </p>

<br>

<hr>
<p>http://www.stickerstore.ru/<br>
    +7 (495) 663-73-81</p>

