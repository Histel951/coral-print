import Tabby from 'tabbyjs';
import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';
import IMask from 'imask';
import Swiper, {Navigation, Pagination} from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import MicroModal from 'micromodal';
import Dropzone from 'dropzone';
import Pristine from 'pristinejs';

document.addEventListener('DOMContentLoaded', () => {
    // input-count
    (function() {
        const counter = document.querySelectorAll('[data-id="counter"]');
        counter.forEach((el) => {
            const countInput = el.querySelector('[data-id="input-count"]');
            const minusBtn = el.querySelector('[data-id="minus"]');
            const plusBtn = el.querySelector('[data-id="plus"]');
            plusBtn.addEventListener('click', () => {
                countInput.value = parseInt(countInput.value, 10) + 1;
            });
            minusBtn.addEventListener('click', () => {
                if (countInput.value > 1) {
                    countInput.value = parseInt(countInput.value, 10) - 1;
                }
            });
        });
    }());

    const footerOrderForm = document.querySelector('#modal-order-form');
    if (footerOrderForm) {
        footerOrderForm.addEventListener('submit', (e) => {
            e.preventDefault();

            fetch('/footer_order_form', {method: 'post', body: new FormData(footerOrderForm)})
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    document.querySelector('#order-modal .modal__content').innerHTML = data.output;
                });
        });
    }

    // go to top
    (function() {
        const scrollToTopButton = document.querySelector('[data-id="btn-scroll"]');
        const scrollFunc = () => {
            const y = window.scrollY;
            if (y > 300) {
                scrollToTopButton.className = 'go-top show';
            } else {
                scrollToTopButton.className = 'go-top hide';
            }
        };
        window.addEventListener('scroll', scrollFunc);
        scrollToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            });
        });
    }());

    // btn menu
    (function() {
        const body = document.body;
        const btnMenu = document.querySelector('[data-id="btn-menu"]');
        const navMenu = document.querySelector('[data-id="nav"]');
        const navItem = document.querySelectorAll('[data-nav="item"]');
        const itemMenu = document.querySelectorAll('[data-item="menu"]');
        const btnBack = document.querySelectorAll('[data-btn="back"]');

        function clearActive(buttons) {
            buttons.forEach((button) => button.classList.remove('active'));
        }

        btnMenu.onclick = function() {
            navMenu.classList.add('nav-transition');
            if (body.classList.contains('is-open-menu')) {
                setTimeout(() => {
                    navMenu.classList.remove('nav-transition');
                }, 1000);
            }
            btnMenu.classList.toggle('active');
            navMenu.classList.toggle('active');
            body.classList.toggle('is-open-menu');
            clearActive(navItem);
        };

        itemMenu.forEach((button) => {
            button.addEventListener('click', () => {
                const thisItem = button.closest('.nav__item');
                if (!thisItem.classList.contains('active')) {
                    navItem.forEach((item) => {
                        item.classList.remove('active');
                    });
                    thisItem.classList.add('active');
                }
            });
        });

        btnBack.forEach((button) => {
            button.addEventListener('click', (evt) => {
                evt.preventDefault();
                clearActive(navItem);
            });
        });
    }());

    // show more
    (function() {
        if (document.querySelector('[data-btn="show-more"]')) {
            const btnShowMore = document.querySelector('[data-btn="show-more"]');
            const previewBlock = document.querySelector('[data-id="preview"]');
            btnShowMore.addEventListener('click', () => {
                btnShowMore.innerHTML = (btnShowMore.innerHTML === 'Свернуть категории') ? btnShowMore.innerHTML = 'Показать все категории' : btnShowMore.innerHTML = 'Свернуть категории';
                btnShowMore.classList.toggle('active');
                previewBlock.classList.toggle('active');
            });
        }
    }());

    // m-accordion
    function initAccordion(selector = 'accordion') {
        const accBtn = document.querySelectorAll(`[data-accordion=${selector}]`);
        accBtn.forEach((button) => {
            button.addEventListener('click', () => {
                button.classList.toggle('active');
                const accContent = button.nextElementSibling;
                if (accContent.style.maxHeight) {
                    accContent.style.maxHeight = null;
                } else {
                    accContent.style.maxHeight = `${accContent.scrollHeight}px`;
                }
            });
        });
    }

    initAccordion();

    (function() {
        const mediaQuery = window.matchMedia('(max-width: 1023px)');

        function handleTabletChange(e) {
            if (e.matches) {
                // m-accordion footer
                if (document.querySelectorAll('[data-accordion="accor-footer"]')) {
                    initAccordion('accor-footer');
                }
            }
        }

        // Register event listener
        mediaQuery.addEventListener('change', handleTabletChange);
        // Initial check
        handleTabletChange(mediaQuery);
    }());

    (function() {
        if (document.querySelector('[data-close="need-labels"]')) {
            const btnClose = document.querySelector('[data-close="need-labels"]');
            const blockNeedLabels = document.querySelector('[data-block="need-labels"]');
            btnClose.onclick = function() {
                blockNeedLabels.classList.add('is-close');
            };
        }
    }());

    // swiper
    (function() {
        const enableSwiper = () => new Swiper('.swiper-mobile', {
            spaceBetween: 16,
            // pagination
            pagination: {
                el: '.swiper-pagination',
            },
            paginationClickable: true,
        });

        if (document.querySelector('.swiper-mobile')) {
            const breakpoint = window.matchMedia('(min-width:768px)');
            let swiperMobile;
            const breakpointChecker = () => {
                if (breakpoint.matches === true) {
                    if (swiperMobile !== undefined) swiperMobile.destroy(true, true);
                } else if (breakpoint.matches === false) {
                    swiperMobile = enableSwiper();
                }
            };

            breakpoint.addEventListener('change', breakpointChecker);
            breakpointChecker();
        }
    }());

    // swiper reviews
    (function() {
        new Swiper('.swiper-reviews', {
            speed: 400,
            spaceBetween: 100,
            watchOverflow: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            },
        });
    }());

    // swiper-product
    (function() {
        const enableSwiperProduct = () => new Swiper('.swiper-product', {
            slidesPerView: 3,
            spaceBetween: 0,
            cssMode: true,
            centeredSlides: true,
            roundLengths: true,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            on: {
                destroy: (swiper) => {
                    swiper.pagination.el.innerHTML = '';
                },
            },
        });

        if (document.querySelector('.swiper-product')) {
            const breakpointProduct = window.matchMedia('(min-width:1024px)');
            let swiperProduct;
            const breakpointCheckerProduct = () => {
                if (breakpointProduct.matches === true) {
                    if (swiperProduct !== undefined) swiperProduct.destroy(true, true);
                } else if (breakpointProduct.matches === false) {
                    swiperProduct = enableSwiperProduct();
                }
            };

            breakpointProduct.addEventListener('change', breakpointCheckerProduct);
            breakpointCheckerProduct();
        }
    }());

    // block toggle
    (function() {
        const btnToggle = document.querySelectorAll('[data-toggle]');
        btnToggle.forEach((element) => {
            element.addEventListener('click', () => {
                const block = document.getElementById(element.dataset.toggle);
                if (element.classList.contains('opened')) {
                    element.classList.remove('opened');
                    block.style.display = 'none';
                } else {
                    element.classList.add('opened');
                    block.style.display = 'block';
                }
            });
        });
    }());

    // tabs init
    document.querySelectorAll('[data-tabs]').forEach((elem, i) => {
        elem.setAttribute(`data-tabs-${i}`, '');
        new Tabby(`[data-tabs-${i}]`);
    });

    // tooltips init
    tippy('.tooltip', {
        offset: [0, 20],
        maxWidth: 288,
        arrow: '<svg width="80" height="16" viewBox="0 0 80 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M80.0001 -8.96454e-05C69.7001 -8.87449e-05 64.4501 1.11992 56.5001 8.10662L52.8501 11.3066C49.3 14.4533 44.65 16 40 16C35.35 16 30.7 14.4533 27.15 11.3066L23.5 8.10663C15.55 1.11992 10.2999 -8.3552e-05 -7.76927e-05 -8.26515e-05L80.0001 -8.96454e-05Z" fill="#5A6E8C"/> </svg>',
    });

    // promo
    (function() {
        const promoInp = document.querySelector('.promo input');
        const promoBtn = document.querySelector('.promo .btn');
        if (promoInp) {
            promoInp.addEventListener('input', () => {
                if (promoInp.value) {
                    promoBtn.classList.remove('disabled');
                } else {
                    promoBtn.classList.add('disabled');
                }
            });
        }
    }());
});
// const Swiper = require('swiper').default;
function findVideos() {
    const videos = document.querySelectorAll('.video');

    for (let i = 0; i < videos.length; i += 1) {
        setupVideo(videos[i]);
    }
}

