@extends('layouts.layout')
@section('main')
    @php
        function format($value): void
        {
            echo str_replace(',00', '', str_replace('р.', '<span style="font-size: 13px;">₽</span>', (new NumberFormatter('ru_RU', NumberFormatter::CURRENCY))->formatCurrency($value, 'RUR')));
        };
    @endphp
    <div class="container">
        <ul class="breadcrumbs">
            <li><a href="/">← Вернуться к покупкам</a></li>
        </ul>
    </div>
    <section class="section-inner">
        <div class="container">
            <h1 class="page-title page-title_center page-title_thank">Спасибо!</h1>
            <div class="order-thank">
                <p>Мы бесконечно рады вашему заказу. Его номер: <b>{{ $order->id }}</b>.</p>
                <p>Дата регистрации: <b>@php
                            echo (new IntlDateFormatter('ru_RU', IntlDateFormatter::GREGORIAN, IntlDateFormatter::SHORT))->format($order->created_at);
                        @endphp</b>.</p>
                <p>Наш менеджер как можно скорее свяжется с вами для уточнения всех деталей.</p>
            </div>
        </div>
    </section>
    <section class="order-detail-section">
        <div class="container">
            <h2 class="block-title block-title_thank block-title_dark ">Детали заказа</h2>
            <div class="pure-g order-detail">
                <div class="pure-u-1 pure-u-md-1-2">
                    <div class="order-detail__side">
                        <div class="order-detail__part">
                            <h3 class="order-detail__part-title">Вы заказали</h3>
                            <table class="detail-items">
                                @foreach($order->orderItems as $item)
                                    @php
                                        $props = json_decode($item->props, true);
                                    @endphp
                                    <tr class="detail-item">
                                        <td class="detail-item__content">
                                            <h4 class="detail-item__title"><a href="#">{{ $item->name }}
                                                    @if(count($props['quantity_types']) > 1)
                                                        ,{{ count($props['quantity_types']) }}&nbsp;вида
                                                    @endif</a>
                                            </h4>
                                            <div class="detail-item__info">
                                                @if(isset($props['is_diameter']) && $props['is_diameter'] === 1)
                                                    {{ $props['diameter'] }}
                                                @elseif(isset($props['width']) && isset($props['height']))
                                                    {{ $props['width'] . '×' . $props['height'] }}
                                                @elseif(isset($props['diameter']))
                                                    {{ $props['diameter'] }}
                                                @endifмм, {{ $item->product_count }} шт.
                                            </div>
                                        </td>
                                        <td class="detail-item__price">
                                            @php
                                                format($item->total_price);
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="detail-item">
                                    <td class="detail-item__content">
                                        <div class="detail-item__title">Доставка</div>
                                    </td>
                                    <td class="detail-item__price">
                                        @php
                                            format($order->delivery_price);
                                        @endphp
                                    </td>
                                </tr>
                                @if($order->discount > 0)
                                    <tr class="detail-item">
                                        <td class="detail-item__content">
                                            <div class="detail-item__title">Скидка по промокоду</div>
                                        </td>
                                        <td class="detail-item__price">-
                                            @php
                                                $discountCoeff = $order->discount / 100;
                                                format($order->price / (1 - $discountCoeff) * $discountCoeff);
                                            @endphp
                                        </td>
                                    </tr>
                                @endif
                                <tr class="detail-item">
                                    <td class="detail-item__content">
                                        <div class="detail-item__title"><b>Итого</b></div>
                                    </td>
                                    <td class="detail-item__price">
                                        @php
                                            format($order->price);
                                        @endphp
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="pure-u-1 pure-u-md-1-2">
                    <div class="order-detail__side">
                        <div class="order-detail__part">
                            <h3 class="order-detail__part-title">Данные получателя</h3>
                            <div class="order-detail__text">
                                <p>{{ $order->name }}</p>
                                <p>{{ $order->phone }}</p>
                                <p>{{ $order->email }}</p>
                            </div>
                        </div>
                        <div class="order-detail__part">
                            <h3 class="order-detail__part-title">Доставка</h3>
                            <div class="order-detail__text">
                                <p>{{ $order->deliveryType->name }}@if(($order->deliveryType->id === 1 || $order->deliveryType->id === 3) && $order->delivery_address !== null)
                                        : {{ $order->delivery_address }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="order-detail__part">
                            <h3 class="order-detail__part-title">Оплата</h3>
                            <div class="order-detail__text">
                                <p>{{ $order->paymentType->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
