<div class="modal" id="back-call" aria-hidden="true">
    <div tabindex="-1" class="modal__overlay" data-micromodal-close>
        <div class="modal__holder modal__holder_back-call" role="dialog" aria-modal="true">
            <div class="modal__content">
                <div class="back-call">
                    <h2 class="back-call__title">Ваш телефон</h2>
                    <form id="back-call-from" action="#" method="post">
                        @csrf
                        <div class="back-call__input-holder">
                            <input class="input phone-mask" name="phone" placeholder="+7 (___) ___-__-__">
                        </div>
                        <button class="btn btn_bg" onclick="document.getElementById('back-call').classList.remove('is-open');
                        document.location.reload();">Заказать</button>
                    </form>
                    <div class="back-call__success" style="display: none">
                        <div class="back-call__ico"><i class="icon-calling"></i></div>
                        <div class="back-call__text">Уже звоним вам!</div>
                    </div>
                </div>
            </div>
            <div class="modal__close" data-micromodal-close><i class="icon-close"></i></div>
        </div>
    </div>
</div>
<div class="modal modal_wide" id="order-modal" aria-hidden="true">
    <div tabindex="-1" class="modal__overlay" data-micromodal-close>
        <div class="modal__holder modal__holder_order" role="dialog" aria-modal="true">
            <div class="modal__content">
                <div class="modal__title">Сделать заказ</div>
                <form class="modal-form form-validation" action="#" id="modal-order-form">
                    @csrf
                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-2">
                            <div class="modal-form__field validation-group">
                                <input type="text" required class="input input_wide" name="name" placeholder="Ваше имя"
                                       data-pristine-required-message="Это поле обязательно для заполнения">
                            </div>
                            <div class="modal-form__field validation-group">
                                <input type="email" required class="input input_wide" name="email" placeholder="E-mail"
                                       data-pristine-required-message="Это поле обязательно для заполнения"
                                       data-pristine-email-message="Неправильный формат email">
                            </div>
                            <div class="modal-form__field validation-group">
                                <textarea type="text" required class="input input_area input_wide" cols="1" rows="6"
                                          name="message" placeholder="Что вы хотите заказать?"
                                          data-pristine-required-message="Это поле обязательно для заполнения"></textarea>
                            </div>
                        </div>
                        <div class="pure-u-1 pure-u-md-1-2">
                            <div class="modal-form__title">Файлы</div>
                            <div class="modal-form__field">
                                <div class="files-upload files-upload_vertical" data-type="order-photos">
                                    <input class="files-upload__inp" type="text" name="privileges-photo"
                                           id="privileges-photo">
                                    <div class="files-upload__dropzone-holder">
                                        <div class="files-upload__accepted files-upload__accepted_mob">Если вам нужно
                                            отправить нам макет. Максимальный объем одного файла — 100 МВ. Допустимые
                                            форматы
                                            файлов: jpg, png, tif, svg, pdf, ai, psd
                                        </div>
                                        <div class="dropzone files-upload__dropzone">
                                            <span class="hidden-md">Загрузить файлы</span>
                                        </div>
                                        <div class="files-upload__accepted files-upload__accepted_dt">Допустимые форматы
                                            файлов: jpg, png, tif, svg, pdf, ai, psd
                                        </div>
                                    </div>
                                    <div class="files-upload__content">
                                        <div class="files-upload__title">
                                            Загруженные файлы:
                                        </div>
                                        <div class="files-upload__previews"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-form__bottom-agree">
                        <div class="validation-group">
                            <div class="custom-checkbox custom-checkbox_center-align">
                                <input class="custom-checkbox__input" required type="checkbox" name="agree-personal"
                                       value="" id="agree-personal" data-pristine-required-message=" ">
                                <label class="custom-checkbox__label" for="agree-personal">
                                    <span class="custom-checkbox__selector"></span>
                                    <span>Нажимая кнопку«Отравить заявку» вы соглашаетесь с условиями политики конфиденциальности</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal__footer">
                        <button class="btn btn_bg validation-submit" disabled onclick="document.getElementById('order-modal').classList.remove('is-open');
                        document.location.reload();">Отправить заявку</button>
                    </div>
                </form>
            </div>
            <div class="modal__close" data-micromodal-close><i class="icon-close"></i></div>
        </div>
    </div>
