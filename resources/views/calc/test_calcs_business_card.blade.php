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
                        @foreach($types as $key => $type)
                            <option value="{{$key}}">{{$type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-6" id="diameterWrap">
                            <label for="diameter" class="form-label">Диаметр</label>
                            <input type="number" name="diameter" value="{{$size_width}}" class="form-control"
                                   id="diameter" placeholder="Диаметр">
                        </div>
                        <div class="col-6" id="sizeWrap">
                            <label for="size" class="form-label">Размер в развороте</label>
                            <select id="size" name="size" class="form-select">
                                @foreach($size_options as $key=>$option)
                                    <option value="{{$key}}">{{$option}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3" id="widthWrap">
                            <label for="width" class="form-label">Ширина</label>
                            <input type="number" name="width" value="{{$size_width}}" class="form-control"
                                   aria-describedby="validationFeedback" id="width" placeholder="Ширина"
                                   required>
                        </div>
                        <div class="col-3" id="heightWrap">
                            <label for="height" class="form-label">Высота</label>
                            <input type="number" name="height" value="{{$size_height}}" class="form-control"
                                   id="height" placeholder="Высота" required>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-6" id="product_count_selectWrap">
                            <label for="product_count_select" class="form-label">Количество</label>
                            <select id="product_count_select" name="product_count_select" class="form-select">
                                @foreach($product_count_options as $key=>$option)
                                    <option value="{{$key}}">{{$option}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6" id="product_countWrap">
                            <label for="product_count" class="form-label">Свое количество</label>
                            <input type="number" name="product_count" value="{{$product_count}}" class="form-control"
                                   id="product_count"
                                   placeholder="Количество"
                                   required>
                        </div>
                    </div>
                </div>
                <div class="col-12" id="print_typeWrap">
                    <label for="print_type" class="form-label">Печать</label>
                    <select id="print_type" name="print_type" class="form-select">
                        @foreach($print_types as $key => $type)
                            <option value="{{$key}}">{{$type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="materialWrap">
                    <label for="material" class="form-label">Материал</label>
                    <select id="material" name="material" class="form-select">
                        @foreach($materials as $key=>$materials_category)
                            <optgroup label="{{$key}}">
                                @foreach($materials_category as $material)
                                    <option value="{{$material['id']}}">{!! $material['title']!!}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="duplexWrap">
                    <label for="duplex" class="form-label">Цветность</label>
                    <select id="duplex" name="duplex" class="form-select">
                        <option value="1">Одна сторона</option>
                        <option value="2">Две стороны</option>
                    </select>
                </div>
                <div class="col-12" id="lamWrap">
                    <label for="lam" class="form-label">Ламинация</label>
                    <select id="lam" name="lam" class="form-select">
                        @foreach($lams as $key=>$lam)
                            <option value="{{$key}}">{{$lam}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="foilWrap">
                    <div class="row">
                        <div class="col-6" id="foil_faceWrap">
                            <label for="foil_face" class="form-label">Фольга лицо</label>
                            <select id="foil_face" name="foil_face" class="form-select">
                                @foreach($foiling_colors as $key=>$color)
                                    @if($loop->iteration==1)
                                        @continue
                                    @endif
                                    <option value="{{$key}}">{{$color}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6" id="foil_backWrap">
                            <label for="foil_back" class="form-label">Фольга оборот</label>
                            <select id="foil_back" name="foil_back" class="form-select">
                                @foreach($foiling_colors as $key=>$color)
                                    <option value="{{$key}}">{{$color}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12" id="paintsWrap">
                    <div class="row">
                        <div class="col-6" id="paints_faceWrap">
                            <label for="paints_face" class="form-label">Цвет лицо</label>
                            <select id="paints_face" name="paints_face" class="form-select">
                                @foreach($paints as $key=>$paint)
                                    @if($key==0)
                                        @continue
                                    @endif
                                    <option value="{{$key}}">{{$paint}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6" id="paints_backWrap">
                            <label for="paints_back" class="form-label">Цвет оборот</label>
                            <select id="paints_back" name="paints_back" class="form-select">
                                @foreach($paints as $key=>$paint)
                                    <option value="{{$key}}">{{$paint}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12" id="card_formWrap">
                    <label for="cutting" class="form-label">Форма</label>
                    <select id="cutting" name="cutting" class="form-select">
                        @foreach($card_form as $key=>$form)
                            <option value="{{$key}}">{{$form}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6" id="rounding_cornersWrap">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rounding_corners" name="rounding_corners">
                        <label class="form-check-label" for="rounding_corners">
                            Скругдение углов
                        </label>
                    </div>
                </div>
                <div class="col-6" id="congregationWrap">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="congregation" name="congregation">
                        <label class="form-check-label" for="congregation">
                            Конгрев
                        </label>
                    </div>
                </div>
                <div class="col-12" id="clicheWrap">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="cliche" name="cliche">
                        <label class="form-check-label" for="cliche">
                            Заказать клише
                        </label>
                    </div>
                </div>
                <div class="col-12" id="embossingWrap">
                    <div class="row">
                        <div class="col-6" id="embossing_faceWrap">
                            <label for="embossing_face" class="form-label">Тиснение лицо</label>
                            <select id="embossing_face" name="embossing_face" class="form-select">
                                @foreach($embossing_types as $key=>$embossing)
                                    <option value="{{$key}}">{{$embossing}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6" id="embossing_backWrap">
                            <label for="embossing_back" class="form-label">Тиснение оборот</label>
                            <select id="embossing_back" name="embossing_back" class="form-select">
                                @foreach($embossing_types as $key=>$embossing)
                                    <option value="{{$key}}">{{$embossing}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6" id="embossing_face_2Wrap">
                            <label for="embossing_face_2" class="form-label">Тиснение лицо</label>
                            <select id="embossing_face_2" name="embossing_face_2" class="form-select">
                                @foreach($embossing_types as $key=>$embossing)
                                    <option value="{{$key}}">{{$embossing}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6" id="embossing_back_2Wrap">
                            <label for="embossing_back_2" class="form-label">Тиснение оборот</label>
                            <select id="embossing_back_2" name="embossing_back_2" class="form-select">
                                @foreach($embossing_types as $key=>$embossing)
                                    <option value="{{$key}}">{{$embossing}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12" id="thermal_riseWrap">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="thermal_rise_face"
                                       name="thermal_rise_face">
                                <label class="form-check-label" for="thermal_rise_face">
                                    Объем. лак лицо
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="thermal_rise_back"
                                       name="thermal_rise_back">
                                <label class="form-check-label" for="thermal_rise_back">
                                    Объем. лак оборот
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12" id="varnishWrap">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="varnish_face" name="varnish_face">
                                <label class="form-check-label" for="varnish_face">
                                    Лак лицо
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="varnish_back" name="varnish_back">
                                <label class="form-check-label" for="varnish_back">
                                    Лак оборот
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
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
        function setMaterials(value) {
            let materials = {!! json_encode($materials) !!};
            if (value === 'transparent') {
                materials = {!! json_encode($materials_transparent) !!};
            } else if (value === 'foiling') {
                materials = {!! json_encode($materials_foiling) !!};
            } else if (value === 'vip') {
                materials = {!! json_encode($materials_vip) !!};
            }
            let materialsMarkup = ``;
            for (let key in materials) {
                materialsMarkup += `<optgroup label="${key}">`;
                for (let keyInner in materials[key]) {
                    materialsMarkup += `<option value="${materials[key][keyInner]['id']}">${materials[key][keyInner]['title']}</option>`;
                }
                materialsMarkup += `</optgroup>`;
            }
            $('#material').html(materialsMarkup);
        }

        function setCalcFields(fieldsToShow) {
            let allCalcFields = ["duplexWrap", "foilWrap", "card_formWrap", "rounding_cornersWrap", "lamWrap", "materialWrap", "duplexWrap", "paintsWrap", "print_typeWrap", "diameterWrap", "sizeWrap", "embossingWrap", "congregationWrap", "thermal_riseWrap", "varnishWrap", "clicheWrap"];
            allCalcFields.forEach(item => {
                if (fieldsToShow.includes(item)) {
                    $(`#${item}`).show();
                } else {
                    $(`#${item}`).hide();
                    let checkbox = $(`#${item} input[type="checkbox"]`);
                    if (checkbox.length) {
                        checkbox.prop("checked", false);
                    }
                    let select = $(`#${item} select`);
                    if (select.length) {
                        select.each(function (index) {
                            $(this).val($(this).find('option')[0].getAttribute('value'));
                        })

                    }
                }
            })
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

        function quantityPaintsSelect(el) {
            let allQuantities = ['Без печати', 'Один цвет', 'Два цвета', 'Три цвета', 'Четыре цвета', 'Пять цветов', 'Шесть цветов', 'Семь цветов', 'Восемь цветов'];
            let counter = allQuantities.length - $(el).val();
            let markup = '';
            for (let i = 0; i < counter; i++) {
                if (!($(el).val() == 0 && i === 0)) {
                    markup += `<option value="${i}">${allQuantities[i]}</option>`;
                }
            }
            let siblingId = $(el).attr('id') === 'paints_back' ? 'paints_face' : 'paints_back';
            let siblingValue = $(`#${siblingId}`).val();
            $(`#${siblingId}`).html(markup);
            $(`#${siblingId}`).val(siblingValue);

        }

        $(function (e) {
            setCalcFields(["rounding_cornersWrap", "lamWrap", "materialWrap", "duplexWrap", "sizeWrap"]);
            $('#width').closest('div').hide();
            $('#height').closest('div').hide();
            $('#product_count').closest('div').hide();
            $('#size').on('change', function (e) {
                let sizeValue = $(this).val();
                if (sizeValue === 'custom') {
                    $('#width').closest('div').show();
                    $('#height').closest('div').show();
                } else {
                    let size = sizeValue.split('x');
                    $('#width').val(size[0]);
                    $('#height').val(size[1]);
                    $('#width').closest('div').hide();
                    $('#height').closest('div').hide();
                }
            })
            $('#product_count_select').on('change', function (e) {
                let productCountSelect = $(this).val();
                if (productCountSelect === 'custom') {
                    $('#product_count').closest('div').show();
                } else {
                    $('#product_count').val(productCountSelect);
                    $('#product_count').closest('div').hide();
                }
            })
            $('#type').on('change', function () {
                activateSelect('lam')
                activateSelect('embossing_back')
                activateSelect('embossing_back_2')
                activateSelect('embossing_face')
                activateSelect('embossing_face_2')
                setMaterials();
                if ($(this).val() === 'simple') {
                    setCalcFields(["rounding_cornersWrap", "lamWrap", "materialWrap", "duplexWrap", "sizeWrap"]);
                } else if ($(this).val() === 'foiling') {
                    setCalcFields(["foilWrap", "card_formWrap", "lamWrap", "materialWrap", "print_typeWrap", "sizeWrap"])
                    setMaterials($(this).val())
                } else if ($(this).val() === 'transparent') {
                    setMaterials($(this).val())
                    setCalcFields(["rounding_cornersWrap", "foilWrap", "paintsWrap", "sizeWrap", "embossingWrap", "thermal_riseWrap", "varnishWrap", "clicheWrap"]);
                } else if ($(this).val() === 'round') {
                    setCalcFields(["lamWrap", "materialWrap", "duplexWrap", "diameterWrap"])
                    $('#diameter').val($('#width').val());
                    $('#height').val($('#width').val());
                    blockSelect('lam', 'mat_125')
                } else if ($(this).val() === 'complex') {
                    setCalcFields(["lamWrap", "materialWrap", "duplexWrap", "sizeWrap"])
                    $('#lam option[value="mat_125"]').prop('disabled', true);
                } else if ($(this).val() === 'vip') {
                    setCalcFields(["materialWrap", "rounding_cornersWrap", "sizeWrap", "paintsWrap", "embossingWrap", "thermal_riseWrap", "varnishWrap", "clicheWrap", "congregationWrap"])
                    setMaterials($(this).val())
                }
            })
            $('#diameter').on('change', function () {
                $('#width').val($(this).val());
                $('#height').val($(this).val());
            });
            $('#paintsWrap select').each(function () {
                $(this).on('change', function () {
                    quantityPaintsSelect(this);
                })
            })
            $('#congregation').on('change', function () {
                if ($(this).prop('checked')) {
                    blockSelect('embossing_back', 'none')
                    blockSelect('embossing_back_2', 'none')
                    blockSelect('embossing_face', 'none')
                    blockSelect('embossing_face_2', 'none')
                } else {
                    activateSelect('embossing_back')
                    activateSelect('embossing_back_2')
                    activateSelect('embossing_face')
                    activateSelect('embossing_face_2')
                }
            })
            $(document).on('submit', '#form', function (e) {
                e.preventDefault();
                let frm = $('#form').serialize();
                let url = 'api/calc/test/business';
                $.ajax({
                    url: '/' + url,
                    data: frm,
                    method: 'post',
                    success: function (data) {
                        $('#debugBody').html(data);
                    }
                });
            });
        })
    </script>
@endsection