function setupVideo(video) {
    const link = video.querySelector('.video__link');
    const button = video.querySelector('.video__button');
    const media = video.querySelector('.video__media');
    const id = media.dataset.src + '?rel=0&showinfo=0&autoplay=1';

    video.addEventListener('click', () => {
        const iframe = createIframe(id);

        link.remove();
        button.remove();
        video.appendChild(iframe);
    });

    link.removeAttribute('href');
    video.classList.add('video--enabled');
}

function createIframe(id) {
    const iframe = document.createElement('iframe');
    iframe.width = '560';
    iframe.height = '315';
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('allow', 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture');
    iframe.setAttribute('src', id);
    iframe.classList.add('video__media');

    return iframe;
}

findVideos();
document.addEventListener('departmentsLoaded', () => {
    document.querySelectorAll('.custom-select').forEach((select) => {
        const selectInput = select.querySelector('.custom-select__input');
        const selectText = select.querySelector('.custom-select__text');
        const defaultSelected = select.querySelector('.custom-option.selected');
        if (defaultSelected) {
            selectText.textContent = defaultSelected.textContent;
            selectInput.value = defaultSelected.dataset.value;
        } else {
            const firstElement = select.querySelector('.custom-option');
            selectText.textContent = firstElement.textContent;
            selectInput.value = firstElement.dataset.value;
            firstElement.classList.add('selected');
        }
        select.addEventListener('click', () => {
            select.classList.toggle('open');
        });
        select.querySelectorAll('.custom-option').forEach((option) => {
            option.addEventListener('click', () => {
                if (!option.classList.contains('selected')) {
                    select.querySelector('.custom-option.selected').classList.remove('selected');
                    option.classList.add('selected');
                    selectText.textContent = option.textContent;
                    if (selectInput) {
                        selectInput.value = option.dataset.value;
                        const event = new Event('change');
                        selectInput.dispatchEvent(event);
                    }
                }
            });
        });
        window.addEventListener('click', (e) => {
            if (!select.contains(e.target)) {
                select.classList.remove('open');
            }
        });
    });
});
(() => {
    document.querySelectorAll('.phone-mask').forEach((element) => {
        const patternMask = IMask(element, {
            mask: '+{7} (000) 000-00-00',
            lazy: true,
        });
        element.addEventListener('focus', () => {
            patternMask.updateOptions({
                lazy: false,
            });
        }, true);
        element.addEventListener('blur', () => {
            patternMask.updateOptions({
                lazy: true,
            });
            if (!patternMask.masked.rawInputValue) {
                patternMask.value = '';
            }
        }, true);
        patternMask.on('accept', () => {
            const maskEvent = new CustomEvent('maskchange', {
                detail: patternMask.masked.isComplete,
            });
            element.dispatchEvent(maskEvent);
        });
    });
})();
(function() {
    MicroModal.init({
        openClass: 'is-open',
        disableScroll: true,
        disableFocus: false,
        awaitOpenAnimation: false,
        awaitCloseAnimation: false,
        debugMode: true,
        onShow: (modal) => {
            const event = new Event('open');
            modal.dispatchEvent(event);
        },
        onClose: (modal) => {
            const event = new Event('close');
            modal.dispatchEvent(event);
        },
    });
}());

// eslint-disable-next-line no-undef
Dropzone.autoDiscover = false;

document.querySelectorAll('.files-upload').forEach((uploadBlock) => {
    const input = uploadBlock.querySelector('.files-upload__inp');
    const uploader = uploadBlock.querySelector('.files-upload__dropzone');
    // eslint-disable-next-line no-undef
    const dropzone = new Dropzone(uploader, {
        url: `/upload_files?type=${uploadBlock.dataset.type}`,
        createImageThumbnails: false,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        },
        autoProcessQueue: true,
        autoQueue: true,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 10,
        acceptedFiles: 'image/jpg, image/jpeg, image/png, .svg, image/tif, application/pdf, .ai, .psd',
        addRemoveLinks: false,
        previewTemplate: '<div class="dz-preview dz-file-preview">'
            + '<div class="dz-details">'
            + '  <div class="dz-filename"><span data-dz-name></span></div><div class="dz-remove" data-dz-remove>Удалить</div>'
            + '</div>'
            + '<div class="dz-error-message"><span data-dz-errormessage></span></div>'
            + '<div class="dz-progress">'
            + '  <span class="dz-upload" data-dz-uploadprogress></span>'
            + '</div>'
            + '</div>',
        previewsContainer: uploadBlock.querySelector('.files-upload__previews'),
        dictDefaultMessage: 'Перетащите необходимые файлы в это поле или <span>кликните для загрузки</span>. Максимальный объем одного файла — 100 МВ',
    });
    dropzone.on('success', (event, response) => {
        const inpVal = input.value;
        const vals = inpVal ? inpVal.split(',') : [];
        const fileId = response.file_id.shift();
        vals.push(fileId);
        input.value = vals.join(',');
        // eslint-disable-next-line no-param-reassign
        event.file_id = fileId;
    });
    dropzone.on('removedfile', (event) => {
        const inpVal = input.value;
        const vals = inpVal ? inpVal.split(',') : [];
        const index = event.file_id ? vals.indexOf(event.file_id.toString()) :
            event.previewElement.remove();
        if (index > -1) {
            vals.splice(index, 1);
            event.previewElement.remove();
        }
        input.value = vals.join(',');
    });
    dropzone.on('complete', (event) => {
        event.previewElement.querySelector('.dz-progress').remove();
    });
});

