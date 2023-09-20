<div class="header__gradient">
    <div class="header__top">
        <a href="/" class="logo">
            <img src="{{asset('images/logo/logo-horizontal.svg')}}" alt="logo coral print">
        </a>
        <div class="contact">
            <a href="tel:{{$settings->phone}}" class="contact__phone phone">
                <span class="phone__text hidden visible-md hidden-lg visible-xl">{{$settings->phone}}</span>
                <img class="phone__icon hidden-md visible-lg hidden-xl" src="{{asset('images/icon/icon-phone.svg')}}"
                     alt="icon-phone">
            </a>
            <a href="mailto:{{$settings->email}}" class="contact__email email">
                <span class="email__text hidden visible-md hidden-lg visible-xl">{{$settings->email}}</span>
                <img class="email__icon hidden-md visible-lg hidden-xl" src="{{asset('images/icon/icon-email.svg')}}"
                     alt="icon-phone">
            </a>
            <button class="btn btn_border btn_border-white" type="button" data-micromodal-trigger="back-call">
                <i class="icon-cp-call-us hidden visible-lg"></i>
                Заказать звонок
            </button>
        </div>

        <button class="btn-menu" data-id="btn-menu">
                        <span class="btn-menu__burger" data-id="btn-burger">
                    <span></span>
                        </span>
            <span class="btn-menu__text hidden visible-md">меню</span>
        </button>

        <div id="cart-icon"></div>
    </div>
</div>
<div class="header__background">
    @include('partials.main-menu')
</div>