</div>
<div class="modal modal_wide" id="add-review" aria-hidden="true">
    <div tabindex="-1" class="modal__overlay" data-micromodal-close>
        <div class="modal__holder modal__holder_order" role="dialog" aria-modal="true">
            <div class="modal__content">
                <div class="modal__title">Как получить скидку за отзыв</div>
                <ul class="add-review-intro">
                    <li>1. Заполните все поля (включая аватар) формы ниже.</li>
                    <li>2. Мы пришлем промо-код скидки на указанную вами почту.</li>
                    <li>3. Код можно использовать один раз при заказе с сайта.</li>
                </ul>
                <form class="modal-form form-validation" action="/send_review" method="post" id="review-form">
                    @csrf
                    <input hidden name="calculator_type_id" value="{{$calculatorTypeId ?? ''}}">
                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-2">
                            <div class="modal-form__field validation-group">
                                <input type="text" required class="input input_wide" name="name" placeholder="Ваше имя"
                                       data-pristine-required-message="Это поле обязательно для заполнения">
                            </div>
                            <div class="modal-form__field validation-group">
                                <input type="email" required class="input input_wide" name="email" placeholder="E-mail"
                                       data-pristine-required-message="Это поле обязательно для заполнения"
                                       data-pristine-email-message="Неправильный формат email">
                            </div>
                        </div>
                       <div class="pure-u-1 pure-u-md-1-2">
                            <div class="modal-form__field validation-group">
                                <div class="avatar-upload">
                                    <input class="avatar-upload__inp"  type="text" name="file_id" id="avatar"
                                           >
                                    <div class="avatar-upload__content">
                                        <div class="avatar-upload__previews"></div>
                                        <div class="avatar-upload__dropzone-holder">
                                            <div class="avatar-upload__label">Аватар</div>
                                            <div class="dropzone avatar-upload__dropzone"></div>
                                        </div>
                                    </div>
                                    <div class="avatar-upload__accepted">Допустимые форматы файлов: JPG, GIF или PNG.
                                        150✗150 px, максимум 1 MB.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rating-select modal-form__rating-select" data-init-val="5">
                        <input type="hidden" class="rating-select__inp" name="rate">
                        <div class="rating-select__label">Ваша оценка</div>
                        <div class="rating-select__stars">
                            <i class="icon-star" data-val="1"></i>
                            <i class="icon-star" data-val="2"></i>
                            <i class="icon-star" data-val="3"></i>
                            <i class="icon-star" data-val="4"></i>
                            <i class="icon-star" data-val="5"></i>
                        </div>
                    </div>

                    <div class="modal-form__field validation-group">
                        <input type="text" required class="input input_wide" name="title"
                               placeholder="Ваше общее впечатление о заказе"
                               data-pristine-required-message="Это поле обязательно для заполнения">
                    </div>

                    <div class="modal-form__field validation-group">
                        <textarea type="text" required class="input input_area input_wide" cols="1" rows="6"
                                  id="comment" name="comment" placeholder="Ваш отзыв (до 1000 символов)"
                                  data-pristine-required-message="Это поле обязательно для заполнения"></textarea>
                    </div>
                    <div class="char-counter char-counter_right" data-char-counter="comment" data-max="1000"></div>

                    <div class="modal-form__bottom-btn">
                        <button class="btn btn_bg validation-submit" type="submit" disabled
                        >Отправить отзыв</button>
                    </div>
                </form>
            </div>
            <div class="modal__close" data-micromodal-close><i class="icon-close"></i></div>
        </div>
    </div>
</div>


<div class="modal" id="thanks" aria-hidden="false">
    <div tabindex="-1" class="modal__overlay" data-micromodal-close>
        <div class="modal__holder" role="dialog" aria-modal="true">
            <div class="modal__content">
                <div class="modal__title">Спасибо!</div>
                <p class="text-center">
                <svg width="50" height="59" viewBox="0 0 50 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M40.1595 40.4492C37.3736 43.2251 33.5275 44.9345 29.2937 44.9345C20.7664 44.9345 13.8543 38.0224 13.8543 29.5052C13.8543 20.9779 20.7664 14.0758 29.2937 14.0758C33.5473 14.0758 37.4097 15.8013 40.1986 18.5902L50 8.78887C49.6217 8.4106 49.2341 8.04371 48.8377 7.68845C43.4833 2.89 36.5233 0.211426 29.2937 0.211426C13.112 0.211426 0 13.3234 0 29.5052C0 45.6769 13.112 58.7889 29.2937 58.7889C36.5238 58.7889 43.4841 56.1187 48.8386 51.3128C49.2216 50.9691 49.5963 50.6145 49.9623 50.2491C49.9749 50.2366 49.9874 50.224 50 50.2114L40.1986 40.4101C40.1856 40.4231 40.1725 40.4362 40.1595 40.4492ZM40.1472 42.6214C37.2011 45.0674 33.4124 46.5345 29.2937 46.5345C19.8835 46.5345 12.2543 38.9067 12.2543 29.5052C12.2543 20.0929 19.8841 12.4758 29.2937 12.4758C33.4122 12.4758 37.2 13.9427 40.1454 16.3807L47.7045 8.82161C42.6515 4.32203 36.0987 1.81143 29.2937 1.81143C13.9956 1.81143 1.6 14.207 1.6 29.5052C1.6 44.7929 13.9953 57.1889 29.2937 57.1889C36.1006 57.1889 42.6534 54.6856 47.7055 50.1797L40.1472 42.6214Z" fill="#00195A"/>
                    <path d="M37.774 23.1411C35.8334 21.3126 32.5082 20.8953 29.5 23.9034C26.4962 20.8982 23.1666 21.3126 21.226 23.1396C18.9655 25.2674 18.9256 28.8271 21.1051 31.0066L29.5 39.403L37.8949 31.0081C40.0744 28.8286 40.0345 25.2689 37.774 23.1411ZM36.8524 29.9641L29.5 37.3179L22.1476 29.9655C20.5521 28.3685 20.5831 25.7718 22.2376 24.2146C22.9424 23.5481 23.8862 23.1824 24.8948 23.1824C27.0064 23.1824 27.9561 24.4446 29.5 25.9885C31.0026 24.4859 31.97 23.1824 34.1052 23.1824C35.1138 23.1824 36.0576 23.5481 36.7639 24.2131C38.414 25.7673 38.4523 28.3641 36.8524 29.9641Z" fill="#00195A"/>
                </svg>
                </p>
                <p class="text-center">
                    Ваше мнение поможет нам все делать <br/>
                    правильно и становиться лучше. Пришлем <br/>
                    промо-код на  указанную вами почту <br/>
                    в течение 2-х дней.
                </p>
            </div>
            <div class="modal__close" data-micromodal-close onclick="document.location.reload()"><i class="icon-close"></i></div>
        </div>
    </div>
</div>