document.querySelectorAll('.avatar-upload').forEach((uploadBlock) => {
    const input = uploadBlock.querySelector('.avatar-upload__inp');
    const uploader = uploadBlock.querySelector('.avatar-upload__dropzone');
    // eslint-disable-next-line no-undef
    const dropzone = new Dropzone(uploader, {
        url: '/upload_files?type=avatar',
        createImageThumbnails: true,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        },
        autoProcessQueue: true,
        autoQueue: true,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 1,
        maxFilesize:1,
        maxHeight:150,
        maxWidth:150,
        acceptedFiles: 'image/jpg, image/jpeg, image/png, image/gif',
        addRemoveLinks: true,
        previewTemplate: '<div class="dz-preview dz-file-preview">'
            + '<div class="dz-image"><img data-dz-thumbnail/></div>'
            + '<div class="dz-error-message"><span data-dz-errormessage></span></div>'
            + '<div class="dz-progress">'
            + '  <span class="dz-upload" data-dz-uploadprogress></span>'
            + '</div>'
            + '</div>'
        + '<div class="dz-error-message"><span data-dz-errormessage></span></div>',
        previewsContainer: uploadBlock.querySelector('.avatar-upload__previews'),
        dictDefaultMessage: 'Загрузить фото',
        dictRemoveFile: 'Удалить',
        dictFileTooBig: "Размер превышен ({{filesize}}MB). Макс. размер: {{maxFilesize}}MB.",
        dictCancelUpload: ''

    });
    dropzone.on('success', (event, response) => {
        const inpVal = input.value;
        const vals = inpVal ? inpVal.split(',') : [];
        const fileId = response.file_id.shift();
        vals.push(fileId);
        input.value = vals.join(',');
        // eslint-disable-next-line no-param-reassign
        event.file_id = fileId;
        event.previewElement.querySelector('.dz-error-message').remove();
        input.dispatchEvent(new Event('change'));
        document.querySelector('.avatar-upload__dropzone').classList.remove('dz-error');
    });
    dropzone.on('error', (event, response) => {
        document.querySelector('.avatar-upload__dropzone').classList.add('dz-error');
        document.querySelector('.dz-remove').style.visibility = 'hidden';
    });
    dropzone.on('removedfile', (event) => {
        const inpVal = input.value;
        const vals = inpVal ? inpVal.split(',') : [];
        const index = event.file_id ? vals.indexOf(event.file_id.toString())
            : event.previewElement.remove();
        if (index > -1) {
            vals.splice(index, 1);
            event.previewElement.remove();
        }
        input.value = vals.join(',');
        input.dispatchEvent(new Event('change'));
    });
    dropzone.on('complete', (event) => {
        event.previewElement.querySelector('.dz-progress').remove();
    });
    dropzone.on('addedfile', () => {
        if (dropzone.files.length > 1) {
            dropzone.removeFile(dropzone.files[0]);
        }
    });
});
(() => {
    const config = {
        classTo: 'validation-group',
        errorClass: 'error',
        successClass: 'success',
        errorTextParent: 'validation-group',
        errorTextTag: 'div',
        errorTextClass: 'error-msg',
    };
    document.querySelectorAll('.form-validation').forEach((form) => {
        // eslint-disable-next-line no-undef,no-param-reassign
        const validator = new Pristine(form, config);
        const submit = form.querySelector('.validation-submit');
        if (submit) {
            form.querySelectorAll('input, select, textarea').forEach((field) => {
                field.addEventListener('keyup', () => {
                    submit.disabled = !validator.validate(true);
                });
                field.addEventListener('change', () => {
                    submit.disabled = !validator.validate(true);
                });
                field.addEventListener('backenderror', (e) => {
                    validator.addError(field, e.detail);
                    submit.disabled = true;
                });
            });
        }
    });
})();
(() => {
    const form = document.querySelector('#review-form');
    if (form) {
        const modalForm = document.getElementById('add-review');
        const modalThanks = document.getElementById('thanks');
        const modalContent = form.closest('.modal__content');
        const emailField = form.querySelector('[name="email"]');
        const avatarField = document.getElementById('avatar');

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
            })
                .then((response) => response.json())
                .then((content) => {
                    if (content.error) {
                        const errorEvent = new CustomEvent('backenderror', {
                            detail: content.error,
                        });
                        if (content.field === 'email') {
                            emailField.dispatchEvent(errorEvent);
                        }
                        if (content.field === 'avatar') {
                            document.querySelector('.avatar-upload__dropzone').classList.add('dz-error');
                            avatarField.dispatchEvent(errorEvent);
                        }
                    } else {
                        modalForm.classList.toggle('is-open');
                        modalThanks.classList.toggle('is-open');
                    }
                });
        });
    }
})();
(() => {
    const setValue = (counter, field, max) => {
        if (field.value.length <= max) {
            // eslint-disable-next-line no-param-reassign
            counter.innerHTML = `${field.value.length}/${max}`;
        } else {
            // eslint-disable-next-line no-param-reassign
            field.value = field.value.substring(0, max);
            // eslint-disable-next-line no-param-reassignF
            counter.innerHTML = `${max}/${max}`;
        }
    };
    document.querySelectorAll('[data-char-counter]').forEach((el) => {
        const field = document.getElementById(el.dataset.charCounter);
        // eslint-disable-next-line prefer-destructuring
        const max = el.dataset.max;
        setValue(el, field, max);
        field.addEventListener('input', () => {
            setValue(el, field, max);
        });
    });
})();
(() => {
    const updateStars = (stars, starLevel) => {
        stars.forEach((el) => {
            if (starLevel < el.getAttribute('data-val')) {
                el.classList.remove('star_yellow');
                el.classList.add('star_grey');
            } else {
                el.classList.remove('star_grey');
                el.classList.add('star_yellow');
            }
        });
    };
    document.querySelectorAll('.rating-select').forEach((rating) => {
        const initVal = rating.dataset.initVal ? rating.dataset.initVal : 5;
        const stars = rating.querySelectorAll('.icon-star');
        const input = rating.querySelector('.rating-select__inp');
        let currentVal = initVal;
        input.value = currentVal;
        updateStars(stars, initVal);
        stars.forEach((star) => {
            star.addEventListener('click', () => {
                const starlevel = star.getAttribute('data-val');
                updateStars(stars, starlevel);
                currentVal = starlevel;
                input.value = currentVal;
            });
            star.addEventListener('mouseenter', () => {
                const starlevel = star.getAttribute('data-val');
                updateStars(stars, starlevel);
            });
            star.addEventListener('mouseleave', () => {
                updateStars(stars, currentVal);
            });
        });
    });
})();
(() => {
    const backCallForm = document.querySelector('#back-call-from');
    if (backCallForm) {
        const backCallModal = backCallForm.closest('.back-call');
        const phoneField = backCallForm.querySelector('input[name="phone"]');
        const submitBtn = backCallForm.querySelector('button');
        phoneField.addEventListener('maskchange', (e) => {
            submitBtn.disabled = !e.detail;
        });
        backCallForm.addEventListener('submit', (e) => {
            e.preventDefault();
            fetch('callback', {
                method: 'post',
                body: new FormData(backCallForm),
            })
                .then((response) => response.text())
                .then((data) => {
                    backCallModal.querySelector('.back-call__text').innerHTML = data;
                    backCallForm.style.display = 'none';
                    backCallModal.querySelector('h2').style.display = 'none';
                    backCallModal.querySelector('.back-call__success').style.display = 'block';
                });
        });
    }
})();
document.querySelectorAll('.address-slider').forEach((sliderElement) => {
    const slides = sliderElement.querySelectorAll('.swiper-slide');
    const swiper = new Swiper(sliderElement, {
        modules: [Navigation, Pagination],
        direction: 'horizontal',
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        pagination: {
            el: '.address-slider__pagination',
            bulletActiveClass: 'address-slider__thumb_active',
            bulletClass: 'address-slider__thumb',
            clickable: true,
            renderBullet: (index, className) => `<li class="${className}"><img src="${slides[index].querySelector('img').src}" alt=""></li>`,
        },
    });
    sliderElement.closest('.modal').addEventListener('open', () => {
        swiper.update();
    });
});
document.addEventListener('DOMContentLoaded', function() {
    window.gallerySwiper = new Swiper(document.querySelector('.gallery-slider'), {
        modules: [Navigation, Pagination],
        direction: 'horizontal',
        slidesPerView: 1,
        spaceBetween: 0,
        loop: false,
        autoHeight: true,
        autoWidth: true,
        centeredSlides: true,

        navigation: {
            nextEl: '.swiper-gallery-button-next',
            prevEl: '.swiper-gallery-button-prev',
        },
    });
});

