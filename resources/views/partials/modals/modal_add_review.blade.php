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
                    <input hidden name="product_category" value="{{$product_category}}">
                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-2">
                            <div class="modal-form__field validation-group">
                                <input type="text" required class="input input_wide" name="name"
                                       placeholder="Ваше имя"
                                       data-pristine-required-message="Это поле обязательно для заполнения">
                            </div>
                            <div class="modal-form__field validation-group">
                                <input type="email" required class="input input_wide" name="email"
                                       placeholder="E-mail"
                                       data-pristine-required-message="Это поле обязательно для заполнения"
                                       data-pristine-email-message="Неправильный формат email">
                            </div>
                        </div>
                        <div class="pure-u-1 pure-u-md-1-2">
                            <div class="modal-form__field validation-group">
                                <div class="avatar-upload">
                                    <input class="avatar-upload__inp" required type="text" name="file_id"
                                           id="avatar"
                                           data-pristine-required-message="Это поле обязательно для заполнения">
                                    <div class="avatar-upload__content">
                                        <div class="avatar-upload__previews"></div>
                                        <div class="avatar-upload__dropzone-holder">
                                            <div class="avatar-upload__label">Аватар</div>
                                            <div class="dropzone avatar-upload__dropzone"></div>
                                        </div>
                                    </div>
                                    <div class="avatar-upload__accepted">Допустимые форматы файлов: JPG, GIF
                                        или PNG. 150✗150 px, максимум 1 MB.
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
                        <button class="btn btn_bg validation-submit" type="submit" disabled>Отправить отзыв</button>
                    </div>
                </form>
            </div>
            <div class="modal__close" data-micromodal-close><i class="icon-close"></i></div>
        </div>
    </div>
</div>