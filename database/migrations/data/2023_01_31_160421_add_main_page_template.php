<?php

use App\Models\Content;
use App\Models\Pages\PageTemplate;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        DB::beginTransaction();

        try {
            $mainPageTemplate = PageTemplate::create([
                'name' => 'Главная',
                'alias' => 'main-page',
                'template' => <<<'TEMP'
<section class="section-categories">
    <div class="container">
        <h1 class="page-title page-title_center">
            Привет! Давайте печатать
            <i class="icon-cp-stickers"></i>
        </h1>
        <div class="pure-g pure-g-preview" data-id="preview">
            <!-- Categories -->
            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="/pechat-nakleek" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-sticker-round"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Наклейки и стикеры</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-labels-rectangle-on-roll"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Рулонная этикетка</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="/pechat-katalogov" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-catalogs"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Каталоги</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="/pechat-bukletov" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-booklets-flyaers"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Буклеты и листовки</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="/vizitki" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-bc"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Визитки</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="/birki" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-tags"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Бирки и воблеры</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>


            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="/pechat-kalendarey" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-calendar-quarter-3springs"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Календари</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-wide-format"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Широкоформатная печать</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-flyer"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Листовки и флаеры</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-notepads"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Блокноты</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="/pechat-bannerov" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-banner"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Баннеры</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-rollup"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Роллапы</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>


            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-table"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Таблички</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-presentations"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Презентации</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-canvas"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Холсты</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-poster"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Плакаты и чертежи</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-certificate"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Благодарности, сертификаты</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-tag-hanger"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Хенгеры</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>


            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-letterhead"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Фирменные бланки</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-bages"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Бейджи</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-tag-price"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Ценники</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-postcard"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Открытки и приглашения</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="/pechat-konvertov" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-envelope"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Конверты</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

            <div class="pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7">
                <a href="#" class="preview">
                    <div class="preview__img">
                        <svg>
                            <use xlink:href="#icon-bags"></use>
                        </svg>
                    </div>
                    <span class="preview__name">Пакеты</span>
                    <span class="preview__price">от 350 ₽</span>
                </a>
            </div>

        </div>

        <button class="show-more" type="button" data-btn="show-more">
            Показать все категории
        </button>

        <!-- Slider main container -->
        <div class="swiper-container swiper-mobile">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide">
                    <div class="examples">
                        <a class="examples__link" href="">
                            <div class="examples__content">
                                <div class="examples__title">НОВИНКА!</div>
                                <div class="examples__text">Печать этикеток<br> на рулоне&nbsp;→</div>
                            </div>
                            <img src="{{asset('images/examples/roll.png')}}" alt="img examples" class="examples__img">
                        </a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="examples">
                        <a class="examples__link" href="">
                            <div class="examples__content">
                                <div class="examples__text">Печать на радужной пленке<br> «Хром бензин»&nbsp;→</div>
                            </div>
                            <img src="{{asset('images/examples/chrome film.png')}}" alt="img examples"
                                 class="examples__img">
                        </a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="examples">
                        <a class="examples__link" href="">
                            <div class="examples__content">
                                <div class="examples__text">Скидка<br> за отзывы&nbsp;→</div>
                            </div>
                            <div class="examples__promo-text">-10%</div>
                            <img src="{{asset('images/examples/discount.png')}}" alt="img examples"
                                 class="examples__img">
                        </a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="examples">
                        <a class="examples__link" href="">
                            <div class="examples__content">
                                <div class="examples__title">Печать фольгой</div>
                                <div class="examples__text">Больше 20-ти цветов<br> для нанесения&nbsp;→</div>
                            </div>
                            <img src="{{asset('images/examples/foil.png')}}" alt="img examples" class="examples__img">
                        </a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="examples">
                        <a class="examples__link" href="">
                            <div class="examples__content">
                                <div class="examples__text">Конструктор визиток&nbsp;→</div>
                            </div>
                            <img src="{{asset('images/examples/constructor.png')}}" alt="img examples"
                                 class="examples__img">
                        </a>
                    </div>
                </div>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<section>
    <div class="container mt-5">
        <h2 class="block-title block-title-example block-title_center">
            <a class="link link_arrows-top" href="#">
                <img src="images/logo/logo-instagram-gradient.svg" alt="instagram">
                <span>Примеры работ</span>
            </a>
        </h2>
        <div class="pure-g pure-g_plate">
            <div class="pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4">
                <div class="examples">
                    <a class="examples__link" href="">
                        <img src="images/examples/2.jpg" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4">
                <div class="examples">
                    <a class="examples__link" href="">
                        <img src="images/examples/1.jpg" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4">
                <div class="examples">
                    <a class="examples__link" href="">
                        <img src="images/examples/2.jpg" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4">
                <div class="examples">
                    <a class="examples__link" href="">
                        <img src="images/examples/1.jpg" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4">
                <div class="examples">
                    <a class="examples__link" href="">
                        <img src="images/examples/2.jpg" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4">
                <div class="examples">
                    <a class="examples__link" href="">
                        <img src="images/examples/1.jpg" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4">
                <div class="examples">
                    <a class="examples__link" href="">
                        <img src="images/examples/2.jpg" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4">
                <div class="examples">
                    <a class="examples__link" href="">
                        <img src="images/examples/1.jpg" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
            <div class="hidden visible-md hidden-lg pure-u-md-1-3">
                <div class="examples">
                    <a class="examples__link" href="">
                        <img src="images/examples/1.jpg" alt="img examples" class="examples__img">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <h2 class="block-title block-title_center">
            <a class="link link_arrows" href="#"><span>Благодарности клиентов</span></a>
        </h2>
        <!-- Slider main container -->
        <div class="swiper-container swiper-reviews">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide">
                    <div class="reviews">
                        <div class="reviews__top">
                            <img class="reviews__img" src="images/avatar.png" alt="photo">
                            <div class="reviews__author">Елена Никитина</div>
                        </div>
                        <div class="reviews__text">
                            <p>
                                «Нам очень понравилось качество наклеек, которые мы делали в Coral Print. Кроме
                                этого заказ был
                                сделан в сжатые сроки и ребята все успели. Будем с большим удовольствием
                                работать
                                в дальнейшем!».
                            </p>
                        </div>
                        <img src="images/logo/logo-mail.svg" class="reviews__logo" alt="logo company">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="reviews">
                        <div class="reviews__top">
                            <img class="reviews__img" src="images/examples/2.jpg" alt="photo">
                            <div class="reviews__author">Иван Куйбеда</div>
                        </div>
                        <div class="reviews__text">
                            <p>
                                «Два раза заказывали наборы стикеров для размещения в торговых точках. Заказы
                                были
                                срочные, но все этапы отгрузок были произведены по плану.Спасибо за слаженную
                                и стабильную работу, все понравилось, будем сотрудничать в будущем».
                            </p>
                        </div>
                        <img src="images/logo/logo-wildberry.svg" class="reviews__logo" alt="logo company">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="reviews">
                        <div class="reviews__top">
                            <img class="reviews__img" src="images/examples/1.jpg" alt="photo">
                            <div class="reviews__author">Эпифаний Орбитальный</div>
                        </div>
                        <div class="reviews__text">
                            <p>
                                «Братушки, мое вам космическое почтение! Когда не спасла даже синяя изолента,
                                ваши
                                стикеры —
                                выручили! Воздух не уходит вот уже две недели. Отдельное спасибо за оперативную
                                и бережную
                                доставку».
                            </p>
                        </div>
                        <img src="images/logo/logo-ros.svg" class="reviews__logo" alt="logo company">
                    </div>
                </div>
            </div>
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev">
                <img src="images/icon/icon-arrows-l.svg" alt="arrows left">
            </div>
            <div class="swiper-button-next">
                <img src="images/icon/icon-arrows-r.svg" alt="arrows right">
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="are-experts">
            <div class="are-experts__text">
                <h3 class="are-experts__title">
                    Мы эксперты в полиграфии и ответим на любые профессиональные вопросы
                </h3>
                <p>
                    Лучшая цифровая типография мира*.
                </p>
                <p>
                    У нас огромный опыт обработки сложных заказов. Говорим строго
                    по делу и не навязываем лишних услуг. Обращайтесь — мы всегда рады помочь.
                </p>
                <span>*По мнению витиной мамы</span>
            </div>
            <div class="are-experts__img">
                <picture>
                    <source media="(min-width:1920px)" srcset="images/plate-xxl.png">
                    <source media="(min-width:1280px)" srcset="images/plate-xl.png">
                    <source media="(min-width:1024px)" srcset="images/plate-lg.png">
                    <source media="(min-width:568px)" srcset="images/plate-sm.png">
                    <img src="images/plate.png" alt="img">
                </picture>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="bottom-text-wrap">
            <div class="bottom-text">
                @content
            </div>
        </div>
    </div>
</section>
TEMP,
            ]);

            Content::create([
                'content_id' => 1,
                'parent' => 2668,
                'alias' => 'main',
                'title' => 'Главная',
                'url' => '/',
                'page_template_id' => $mainPageTemplate->id,
                'is_production' => false,
                'content' => <<<'CONT'
<h2>Почему клиенты выбирают работу с нами?</h2>
<p>Все просто. У нас:</p>
<ul>
    <li>Лучшая цена и профессиональное качество</li>
    <li>Простота выбора и заказа на сайте</li>
    <li>Высокая скорость загрузки макетов в облачное хранилище</li>
    <li>Возможность получить готовый заказ любым способом</li>
    <li>Скидки для постоянных клиентов</li>
</ul>
<h3>Уникальные возможности типографии Coral Print</h3>
<p>
    Укрепление имиджа компании, создание фирменного стиля, увеличение количества клиентов –
    помочь с
    решением любых ваших задач смогут специалисты типографии Coral Print простым материалом -
    бумагой. Мы превращаем безликую бумажную продукцию в эффективный носитель рекламных
    изображений
    и текстов.
</p>
<img src="images/examples/2.jpg" alt="img">

<p>
    Создание визиток и изготовление деловой или рекламной полиграфии методом шелкографии,
    цифровой,
    офсетной и других видов печати - хорошо отработанный процесс, для которого мы используем:
</p>
<ul>
    <li>профессиональный опыт наших дизайнеров и других специалистов;</li>
    <li>высококачественную печатную бумагу различных типов;</li>
    <li>качественные краски, которые позволяют напечатать изображения красочно и четко;</li>
    <li>современное полиграфическое оборудование (Konika-minolta, Riso RP, Canon);</li>
    <li>уникальные технологии обработки после печати (стильное оформление углов, ламинирование,
        тиснение, конгревное тиснение, вырубка).
    </li>
</ul>
<p>
    Красочные фото, рекламные тексты или яркие элементы фирменного стиля - мы перенесем на
    бумагу
    любое изображение, чтобы изготовить для вас визитки и другую качественную полиграфию любого
    тиража и формата.
</p>

<img src="images/examples/3.jpg" alt="img">
<p>
    Типография Coral Print предлагает изготовление визиток на заказ, а также другие варианты
    сотрудничества, обеспечивая:
</p>
<ul>
    <li>оперативное выполнение заказа</li>
    <li>высокое качество печати</li>
    <li>все виды полиграфических услуг (дизайн, печать, обработка после печати)</li>
    <li>выгодные условия оплаты</li>
    <li>скидки клиентам-партнерам</li>
    <li>доставку продукции в ваш офис или на дом</li>
</ul>

<h2>Заказ полиграфической продукции, в том числе визиток</h2>
<h4>У вас уже есть идея, но вы не знаете, как ее оформить?</h4>
<p>
    Покажите, как выглядят ваши варианты оформления визиток (или другие макеты) лично, в нашем
    офисе
    или пришлите макеты по почте. Наши дизайнеры отлично понимают клиентов и используют эту
    информацию и наброски оформления для разработки дизайна визитных карточек с нуля или
    оперативной
    корректировки макетов.
</p>
<h4>Вы уже создали готовый макет, соответствующий минимальным необходимым требованиям?</h4>
<p>
    Закажите необходимый тираж визиток или другой полиграфической продукции прямо из своего
    офиса.
    Оформите заказ онлайн, приложив ТЗ и макет к заявке на сайте.
</p>
<h2>Первая цифровая типография – офисы в Москве</h2>
<p>
    У вас не только есть возможность заказать эксклюзивный дизайн, но и наблюдать все этапы
    изготовления заказа. К вашим услугам - уютные офисы, доброжелательные сотрудники,
    возможность
    создать собственный макет вместе с нами и другие эксклюзивные предложения VIP-клиентов.
</p>
<h3>
    Вы хотите получить готовый заказ уже сегодня?
</h3>
<p>
    Всего 15 минут ожидания - и вы сможете использовать ваши фирменные визитки, листовки,
    плакаты
    или буклеты по их прямому назначению. Мы ждем вас по будням с 10-00 до 19-00 по адресу
    Москва,
    м. Водный стадион, Выборгская ул. 22 стр. 3. Вход с фасада здания.
</p>
<h3>
    Визитки и другие виды типографской продукции
</h3>
<p>
    Мы найдем оптимальные способы решения ваших задач, с помощью оригинального дизайна и
    высококачественных технологий печати изготовив деловую или рекламную полиграфию любого типа
    и
    формата.
</p>
<p>
    В типографии Coral Print вы можете заказать срочную цифровую или офсетную печать:
</p>

<ul>
    <li><a href="#">визитки с теснением</a></li>
    <li><a href="#">VIP визитки</a></li>
    <li><a href="#">визитки с доставкой</a></li>
    <li><a href="#">визитки с цифровой печатью</a></li>
    <li><a href="#">баннеры</a></li>
    <li><a href="#">бланки и каталоги</a></li>
    <li><a href="#">листовки и открытки</a></li>
    <li><a href="#">приглашения</a></li>
    <li><a href="#">свадебная полиграфия</a></li>
    <li><a href="#">свадебная типография</a></li>
    <li><a href="#">свадебная печать</a></li>
    <li><a href="#">другие виды полиграфии</a></li>
</ul>
CONT,
            ]);

            DB::commit();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }
};