{
    let itemNum = 0;

    document.querySelectorAll('.gallery__link').forEach((galleryElement) => {
        galleryElement.addEventListener('click', () => {
            itemNum = galleryElement.dataset.itemNum;
            window.gallerySwiper.update();
            window.gallerySwiper.slideTo(itemNum, 0);
        });

    });

    document.querySelectorAll('.description-link').forEach((lnk) => lnk.addEventListener('click', () => window.open(lnk.dataset.href, '_blank')))

    const htmlToElement = (html) => {
        const template = document.createElement('template');
        html.trim();
        template.innerHTML = html;
        return template.content.firstChild;
    };

    const makeRequest = (galleryElement, tab, is_random = false) => {
        let gallery = galleryElement;
        const queryParams = [`tab=${tab}`];
        if (is_random) {
            queryParams.push(`calculatorTypeId=${document.querySelector('.gallery-tabs').dataset.calculatorTypeId}`);
            queryParams.push(`is_random=1`);
        }
        const onFulfilled = (info, html) => {
            document.querySelectorAll('.gallery-slider .swiper-slide').forEach((e) => e.remove());

            for (let i = 0; i < info.length; i++) {

                let el = document.createElement('div');
                el.classList.add('swiper-slide');
                el.setAttribute('data-swiper-slide-index', i);
                el.setAttribute('role', 'group');

                let img = document.createElement('img');
                img.src = info[i].src;
                el.append(img);

                let div = document.createElement('div');
                div.classList.add('gallery-description-text');
                div.innerHTML = info[i].description;
                el.append(div);

                document.querySelector('.gallery-slider .swiper-wrapper').append(el);
            }

             if (!is_random && !localStorage.getItem('randomItemsHtml-' + tab)) {
                 localStorage.setItem('randomItemsHtml-' + tab, html)
                 localStorage.setItem('randomItemsInfo-' + tab, JSON.stringify(info))
             }

            const newGallery = htmlToElement(html);
            gallery.replaceWith(newGallery);
            gallery = newGallery;
            findVideos();

            document.querySelectorAll('.gallery__link').forEach((galleryElement) => {
                galleryElement.addEventListener('click', () => {
                    itemNum = galleryElement.dataset.itemNum;

                    window.gallerySwiper.slideTo(itemNum, 0);
                    MicroModal.show('gallery-modal');
                    window.gallerySwiper.update();
                });
            })
            return gallery;
        }

        if (localStorage.getItem('randomItemsInfo-'+tab)) {
            return Promise.resolve(onFulfilled(JSON.parse(localStorage.getItem('randomItemsInfo-' + tab)), localStorage.getItem('randomItemsHtml-' + tab)));
        }

        return fetch(`/get_gallery?${queryParams.join('&')}`)
            .then((response) => response.json())
            .then((response) => onFulfilled(response.info, response.html));
    };

    const setActive = (tabsItems, activeElement) => {
        tabsItems.forEach((tab) => {
            tab.classList.remove('active');
        });
        activeElement.classList.add('active');
    };

    document.querySelectorAll('.gallery-tabs').forEach((tabsElement) => {
        let galleryElement = tabsElement.closest('section').querySelector('.pure-g_plate');
        const tabsItems = document.querySelectorAll('.gallery-tabs__item');

        tabsItems.forEach((element) => {
            element.addEventListener('click', () => {
                if (element.classList.contains('active')) {
                    if (element.classList.contains('featured-gallery')) {
                        makeRequest(galleryElement, element.dataset.tab, true).then((result) => {
                            galleryElement = result;
                        });
                    }
                } else if (element.classList.contains('featured-gallery')) {
                    makeRequest(galleryElement, element.dataset.tab, true).then((result) => {
                        galleryElement = result;
                    });
                    setActive(tabsItems, element);
                } else {
                    makeRequest(galleryElement, element.dataset.tab).then((result) => {
                        galleryElement = result;
                        setActive(tabsItems, element);
                    });
                }
            }, true);
        });
    });
}
