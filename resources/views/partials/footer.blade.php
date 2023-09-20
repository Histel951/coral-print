<div class="container">
    <div class="footer__search">
        <a href="/" class="logo hidden visible-lg">
            <picture>
                <source srcset="{{asset('images/logo/logo-blue.svg')}}" media="(min-width: 1280px)">
                <img src="{{asset('images/logo/logo-vertical-blue-1.svg')}}" alt="logo coral print">
            </picture>
        </a>
        <form class="form form_search">
            <label class="form__label">
                <button type="submit">
                    <i class="icon-cp-search"></i>
                </button>
                <input type="text" placeholder="Поиск по сайту">
            </label>
        </form>
        <div class="btn-group">
            <button class="btn btn_border btn-call" data-micromodal-trigger="back-call">
                <i class="icon-cp-call-us hidden-lg visible-xl"></i>
                Заказать звонок
            </button>
            <button class="btn btn_bg btn-order" data-micromodal-trigger="order-modal">
                <i class="icon-cp-make-order hidden-lg visible-xl"></i>
                Сделать заказ
            </button>
        </div>
    </div>
    <div class="accordion">
        <div class="accordion__item">
            <h2 class="accordion__btn" data-accordion="accor-footer">
                <i class="icon-cp-rub hidden visible-lg"></i>
                Прайс-лист
                <span class="plus hidden-lg"></span>
            </h2>
            <div class="accordion__content">
                <ul class="product-list">
                    @foreach($childItems as $item)
                        <li><a href="/{{$item->url}}">{{$item->page_title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="accordion__item">
            <h2 class="accordion__btn" data-accordion="accor-footer">
                Cервис
                <span class="plus hidden-lg"></span>
            </h2>
            <div class="accordion__content">
                <ul>
                    <li><a href="#">Первая цифровая типография Coral‑Print</a></li>
                    <li><a href="#"> Требования к макетам</a></li>
                    <li><a href="#">Доставка и оплата</a></li>
                    <li><a href="#">Карта сайта</a></li>
                    <li><a href="#">Политика конфиденциальности</a></li>
                    <li><a href="#">Использование cookies</a></li>
                </ul>
            </div>
        </div>
        <div class="accordion__item">
            <h2 class="accordion__btn" data-accordion="accor-footer">
                Контакты
                <span class="plus hidden-lg"></span>
            </h2>
            <div class="accordion__content">
                <div class="contact-block">
                    <a href="tel:{{$settings->phone}}" class="link link_phone">{{$settings->phone}}</a>
                    <a href="mailto:{{$settings->email}}" class="link link_email">{{$settings->email}}</a>
                    <ul class="social">
                        <li class="social__item">
                            <a href="{{$settings->instagram_link}}">
                                <i class="icon-cp-instagram"></i>
                            </a>
                        </li>
                        <li class="social__item">
                            <a href="{{$settings->vk_link}}">
                                <i class="icon-cp-vkontakte"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="contact-block">
                    <h5>Отделения в Москве</h5>
                    <ul class="address">
                        @foreach($departments as $department)
                        <li class="address__item">
                            <p>{{$department->address}}</p>
                            @isset($department->metro)
                                <p>
                                    <img src="{{asset('images/icon/icon-metro.svg')}}" alt="icon metro">
                                    {{$department->metro}}
                                </p>
                            @endisset
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="contact-block">
                    <h5>Реквизиты</h5>
                    <p>
                        {!! $settings->bank_details !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__copy">
        <p>© 2009-2017 Coral-print – Визитки в Москве. Все права на тексты, схемы, иллюстрации и фотографии,
            размещенные на этом сайте, принадлежат ООО «Корал-Принт». Полное и (или) частичное копирование,
            воспроизведение и использование в любом виде запрещены и преследуются в соответствии с действующим
            законодательством Российской Федерации.</p>
        <a class="dda" href="https://ddaproduction.com/">
            <img class="dda__logo" src="{{asset('images/logo/logo-DDA.svg')}}" alt="Сделано в DDA Production">
            <span class="dda__text">Сделано в DDA Production</span>
        </a>
    </div>
</div>
