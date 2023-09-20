@extends('calc.test_calcs_layout')

@section('title')
    {{ $title }}
@endsection

@section('content')
        <a class="btn btn-danger" href="{{ url()->previous() }}">Назад</a>
    <div class="row">
        <div class="col-12 col-lg-6">
            <h1 class="text-center">{{ $title }}</h1>
            <form class="row g-3" id="form">
                <div class="col-12">
                    <label for="type" class="form-label">Тип</label>
                    <select id="type" name="type" class="form-select">
                        <option value="flyers">Листовки</option>
                        <option value="book">Буклет "Книжка" 1 сгиб</option>
                        <option value="euro">Буклет "Евро" 2 сложения</option>
                        <option value="acord">Буклет "Гармошка" 2 сложения</option>
                        <option value="acord2">Буклет "Гармошка" 3 сложения</option>
                        <option value="snail">Буклет "Улитка" 3 сложения</option>
                        <option value="vip">VIP Буклет</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="size" class="form-label">Размер в развороте</label>
                    <select id="size" name="size" class="form-select">
                        @foreach($size_options as $option)
                            <option {{$option['id']==$size_width.'x'.$size_height?'selected':''}} value="{{$option['id']}}">{{$option['value']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 d-none">
                    <label for="width" class="form-label">Ширина</label>
                    <input type="number" min="70" name="width" class="form-control"
                           aria-describedby="validationFeedback" value="{{$size_width}}" id="width" placeholder="Ширина"
                           required>
                    <div id="validationFeedback" class="invalid-feedback">
                        Минимальный размер 70x100мм или 100x70мм
                    </div>
                </div>
                <div class="col-6 d-none">
                    <label for="height" class="form-label">Высота</label>
                    <input type="number" min="70" name="height" class="form-control" value="{{$size_height}}"
                           id="height" placeholder="Высота" required>
                </div>
                <div class="col-12 d-none">
                    <label for="bend" class="form-label">Сложение</label>
                    <select id="bend" class="form-select">
                        <option value="1">1 сгиб</option>
                        <option value="2">2 сгиба</option>
                        <option value="3">3 сгиба</option>
                        <option value="4">4 сгиба</option>
                        <option value="5">5 сгибов</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="product_count" class="form-label">Количество</label>
                    <input type="text" name="product_count" class="form-control" id="product_count"
                           placeholder="Количество"
                           required>
                </div>
                <div class="col-12" id="duplexWrap">
                    <label for="duplex" class="form-label">Цветность</label>
                    <select id="duplex" name="duplex" class="form-select">
                        <option value="0">Одна сторона</option>
                        <option value="1">Две стороны</option>
                    </select>
                </div>
                <div class="col-12" id="lamWrap">
                    <label for="lam" class="form-label">Ламинация</label>
                    <select id="lam" name="lam" class="form-select">
                        <option value="none">Без ламинации</option>
                        <option value="m1">Матовая (25 мкр) 1+0</option>
                        <option value="m2">Матовая (25 мкр) 1+1</option>
                        <option value="g1">Глянцевая (25 мкр) 1+0</option>
                        <option value="g2">Глянцевая (25 мкр) 1+1</option>
                        <option value="st1">Soft Touch 1+0</option>
                        <option value="st2">Soft Touch 1+1</option>
                    </select>
                </div>
                <div class="col-12" id="material_body">
                    <label for="material" class="form-label">Бумага</label>
                    <select id="material" name="material" class="form-select">
                        <option value="none">Укажите размер</option>
                        <option value="40">Тест</option>
                    </select>
                </div>
                <div class="col-12 mt-3 d-none" data-vip>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="fw-bold text-center">VIP отделка буклета</h2>
                            <ul class="nav nav-pills justify-content-around mb-3 border p-3">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home"
                                            aria-selected="true">Фольгирование
                                    </button>
                                </li>
                                {{--                                <li class="nav-item" role="presentation">--}}
                                {{--                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"--}}
                                {{--                                            data-bs-target="#pills-profile" type="button" role="tab"--}}
                                {{--                                            aria-controls="pills-profile"--}}
                                {{--                                            aria-selected="false">Теснение--}}
                                {{--                                    </button>--}}
                                {{--                                </li>--}}
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact" type="button" role="tab"
                                            aria-controls="pills-contact"
                                            aria-selected="false">Выборочный УФ лак
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                     aria-labelledby="pills-home-tab">
                                    <div class="row">
                                        <div class="col-5">
                                            <img src="/assets/images/vipPrint/foiling.png" class="img-thumbnail" alt="">
                                            <p>
                                                Бюджетный вариант отделки фольгой любых элементов, не дает эффекта
                                                вдавленного
                                                изображения. Большой ассортимент цветов.
                                            </p>
                                        </div>
                                        <div class="col-7">
                                            <div data-type="front">
                                                <h6>Лицо <span class="text-primary"
                                                               data-foiling-title>Без отделки</span>
                                                </h6>
                                                <div class="d-flex flex-wrap">
                                                    <input type="hidden" name="foiling_front_color"
                                                           id="foiling_front_color"
                                                           value="{{$foiling_colors[0]}}">
                                                    @foreach($foiling_colors as $color)
                                                        <div data-foiling-color="{{$color}}"
                                                             class="{{$loop->first?'bg-light border':''}} rounded-circle m-1 border-primary border-3"
                                                             style="height: 35px; width: 35px; @if(!$loop->first) background: center / cover no-repeat url('/assets/images/vipPrint/colors/{{$loop->index}}.jpg') @endif"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <hr>
                                            <div data-type="back">
                                                <h6>Оборот <span class="text-primary"
                                                                 data-foiling-title>Без отделки</span>
                                                </h6>
                                                <div class="d-flex flex-wrap">
                                                    <input type="hidden" id="foiling_back_color"
                                                           name="foiling_back_color"
                                                           value="{{$foiling_colors[0]}}">
                                                    @foreach($foiling_colors as $color)
                                                        <div data-foiling-color="{{$color}}"
                                                             class="{{$loop->first?'bg-light border':''}} rounded-circle m-1 border-primary border-3"
                                                             style="height: 35px; width: 35px; @if(!$loop->first) background: center / cover no-repeat url('/assets/images/vipPrint/colors/{{$loop->index}}.jpg') @endif"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"--}}
                                {{--                                     aria-labelledby="pills-profile-tab">--}}
                                {{--                                    <div class="row">--}}
                                {{--                                        <div class="col-5">--}}
                                {{--                                            <img src="/assets/images/vipPrint/embossing.jpg" class="img-thumbnail"--}}
                                {{--                                                 alt="">--}}
                                {{--                                            <p>--}}
                                {{--                                                Отделка фольгой при помощи клише из магния, при этом изобажение--}}
                                {{--                                                становится--}}
                                {{--                                                вдавленным--}}
                                {{--                                                Необходим отдельно приобрести или предоставить клише.--}}
                                {{--                                            </p>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="col-7">--}}
                                {{--                                            <div class="row g-0">--}}
                                {{--                                                <div class="col-7">--}}
                                {{--                                                    <div data-type="front">--}}
                                {{--                                                        <h6>Лицо <span class="text-primary"--}}
                                {{--                                                                       data-embossing-title>Без отделки</span>--}}
                                {{--                                                        </h6>--}}
                                {{--                                                        <div class="d-flex flex-wrap">--}}
                                {{--                                                            <input type="hidden" name="front_embossing_color">--}}
                                {{--                                                            <div data-embossing-color="Без отделки"--}}
                                {{--                                                                 class="bg-light rounded-circle m-1 border border-primary border-3"--}}
                                {{--                                                                 style="height: 35px; width: 35px;"></div>--}}
                                {{--                                                            <div data-embossing-color="Золото глянцевое"--}}
                                {{--                                                                 class="rounded-circle m-1 border-primary border-3"--}}
                                {{--                                                                 style="height: 35px; width: 35px; background: center / cover no-repeat url('/assets/images/vipPrint/colors/1.jpg')"></div>--}}
                                {{--                                                            <div data-embossing-color="Серебро глянцевое"--}}
                                {{--                                                                 class="rounded-circle m-1 border-primary border-3"--}}
                                {{--                                                                 style="height: 35px; width: 35px; background: center / cover no-repeat url('/assets/images/vipPrint/colors/3.jpg')"></div>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                </div>--}}
                                {{--                                                <div class="col-5" data-cliche>--}}
                                {{--                                                    <div class="form-check">--}}
                                {{--                                                        <label class="form-check-label mb-1"--}}
                                {{--                                                               for="front_embossing_order_cliche">--}}
                                {{--                                                            Заказать клише--}}
                                {{--                                                        </label>--}}
                                {{--                                                        <input class="form-check-input" type="checkbox"--}}
                                {{--                                                               data-order-cliche--}}
                                {{--                                                               id="front_embossing_order_cliche"--}}
                                {{--                                                               name="front_embossing_order_cliche">--}}
                                {{--                                                    </div>--}}
                                {{--                                                    <div class="row g-0" data-cliche-size>--}}
                                {{--                                                        <div class="col">--}}
                                {{--                                                            <input type="text" class="form-control" placeholder="W"--}}
                                {{--                                                                   name="front_embossing_width" disabled value="90">--}}
                                {{--                                                        </div>--}}
                                {{--                                                        <div class="col-2 align-self-center text-center">X</div>--}}
                                {{--                                                        <div class="col">--}}
                                {{--                                                            <input type="text" class="form-control" value="50" disabled--}}
                                {{--                                                                   placeholder="H"--}}
                                {{--                                                                   name="front_embossing_height">--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                </div>--}}
                                {{--                                                <hr class="my-3">--}}
                                {{--                                                <div class="row g-0">--}}
                                {{--                                                    <div class="col-7">--}}
                                {{--                                                        <div data-type="back">--}}
                                {{--                                                            <h6>Оборот <span class="text-primary"--}}
                                {{--                                                                             data-embossing-title>Без отделки</span>--}}
                                {{--                                                            </h6>--}}
                                {{--                                                            <div class="d-flex flex-wrap">--}}
                                {{--                                                                <input type="hidden" name="back_embossing_color">--}}
                                {{--                                                                <div data-embossing-color="Без отделки"--}}
                                {{--                                                                     class="bg-light rounded-circle m-1 border border-primary border-3"--}}
                                {{--                                                                     style="height: 35px; width: 35px;"></div>--}}
                                {{--                                                                <div data-embossing-color="Золото глянцевое"--}}
                                {{--                                                                     class="rounded-circle m-1 border-primary border-3"--}}
                                {{--                                                                     style="height: 35px; width: 35px; background: center / cover no-repeat url('/assets/images/vipPrint/colors/1.jpg')"></div>--}}
                                {{--                                                                <div data-embossing-color="Серебро глянцевое"--}}
                                {{--                                                                     class="rounded-circle m-1 border-primary border-3"--}}
                                {{--                                                                     style="height: 35px; width: 35px; background: center / cover no-repeat url('/assets/images/vipPrint/colors/3.jpg')"></div>--}}
                                {{--                                                            </div>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                    <div class="col-5" data-cliche>--}}
                                {{--                                                        <div class="form-check">--}}
                                {{--                                                            <label class="form-check-label mb-1"--}}
                                {{--                                                                   for="back_embossing_order_cliche">--}}
                                {{--                                                                Заказать клише--}}
                                {{--                                                            </label>--}}
                                {{--                                                            <input class="form-check-input" type="checkbox"--}}
                                {{--                                                                   data-order-cliche--}}
                                {{--                                                                   id="back_embossing_order_cliche"--}}
                                {{--                                                                   name="back_embossing_order_cliche">--}}
                                {{--                                                        </div>--}}
                                {{--                                                        <div class="row g-0" data-cliche-size>--}}
                                {{--                                                            <div class="col">--}}
                                {{--                                                                <input type="text" value="90" class="form-control"--}}
                                {{--                                                                       placeholder="W"--}}
                                {{--                                                                       name="back_embossing_width" disabled>--}}
                                {{--                                                            </div>--}}
                                {{--                                                            <div class="col-2 align-self-center text-center">X</div>--}}
                                {{--                                                            <div class="col">--}}
                                {{--                                                                <input type="text" class="form-control" placeholder="H"--}}
                                {{--                                                                       value="50"--}}
                                {{--                                                                       name="back_embossing_height" disabled>--}}
                                {{--                                                            </div>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                     aria-labelledby="pills-contact-tab">
                                    <div class="row">
                                        <div class="col-5">
                                            <img src="/assets/images/vipPrint/embossing.jpg" class="img-thumbnail"
                                                 alt="">
                                            <p>
                                                Процесс нанесения прозрачного глянцевого лака на изделия при помощи
                                                шелкографии. Предварительно сопровождается матовой ламинацией.
                                            </p>
                                        </div>
                                        <div class="col-7">
                                            <h6>Лицо</h6>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="front_varnish"
                                                       id="front_varnish" value="0" checked>
                                                <label class="form-check-label" for="front_varnish">
                                                    Без отделки
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="1" type="radio"
                                                       name="front_varnish"
                                                       id="front_varnish2">
                                                <label class="form-check-label" for="front_varnish2">
                                                    Выборочный лак
                                                </label>
                                            </div>
                                            <hr>
                                            <h6>Оборот</h6>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="0"
                                                       name="back_varnish"
                                                       id="back_varnish" checked>
                                                <label class="form-check-label" for="back_varnish">
                                                    Без отделки
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="1"
                                                       name="back_varnish"
                                                       id="back_varnish2">
                                                <label class="form-check-label" for="back_varnish2">
                                                    Выборочный лак
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-between">
                    <div class="form-check d-none">
                        <input class="form-check-input" type="checkbox" name="trimming" id="trimming">
                        <label class="form-check-label" for="trimming">
                            VIP отделка
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Посчитать</button>

                </div>
            </form>
        </div>
        <div id="debug"
             class="col-12 col-lg-6">
            <h1 class="text-center">Debug will be here</h1>
            <div id="debugBody">
            </div>
        </div>
    </div>
    <script>
        function setLam(activeOptions, value = 'none') {
            let options = ['none', 'm1', 'm2', 'g1', 'g2', 'st1', 'st2'];
            options.forEach(item => {
                $(`#lam option[value="${item}"]`).prop('disabled', !activeOptions.includes(item));
                $('#lam').val(value);
            })
        }

        function getMaterial() {
            let w = $('#width').val();
            let h = $('#height').val();
            if (w && h) {
                $.ajax({
                    type: 'GET',
                    url: '/api/calc/test/booklets/materials' + "?width=" + w + '&height=' + h,
                    success: function (data) {
                        if (data) {
                            $('#material').html(data);
                            $('#material_body select').removeAttr('disabled');
                        }
                    }
                });
            }
        }

        function activateSelect(name) {
            let input = $(`#${name}Wrap input[type='hidden']`);
            if (input.length) {
                $(`#${name}`).prop('disabled', false);
                input.remove();
            }
            $(`#${name}`).val($(`#${name} option:not([disabled])`)[0].getAttribute('value'));
        }

        function blockSelect(name, value) {
            let select = $(`#${name}`);
            if (value) {
                select.val(value);
            } else {
                value = select.find('option').attr('value');
                select.val(value);
            }
            select.prop('disabled', true);
            $(`#${name}Wrap`).append(`<input type="hidden" name=${name} value=${value}>`);
        }

        function selectColor(job) {
            $(`[data-${job}-color]`).on('click', function (e) {
                let container = $(this).closest('[data-type]');
                let color = $(this).attr(`data-${job}-color`);
                container.find(`[data-${job}-color]`).each(function (index) {
                    $(this).removeClass('border');
                });
                $(this).addClass('border');
                container.find(`[data-${job}-title]`).html(color);
                container.find('input').val(color);
                if ($('#foiling_front_color').val() != 'Без отделки' || $('#foiling_back_color').val() != 'Без отделки') {
                    blockSelect('lam', 'st2')
                    // $('#lam').val('st2');
                    // $('#lam').prop('disabled', true);
                } else if (job === 'foiling' && color == 'Без отделки') {
                    activateSelect('lam')
                    // $('#lam').prop('disabled', false);
                }
                if ($('#foiling_front_color').val() != 'Без отделки' && $('#foiling_back_color').val() != 'Без отделки') {
                    // $('#duplex').val('1');
                    // $('#duplex').prop('disabled', true);
                    blockSelect('duplex', '1');
                } else {
                    // $('#duplex').prop('disabled', false);
                    activateSelect('duplex');
                }
            })
        }

        function checkedVipPosibillity() {
            if ($('#type').val() === 'vip') {
                let width = $('#width').val();
                let height = $('#height').val();
                if ((width < 311 && height < 441) || (width < 441 && height < 311)) {
                    $('#trimming').prop('disabled', false);
                } else {
                    $('#trimming').prop('checked', false);
                    $('#trimming').prop('disabled', true);
                    $('[data-vip]').addClass('d-none');
                }
            }
        }

        function uncheckVarnish(name) {
            let selectedVarnish = $(`input[name=${name}]:checked`);
            let unSelectedVarnish = $(`input[name=${name}]:not(:checked)`);
            if (selectedVarnish.val() == '1') {
                selectedVarnish.prop('checked', false);
                unSelectedVarnish.prop('checked', true);
            }
        }

        function checkLamination() {
            $('#lam').prop('disabled', false);
            let width = $('#width').val();
            let height = $('#height').val();
            if (((width > 310 && width < 441 && height < 310) || (height > 310 && height < 441 && width < 310) || (width < 311 && height < 311)) && ($('#type').val() != 'vip') && ($('#material').val() != '43' && $('#material').val() != '44' && $('#material').val() != '45' && $('#material').val() != '46')) {
                // $('#lam').prop('disabled', true);
                // $('#lam').val('none');
                blockSelect('lam', 'none')
            }
        }

        $(function () {
            $(document).on('submit', '#form', function (e) {
                e.preventDefault();
                let width = $('#width').val();
                let height = $('#height').val();
                if ((width > 69 && width < 100 && height < 100) || (height > 69 && height < 100 && width < 100)) {
                    $('#width').addClass('is-invalid');
                    $('#height').addClass('is-invalid');
                } else {
                    if ($('#width').hasClass('is-invalid')) {
                        $('#width').removeClass('is-invalid');
                        $('#height').removeClass('is-invalid');
                    }
                    let frm = $('#form').serialize();
                    // if($('#lam').prop('disabled')){
                    //     $('#lam').prop('disabled', false);
                    //     frm = $('#form').serialize();
                    //     $('#lam').prop('disabled', true);
                    // }
                    // if($('#duplex').prop('disabled')){
                    //     $('#duplex').prop('disabled', false);
                    //     frm = $('#form').serialize();
                    //     $('#duplex').prop('disabled', true);
                    // }
                    let url = $('#type').val() === 'flyers' ? 'api/calc/test/booklets' : 'api/calc/test/booklets';
                    $.ajax({
                        url: '/' + url,
                        data: frm,
                        method: 'post',
                        success: function (data) {
                            $('#debugBody').html(data);
                        }
                    });
                }
            })
            $('#size').on('change', function (e) {
                let sizeValue = $(this).val();
                if (sizeValue === 'custom') {
                    $('#width').closest('div').removeClass('d-none');
                    $('#height').closest('div').removeClass('d-none');
                } else {
                    let size = sizeValue.split('x');
                    $('#width').val(size[0]);
                    $('#height').val(size[1]);
                    $('#width').closest('div').addClass('d-none');
                    $('#height').closest('div').addClass('d-none');
                    getMaterial();
                    checkLamination();
                }
                checkedVipPosibillity();
            })
            getMaterial();
            $('#width, #height').on('keyup', _ => {
                getMaterial();
                checkLamination();
                checkedVipPosibillity();
            });
            $('#type').on('change', function (e) {
                setLam(['none', 'm1', 'm2', 'g1', 'g2', 'st1', 'st2'])
                activateSelect('lam');
                activateSelect('duplex');
                // $('#lam').prop('disabled', false);
                // $('#duplex').prop('disabled', false);
                $.ajax({
                    url: '/api/calc/test/booklets/sizes?type=' + $(this).val(),
                    success: data => {
                        let markup = ``;
                        data.size_options.forEach(option => {
                            markup += `<option ${option['id'] === data.size_width + 'x' + data.size_height ? 'selected' : ''} value="${option['id']}">${option['value']}</option>`;
                        })
                        $('#size').html(markup);
                        $('#width').val(data.size_width);
                        $('#height').val(data.size_height);
                        if ($(this).val() !== 'flyers' && $(this).val() !== 'vip') {
                            $('#duplex').removeAttr('name');
                            $('#duplex').closest('div').addClass('d-none');
                        } else if (!$('#duplex').attr('name')) {
                            $('#duplex').attr('name', 'duplex');
                            $('#duplex').closest('div').removeClass('d-none');
                        }
                        if ($(this).val() !== 'vip') {
                            $('#bend').removeAttr('name');
                            $('#bend').closest('div').addClass('d-none');
                            $('#trimming').prop('checked', false);
                            $('#trimming').closest('div').addClass('d-none');
                            $('[data-vip]').addClass('d-none');
                        } else if (!$('#bend').attr('name')) {
                            $('#bend').attr('name', 'bend');
                            $('#bend').closest('div').removeClass('d-none');
                            $('#trimming').closest('div').removeClass('d-none');
                        }
                        getMaterial();
                        checkLamination();
                    }
                });
            })
            $('#lam').on('change', function (e) {
                if ($(this).val() !== 'm2') {
                    $('[data-foiling-color]').removeClass('border');
                    $('[data-foiling-color="Без отделки"]').addClass('border');
                    $('[data-foiling-title]').html('Без отделки');
                    $('#pills-home input').val('Без отделки');
                    uncheckVarnish("front_varnish");
                    uncheckVarnish("back_varnish");
                }
            })
            $('#material').on('change', function () {
                checkLamination();
            });
            // vip bookletsblock
            selectColor('foiling');
            // selectColor('embossing');
            // $('[data-order-cliche]').on('change', function (e) {
            //     if ($(this).prop('checked')) {
            //         $(this).closest('[data-cliche]').find('[data-cliche-size] input').removeAttr('disabled');
            //     } else {
            //         $(this).closest('[data-cliche]').find('[data-cliche-size] input').attr('disabled', true);
            //     }
            // })
            $('#trimming').on('change', function (e) {
                $('[data-vip]').toggleClass('d-none');
                $('#lam').prop('disabled', false);
            })
            $('input[type=radio][name="back_varnish"], input[type=radio][name="front_varnish"]').on('change', function (e) {
                let foilingFrontColor = $('#foiling_front_color').val();
                let foilingBackColor = $('#foiling_back_color').val();
                let backVarnish = $('input[type=radio][name="back_varnish"]:checked').val();
                let frontVarnish = $('input[type=radio][name="front_varnish"]:checked').val();
                console.log(backVarnish)
                console.log(frontVarnish)
                if (backVarnish == '1' && frontVarnish == '1') {
                    blockSelect('duplex', '1')
                } else if (foilingBackColor == 'Без отделки' && foilingFrontColor == 'Без отделки') {
                    activateSelect('duplex')
                }
                if (foilingBackColor == 'Без отделки' && foilingFrontColor == 'Без отделки') {
                    if (backVarnish == '1' && frontVarnish == '1') {
                        setLam(['m2', 'st2'])
                        $('#lam').val('m2');
                    } else if (backVarnish == '1' || frontVarnish == '1') {
                        setLam(['m1', 'm2', 'st1', 'st2'])
                        $('#lam').val('m1');
                    } else {
                        setLam(['none', 'm1', 'm2', 'g1', 'g2', 'st1', 'st2'])
                        $('#lam').val('none');
                    }
                }
            })
        })
    </script>
@endsection
