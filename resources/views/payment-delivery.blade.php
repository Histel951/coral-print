@extends('layouts.layout')
@section('main')
    <section class="section-inner section-pd">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/" >← На главную</a></li>
            </ul>
        </div>
        <div class="container">
            <h1 class="page-title page-title_center page-title_p_d">Оплата и доставка</h1>
            <div class="pure-g p-d-page">
                <div class="pure-u-1 pure-u-md-1-2">
                    <div class="p-d-part">
                        <div class="p-d-part__img">
                            <img src="/images/delivery.png" alt="">
                        </div>
                        <h2 class="p-d-part__title">Доставка</h2>
                        <div class="pay-deliv-content">
                            <div class="pay-deliv-content__top">
                                <div class="pay-deliv-content__city">
                                    <div class="custom-select">
                                        <div class="custom-select__trigger">
                                            <input type="hidden" placeholder="" readonly class="custom-select__input">
                                            <div class="custom-select__text"></div>
                                            <div class="custom-select__arrow"></div>
                                        </div>
                                        <ul class="custom-options">
                                            <li class="custom-option" data-value="moscow">г. Москва</li>
                                            <li class="custom-option" data-value="kazan">г. Казань</li>
                                            <li class="custom-option" data-value="moscow">г. Москва</li>
                                            <li class="custom-option" data-value="kazan">г. Казань</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="custom-checkbox">
                                    <input class="custom-checkbox__input" type="checkbox" name="payment" value="" id="checkbox-1">
                                    <label class="custom-checkbox__label" for="checkbox-1">
                                        <span class="custom-checkbox__selector"></span>
                                        <span>С учетом содержимого корзины&nbsp;<i class="help-ico tooltip"
                                                                                   data-tippy-content="Для разных стикеров, имеющих одинаковый размер и форму, указывается количество вида макета."></i></span>
                                    </label>
                                </div>
                            </div>
                            <div class="pay-deliv-content__text">
                                <h3>Курьером в пределах МКАД</h3>
                                <table>
                                    <tr>
                                        <td>Вес заказа свыше 5 кг</td>
                                        <td>360 ₽</td>
                                    </tr>
                                    <tr>
                                        <td>Вес заказа свыше 5 кг</td>
                                        <td>890 ₽</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="pay-deliv-content__text">
                                <h3>Курьером за пределы МКАД*</h3>
                                <table>
                                    <tr>
                                        <td>Вес заказа свыше 5 кг</td>
                                        <td>от 890 ₽</td>
                                    </tr>
                                    <tr>
                                        <td>Вес заказа свыше 5 кг</td>
                                        <td>от 1400 ₽</td>
                                    </tr>
                                </table>
                                <p class="warning">
                                    *Точную стоимость курьерской доставки за пределы МКАД укажет наш менеджер.
                                </p>
                            </div>
                            <div class="pay-deliv-content__text">
                                <h3>Самовывоз из пунктов выдачи</h3>
                                <table>
                                    <tr>
                                        <td><i class="icon-metro"></i>&nbsp;Водный стадион, <a href="#">ул. Выборгская, 22, стр. 3↗</a></td>
                                        <td>Бесплатно</td>
                                    </tr>
                                    <tr>
                                        <td><i class="icon-metro"></i>&nbsp;Белорусская, <a href="#">Ленинградский просп., д. 2↗</a></td>
                                        <td>от 1400 ₽</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="pay-deliv-content__text">
                                <h3>Сроки доставки</h3>
                                <p>Доставим ваш заказ на следующий день после его выполнения.</p>
                                <p>Доплата за срочную доставку — 100% от стандартной стоимости доставки.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pure-u-1 pure-u-md-1-2">
                    <div class="p-d-part">
                        <div class="p-d-part__img">
                            <img src="/images/pay-card.png" alt="">
                        </div>
                        <h2 class="p-d-part__title">Оплата</h2>
                        <div class="pay-deliv-content">
                            <div class="pay-deliv-content__text pay-deliv-content__text_center">
                                <div class="pay-deliv-content__icon">
                                    <i class="icon-cp-corporate"></i>
                                </div>
                                <h3>Для юридических лиц</h3>
                                <p>Мы работаем по 100% предоплате и без НДС.</p>
                                <p>Вы можете прислать нам реквизиты компании<br/> на <a href="mailto:{{\App\Models\CommonSetting::first()->email}}"> наш электронный адрес</a> — мы выставим вам счет.</p>
                            </div>
                            <div class="pay-deliv-content__text pay-deliv-content__text_center">
                                <div class="pay-deliv-content__icon">
                                    <i class="icon-cp-personal"></i>
                                </div>
                                <h3>Для физических лиц</h3>
                                <p>Принимаем любые виды безналичных оплат: кредитными и депозитными картами, через электронные и<br/> онлайн-сервисы и т.д.</p>
                            </div>
                        </div>
                        <div class="pure-g pay-services">
                            <div class="pure-u-1-2 pure-u-lg-1-4">
                                <div class="pay-services__item"><img src="/images/logo/logo-mastercard.svg" alt="" width="60"></div>
                            </div>
                            <div class="pure-u-1-2 pure-u-lg-1-4">
                                <div class="pay-services__item"><img src="/images/logo/logo-visa.svg" alt="" width="80"></div>
                            </div>
                            <div class="pure-u-1-2 pure-u-lg-1-4">
                                <div class="pay-services__item"><img src="/images/logo/logo-qiwi.svg" alt="" width="99"></div>
                            </div>
                            <div class="pure-u-1-2 pure-u-lg-1-4">
                                <div class="pay-services__item"><img src="/images/logo/logo-yandex-money.svg" alt="" width="106"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
