<?php

use App\Models\Pages\Block;
use App\Models\Pages\PageTemplate;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        DB::beginTransaction();

        try {
            Block::create([
                'alias' => 'main-page-categories',
                'content' => <<<HTML
            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='/pechat-nakleek' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-sticker-round'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Наклейки и стикеры</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-labels-rectangle-on-roll'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Рулонная этикетка</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='/pechat-katalogov' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-catalogs'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Каталоги</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='/pechat-bukletov' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-booklets-flyaers'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Буклеты и листовки</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='/vizitki' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-bc'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Визитки</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='/birki' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-tags'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Бирки и воблеры</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>


            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='/pechat-kalendarey' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-calendar-quarter-3springs'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Календари</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-wide-format'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Широкоформатная печать</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-flyer'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Листовки и флаеры</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-notepads'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Блокноты</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='/pechat-bannerov' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-banner'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Баннеры</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-rollup'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Роллапы</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>


            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-table'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Таблички</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-presentations'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Презентации</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-canvas'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Холсты</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-poster'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Плакаты и чертежи</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-certificate'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Благодарности, сертификаты</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-tag-hanger'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Хенгеры</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>


            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-letterhead'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Фирменные бланки</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-bages'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Бейджи</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-tag-price'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Ценники</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-postcard'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Открытки и приглашения</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='/pechat-konvertov' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-envelope'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Конверты</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>

            <div class='pure-u-1-3 pure-u-md-1-4 pure-u-lg-1-5 pure-u-xl-1-6 pure-u-xl-1-7'>
                <a href='#' class='preview'>
                    <div class='preview__img'>
                        <svg>
                            <use xlink:href='#icon-bags'></use>
                        </svg>
                    </div>
                    <span class='preview__name'>Пакеты</span>
                    <span class='preview__price'>от 350 ₽</span>
                </a>
            </div>
HTML
            ]);

            Block::create([
                'alias' => 'main-page-banners',
                'content' => <<<HTML
                <div class='swiper-slide'>
                    <div class='examples'>
                        <a class='examples__link' href=''>
                            <div class='examples__content'>
                                <div class='examples__title'>НОВИНКА!</div>
                                <div class='examples__text'>Печать этикеток<br> на рулоне&nbsp;→</div>
                            </div>
                            <img src='images/examples/roll.png' alt='img examples' class='examples__img'>
                        </a>
                    </div>
                </div>
                <div class='swiper-slide'>
                    <div class='examples'>
                        <a class='examples__link' href=''>
                            <div class='examples__content'>
                                <div class='examples__text'>Печать на радужной пленке<br> «Хром бензин»&nbsp;→</div>
                            </div>
                            <img src='images/examples/chrome film.png' alt='img examples'
                                 class='examples__img'>
                        </a>
                    </div>
                </div>
                <div class='swiper-slide'>
                    <div class='examples'>
                        <a class='examples__link' href=''>
                            <div class='examples__content'>
                                <div class='examples__text'>Скидка<br> за отзывы&nbsp;→</div>
                            </div>
                            <div class='examples__promo-text'>-10%</div>
                            <img src='images/examples/discount.png' alt='img examples'
                                 class='examples__img'>
                        </a>
                    </div>
                </div>
                <div class='swiper-slide'>
                    <div class='examples'>
                        <a class='examples__link' href=''>
                            <div class='examples__content'>
                                <div class='examples__title'>Печать фольгой</div>
                                <div class='examples__text'>Больше 20-ти цветов<br> для нанесения&nbsp;→</div>
                            </div>
                            <img src='images/examples/foil.png' alt='img examples' class='examples__img'>
                        </a>
                    </div>
                </div>
                <div class='swiper-slide'>
                    <div class='examples'>
                        <a class='examples__link' href=''>
                            <div class='examples__content'>
                                <div class='examples__text'>Конструктор визиток&nbsp;→</div>
                            </div>
                            <img src='images/examples/constructor.png' alt='img examples'
                                 class='examples__img'>
                        </a>
                    </div>
                </div>
HTML
            ]);

            PageTemplate::where('alias', '=', 'main-page')
                ->first()
                ->update([
                    'template' => <<<TEMP
<section class='section-categories'>
    <div class='container'>
        <h1 class='page-title page-title_center'>
            Привет! Давайте печатать
            <i class='icon-cp-stickers'></i>
        </h1>

        <div class='pure-g pure-g-preview' data-id='preview'>
            @block('main-page-categories')
        </div>

        <button class='show-more' type='button' data-btn='show-more'>
            Показать все категории
        </button>

        <!-- Slider main container -->
        <div class='swiper-container swiper-mobile'>
            <!-- Additional required wrapper -->
            <div class='swiper-wrapper'>
                <!-- Slides -->
                @block('main-page-banners')
            </div>
            <!-- If we need pagination -->
            <div class='swiper-pagination'></div>
        </div>
    </div>
</section>
<section>
    <div class='container mt-5'>
        <h2 class='block-title block-title-example block-title_center'>
            <a class='link link_arrows-top' href='#'>
                <img src='images/logo/logo-instagram-gradient.svg' alt='instagram'>
                <span>Примеры работ</span>
            </a>
        </h2>
        <div class='pure-g pure-g_plate'>
            <div class='pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4'>
                <div class='examples'>
                    <a class='examples__link' href=''>
                        <img src='images/examples/2.jpg' alt='img examples' class='examples__img'>
                    </a>
                </div>
            </div>
            <div class='pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4'>
                <div class='examples'>
                    <a class='examples__link' href=''>
                        <img src='images/examples/1.jpg' alt='img examples' class='examples__img'>
                    </a>
                </div>
            </div>
            <div class='pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4'>
                <div class='examples'>
                    <a class='examples__link' href=''>
                        <img src='images/examples/2.jpg' alt='img examples' class='examples__img'>
                    </a>
                </div>
            </div>
            <div class='pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4'>
                <div class='examples'>
                    <a class='examples__link' href=''>
                        <img src='images/examples/1.jpg' alt='img examples' class='examples__img'>
                    </a>
                </div>
            </div>
            <div class='pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4'>
                <div class='examples'>
                    <a class='examples__link' href=''>
                        <img src='images/examples/2.jpg' alt='img examples' class='examples__img'>
                    </a>
                </div>
            </div>
            <div class='pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4'>
                <div class='examples'>
                    <a class='examples__link' href=''>
                        <img src='images/examples/1.jpg' alt='img examples' class='examples__img'>
                    </a>
                </div>
            </div>
            <div class='pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4'>
                <div class='examples'>
                    <a class='examples__link' href=''>
                        <img src='images/examples/2.jpg' alt='img examples' class='examples__img'>
                    </a>
                </div>
            </div>
            <div class='pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4'>
                <div class='examples'>
                    <a class='examples__link' href=''>
                        <img src='images/examples/1.jpg' alt='img examples' class='examples__img'>
                    </a>
                </div>
            </div>
            <div class='hidden visible-md hidden-lg pure-u-md-1-3'>
                <div class='examples'>
                    <a class='examples__link' href=''>
                        <img src='images/examples/1.jpg' alt='img examples' class='examples__img'>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class='container'>
        <h2 class='block-title block-title_center'>
            <a class='link link_arrows' href='#'><span>Благодарности клиентов</span></a>
        </h2>
        <!-- Slider main container -->
        <div class='swiper-container swiper-reviews'>
            <!-- Additional required wrapper -->
            <div class='swiper-wrapper'>
                <!-- Slides -->
                <div class='swiper-slide'>
                    <div class='reviews'>
                        <div class='reviews__top'>
                            <img class='reviews__img' src='images/avatar.png' alt='photo'>
                            <div class='reviews__author'>Елена Никитина</div>
                        </div>
                        <div class='reviews__text'>
                            <p>
                                «Нам очень понравилось качество наклеек, которые мы делали в Coral Print. Кроме
                                этого заказ был
                                сделан в сжатые сроки и ребята все успели. Будем с большим удовольствием
                                работать
                                в дальнейшем!».
                            </p>
                        </div>
                        <img src='images/logo/logo-mail.svg' class='reviews__logo' alt='logo company'>
                    </div>
                </div>
                <div class='swiper-slide'>
                    <div class='reviews'>
                        <div class='reviews__top'>
                            <img class='reviews__img' src='images/examples/2.jpg' alt='photo'>
                            <div class='reviews__author'>Иван Куйбеда</div>
                        </div>
                        <div class='reviews__text'>
                            <p>
                                «Два раза заказывали наборы стикеров для размещения в торговых точках. Заказы
                                были
                                срочные, но все этапы отгрузок были произведены по плану.Спасибо за слаженную
                                и стабильную работу, все понравилось, будем сотрудничать в будущем».
                            </p>
                        </div>
                        <img src='images/logo/logo-wildberry.svg' class='reviews__logo' alt='logo company'>
                    </div>
                </div>
                <div class='swiper-slide'>
                    <div class='reviews'>
                        <div class='reviews__top'>
                            <img class='reviews__img' src='images/examples/1.jpg' alt='photo'>
                            <div class='reviews__author'>Эпифаний Орбитальный</div>
                        </div>
                        <div class='reviews__text'>
                            <p>
                                «Братушки, мое вам космическое почтение! Когда не спасла даже синяя изолента,
                                ваши
                                стикеры —
                                выручили! Воздух не уходит вот уже две недели. Отдельное спасибо за оперативную
                                и бережную
                                доставку».
                            </p>
                        </div>
                        <img src='images/logo/logo-ros.svg' class='reviews__logo' alt='logo company'>
                    </div>
                </div>
            </div>
            <!-- If we need navigation buttons -->
            <div class='swiper-button-prev'>
                <img src='images/icon/icon-arrows-l.svg' alt='arrows left'>
            </div>
            <div class='swiper-button-next'>
                <img src='images/icon/icon-arrows-r.svg' alt='arrows right'>
            </div>
        </div>
    </div>
</section>
<section>
    <div class='container'>
        <div class='are-experts'>
            <div class='are-experts__text'>
                <h3 class='are-experts__title'>
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
            <div class='are-experts__img'>
                <picture>
                    <source media='(min-width:1920px)' srcset='images/plate-xxl.png'>
                    <source media='(min-width:1280px)' srcset='images/plate-xl.png'>
                    <source media='(min-width:1024px)' srcset='images/plate-lg.png'>
                    <source media='(min-width:568px)' srcset='images/plate-sm.png'>
                    <img src='images/plate.png' alt='img'>
                </picture>
            </div>
        </div>
    </div>
</section>
<section>
    <div class='container'>
        <div class='bottom-text-wrap'>
            <div class='bottom-text'>
                @content
            </div>
        </div>
    </div>
</section>
TEMP
                ]);

            DB::commit();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }
};
