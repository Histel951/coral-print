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
                <div class="col-12" id="print_typeWrap">
                    <label for="print_type" class="form-label">Тип печати</label>
                    <select id="print_type" name="print_type" class="form-select">
                        @foreach($print_types as $key => $type)
                            <option value="{{$key}}">{{$type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="sizeWrap">
                    <label for="size" class="form-label">Размер в развороте</label>
                    <select id="size" name="size" class="form-select">
                        @foreach($size_options as $key=>$option)
                            <option value="{{$key}}">{{$option}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6" id="widthWrap">
                    <label for="width" class="form-label">Ширина</label>
                    <input type="number" name="width" class="form-control"
                           aria-describedby="validationFeedback" value="{{$size_width}}" id="width" placeholder="Ширина"
                           required>
                    <div id="validationFeedback" class="invalid-feedback">
                        Минимальный размер 70x100мм или 100x70мм
                    </div>
                </div>
                <div class="col-6" id="heightWrap">
                    <label for="height" class="form-label">Высота</label>
                    <input type="number" name="height" class="form-control" value="{{$size_height}}"
                           id="height" placeholder="Высота" required>
                </div>
                <div class="col-12" id="product_countWrap">
                    <label for="product_count" class="form-label">Количество</label>
                    <input type="number" name="product_count" class="form-control" id="product_count"
                           placeholder="Количество"
                           required>
                </div>
                <div class="col-12" id="add_typeWrap">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="add_type" name="add_type">
                        <label class="form-check-label" for="add_type">
                            Добавить вид
                        </label>
                    </div>
                </div>
                <div class="col-12" id="quantity_typeWrap">
                    <div class="row">
                        @for ($i = 1; $i < 7; $i++)
                            <div class="col-2">
                                <label for="quantity_type{{$i}}" class="form-label">Вид {{$i}}</label>
                                <input type="number" value="0" name="quantity_types[]" class="form-control"
                                       id="quantity_type{{$i}}">
                            </div>
                        @endfor
                    </div>

                </div>
                <div class="col-12" id="materialWrap">
                    <label for="material" class="form-label">Материал</label>
                    <select id="material" name="material" class="form-select">
                        @foreach($materials_inkjet as $key=>$materials)
                            <optgroup label="{{$key}}">
                                @foreach($materials as $material)
                                    <option value="{{$material['id']}}">{{$material['title']}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="lamWrap">
                    <label for="lam" class="form-label">Ламинация</label>
                    <select id="lam" name="lam" class="form-select">
                        @foreach($lams_inkjet as $key=>$lam)
                            <option value="{{$key}}">{{$lam}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="foilingWrap">
                    <label for="foiling" class="form-label">Нанесение</label>
                    <select id="foiling" name="foiling" class="form-select">
                        @foreach($foiling as $key=>$foil_item)
                            <option value="{{$key}}">{{$foil_item}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="foiling_colorWrap">
                    <label for="foiling_color" class="form-label">Фольга</label>
                    <select id="foiling_color" name="foiling_color" class="form-select">
                        @foreach($foiling_colors as $key=>$color)
                            <option value="{{$key}}">{{$color}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="cuttingWrap">
                    <label for="cutting" class="form-label">Нарезка</label>
                    <select id="cutting" name="cutting" class="form-select">
                        @foreach($cutting as $key=>$cut)
                            <option {{$key==='rectangle'||$key==='simple_size'?'disabled':''}} value="{{$key}}">{{$cut}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-6" id="white_printWrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="white_print" name="white_print">
                                <label class="form-check-label" for="white_print">
                                    Печать белым
                                </label>
                            </div>
                        </div>
                        <div class="col-6" id="complex_formWrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="complex_form" name="complex_form">
                                <label class="form-check-label" for="complex_form">
                                    Сложная форма
                                </label>
                            </div>
                        </div>
                        <div class="col-6" id="volumeWrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="volume" name="volume">
                                <label class="form-check-label" for="volume">
                                    Сделать объемной
                                </label>
                            </div>
                        </div>
                        <div class="col-6" id="reverse_stickerWrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="reverse_sticker"
                                       name="reverse_sticker">
                                <label class="form-check-label" for="reverse_sticker">
                                    Обратная наклейка
                                </label>
                            </div>
                        </div>
                        <div class="col-6" id="mounting_filmWrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="mounting_film" name="mounting_film">
                                <label class="form-check-label" for="mounting_film">
                                    Монтажная пленка
                                </label>
                            </div>
                        </div>
                        <div class="col-6" id="small_objectsWrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="small_objects" name="small_objects">
                                <label class="form-check-label" for="small_objects">
                                    Мелкие объекты
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
        function autoSetHeight() {
            let heightInput = $('#height');
            let widthInput = $('#width');
            $('#heightWrap').addClass('d-none');
            $('#widthWrap label').html('Диаметр');
            $('#widthWrap input').attr('placeholder', 'Диаметр');
            heightInput.val(widthInput.val());
            widthInput.on('change', function () {
                heightInput.val($(this).val());
                $('#heightWrap label').html('Высота');
            })
        }

        function setSize() {
            $('#width').val(108);
            $('#height').val(48);
            $('#size').val('108x148');
        }

        function setMaterials(value) {
            let lams = {!! json_encode($lams_inkjet) !!};
            let materials = {!! json_encode($materials_inkjet) !!};
            if (value === 'white_print') {
                materials = {!! json_encode($materials_uf) !!};
            } else if (value === 'laser_foil') {
                materials = {!! json_encode($materials_laser_foil) !!};
            } else if (value === 'laser') {
                lams = {!! json_encode($lams_laser) !!};
                materials = {!! json_encode($materials_laser) !!};
            } else if (value === 'guarantee') {
                materials = {!! json_encode($materials_guarantee) !!};
            }
            let lamsMarkup = ``;
            for (let key in lams) {
                lamsMarkup += `<option value="${key}">${lams[key]}</option>`;
            }
            $('#lam').html(lamsMarkup);
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
            let allCalcFields = ["print_typeWrap", "widthWrap", "heightWrap", "lamWrap", "foilingWrap", "foiling_colorWrap", "cuttingWrap", "white_printWrap", "complex_formWrap", "volumeWrap", "reverse_stickerWrap", "mounting_filmWrap", "sizeWrap", "small_objectsWrap"];
            allCalcFields.forEach(item => {
                if (fieldsToShow.includes(item)) {
                    $(`#${item}`).show();
                } else {
                    $(`#${item}`).hide();
                    let checkbox = $(`#${item} input[type="checkbox"]`);
                    if (checkbox.length) {
                        checkbox.prop("checked", false);
                    }
                }
            })
        }

        function uncheckCheckboxes() {
            let checkbox = $(`#form input[type="checkbox"]`);
            if (checkbox.length) {
                checkbox.each(function (index) {
                    $(this).prop("checked", false);
                    $(this).removeAttr("onclick");
                })
            }
        }

        function activateSelect(name) {
            let input = $(`#${name}Wrap input[type='hidden']`);
            if (input.length) {
                $(`#${name}`).prop('disabled', false);
                input.remove();
            }
        }

        function blockCheckbox(name, disableCheckbox) {
            let checkbox = $(`#${name}`);
            checkbox.prop("checked", true);
            if (disableCheckbox) {
                checkbox.attr("onclick", "return false;");
            }
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

        function setCutting(activeOptions, value = 'common_notch') {
            let options = ['common_notch', 'notch', 'form', 'form_fields', 'rectangle', 'simple_size'];
            options.forEach(item => {
                $(`#cutting option[value="${item}"]`).prop('disabled', !activeOptions.includes(item));
                $('#cutting').val(value);
            })
        }

        $(function () {
            $('#quantity_typeWrap').hide();
            autoSetHeight();
            setCalcFields(["print_typeWrap", "widthWrap", "heightWrap", "lamWrap", "cuttingWrap"])
            $('#type').on('change', function (e) {
                $('#print_type').val('inkjet');
                uncheckCheckboxes();
                activateSelect('lam');
                activateSelect('cutting');
                activateSelect('print_type');
                activateSelect('material')
                setMaterials('inkjet')
                setCutting(["common_notch", "notch", "form", "form_fields"]);
                if ($(this).val() === 'round_logo') {
                    autoSetHeight();
                }
                if ($(this).val() !== 'round_logo') {
                    $('#heightWrap').removeClass('d-none');
                    $("#width").off("change");
                    $('#widthWrap label').html('Ширина');
                    $('#widthWrap input').attr('placeholder', 'Ширина');
                }
                if ($(this).val() !== 'car' || $(this).val() !== 'wall' || $(this).val() !== 'window' || $(this).val() !== 'applique') {
                    let option = $('#print_type option[value="no_print"]');
                    if (option.length) {
                        option.prop("value", "laser").html('Лазерная печать');
                    }
                }
                if ($(this).val() !== 'foil') {
                    let option = $('#foiling option[value="none"]');
                    if (option.length) {
                        $('#foiling option[value="none"]').prop('disabled', false);
                        $('#foiling').val('none');
                    }
                }
                if ($(this).val() === 'round_logo' || $(this).val() === 'rectangle' || $(this).val() === 'oval' || $(this).val() === 'curved') {
                    setCalcFields(["print_typeWrap", "widthWrap", "heightWrap", "lamWrap", "cuttingWrap"])
                } else if ($(this).val() === 'white_print') {
                    setCalcFields(["widthWrap", "heightWrap", "cuttingWrap", 'volumeWrap', "complex_formWrap", "reverse_stickerWrap"]);
                    setMaterials($(this).val());
                } else if ($(this).val() === 'foil') {
                    $('#print_type').val('laser');
                    $('#foiling').val('foiling_only');
                    $('#foiling option[value="none"]').prop('disabled', true);
                    setMaterials('laser');
                    setCalcFields(["widthWrap", "heightWrap", "cuttingWrap", 'volumeWrap', "complex_formWrap", "foilingWrap", "foiling_colorWrap"]);
                } else if ($(this).val() === 'set') {
                    setSize();
                    setCalcFields(["print_typeWrap", "lamWrap", "white_printWrap", "sizeWrap"]);
                } else if ($(this).val() === 'car' || $(this).val() === 'wall' || $(this).val() === 'window' || $(this).val() === 'applique') {
                    let fields = ["print_typeWrap", "widthWrap", "heightWrap", "lamWrap", "cuttingWrap", "complex_formWrap", "mounting_filmWrap"];
                    setCutting(["common_notch", "notch", "rectangle"]);
                    if ($(this).val() === 'window') {
                        fields = [...fields, "white_printWrap", "reverse_stickerWrap", "small_objectsWrap"]
                    } else if ($(this).val() === 'applique') {
                        fields = [...fields, "reverse_stickerWrap", "small_objectsWrap"]
                    } else if ($(this).val() === 'car') {
                        fields = [...fields, "white_printWrap", "reverse_stickerWrap"]
                    }
                    $('#print_type option[value="laser"]').prop("value", "no_print").html('Без печати');
                    setCalcFields(fields);

                } else if ($(this).val() === 'ordinary' || $(this).val() === 'guarantee' || $(this).val() === 'simple_paper') {
                    let fields = ["cuttingWrap"];
                    if ($(this).val() === 'ordinary') {
                        setCutting(["common_notch", "notch", "form_fields"]);
                        fields = [...fields, 'complex_formWrap', "widthWrap", "heightWrap"];
                    } else if ($(this).val() === 'guarantee') {
                        setMaterials($(this).val())
                        fields = [...fields, 'complex_formWrap', "widthWrap", "heightWrap"];
                        blockSelect('cutting', 'common_notch')
                        blockSelect('material', 64)
                    } else {
                        setSize();
                        fields = [...fields, "sizeWrap"];
                        $('#print_type').val('laser');
                        setMaterials('laser');
                        setCutting(["simple_size"], "simple_size");
                        blockSelect('material', 48)
                    }
                    setCalcFields(fields);
                }
            })
            $('#print_type').on('change', function (e) {
                uncheckCheckboxes();
                activateSelect('lam');
                if ($(this).val() == 'no_print') {
                    setCutting(["common_notch", "notch"]);
                } else {
                    if ($('#type').val() === 'wall' || $('#type').val() === 'window') {
                        console.log(1)
                        setCutting(["common_notch", "notch", "rectangle"]);
                    } else if ($('#type').val() === 'ordinary') {
                        setCutting(["common_notch", "notch", "form_fields"]);
                    } else {
                        setCutting(["common_notch", "notch", "form", "form_fields"]);
                    }
                }
                if ($('#type').val() === 'set') {
                    if ($(this).val() === 'inkjet') {
                        setCalcFields(["print_typeWrap", "lamWrap", "white_printWrap", "sizeWrap"]);
                        activateSelect('lam');
                        $('#foiling option[value="none"]').prop('disabled', false);
                        $('#foiling').val('none');
                    } else {
                        setCalcFields(["print_typeWrap", "lamWrap", "foilingWrap", "foiling_colorWrap", "sizeWrap"]);
                    }
                } else if ($('#type').val() === 'car' || $('#type').val() === 'wall' || $('#type').val() === 'window' || $('#type').val() === 'applique') {
                    if ($(this).val() === 'inkjet') {
                        let fields = ["print_typeWrap", "widthWrap", "heightWrap", "lamWrap", "cuttingWrap", "complex_formWrap", "mounting_filmWrap", "reverse_stickerWrap"];
                        if ($('#type').val() === 'window') {
                            fields = [...fields, "white_printWrap"];
                        } else if ($('#type').val() === 'applique') {
                            blockCheckbox('complex_form')
                            blockCheckbox('mounting_film')
                        }
                        setCalcFields(fields);
                        activateSelect('cutting')
                    } else {
                        let fields = ["print_typeWrap", "widthWrap", "heightWrap", "cuttingWrap", "complex_formWrap", "mounting_filmWrap"];
                        if ($(this).val() === 'window' || $('#type').val() === 'applique' || $('#type').val() === 'car') {
                            fields = [...fields, "reverse_stickerWrap"];
                        }
                        setCalcFields(fields);
                        blockSelect('cutting', 'notch');
                        blockCheckbox('complex_form')
                        blockCheckbox('mounting_film')
                    }
                }
                setMaterials($(this).val());
            });
            $('#foiling').on('change', function (e) {
                if ($('#type').val() === 'set') {
                    if ($(this).val() === 'foiling_only' || $(this).val() === 'foiling_print') {
                        blockSelect('lam', 'matt_25')
                    } else {
                        activateSelect('lam')
                    }
                }
            });

            $('#size').on('change', function (e) {
                let sizeValue = $(this).val();
                if (sizeValue === 'custom') {
                    $('#widthWrap').show();
                    $('#heightWrap').show();
                } else {
                    let size = sizeValue.split('x');
                    $('#width').val(size[0]);
                    $('#height').val(size[1]);
                    $('#widthWrap').hide();
                    $('#heightWrap').hide();
                }
            })

            $('#reverse_sticker').on('change', function () {
                if ($('#lamWrap').css('display') !== 'none') {
                    if ($(this).prop('checked')) {
                        blockSelect('lam', 'glossy_80')
                    } else {
                        activateSelect('lam')
                    }
                }
            });

            $('#mounting_film').on('change', function () {
                if ($(this).prop('checked')) {
                    blockCheckbox('complex_form', true)
                    blockSelect('cutting', 'notch')
                    if ($('#type').val() === 'window' || $('#type').val() === 'applique') {
                        $('#small_objectsWrap').show();
                    }
                } else {
                    $('#complex_form').removeAttr('onclick');
                    activateSelect('cutting');
                    $('#small_objects').prop('checked', false);
                    $('#small_objectsWrap').hide();
                }
            });

            $('#white_print').on('change', function (e) {
                if ($(this).prop('checked')) {
                    setMaterials('white_print');
                    blockSelect('lam');
                    blockSelect('print_type')
                } else {
                    setMaterials();
                    activateSelect('lam');
                    activateSelect('print_type');
                }
            })

            $('#volume').on('change', function () {
                if ($('#type').val() === 'foil') {
                    if ($(this).prop('checked')) {
                        setMaterials('laser_foil');
                        setCutting(["common_notch", "notch", "form_fields"]);
                    } else {
                        setMaterials('laser');
                        setCutting(["common_notch", "notch", "form", "form_fields"]);
                    }
                }
            })

            $('#add_type').on('change', function (e) {
                if ($(this).prop('checked')) {
                    $('#quantity_typeWrap').show();
                    $('#product_count').prop('readonly', true);
                } else {
                    $('#quantity_typeWrap').hide();
                    $('#product_count').prop('readonly', false);
                }
            })
            let quantity_typeWrapInputs = $('#quantity_typeWrap input');
            quantity_typeWrapInputs.on('change', function (e) {
                let quantity = 0;
                quantity_typeWrapInputs.each(function (item) {
                    quantity += parseInt($(this).val());
                });
                $('#product_count').val(quantity);
            })

            $(document).on('submit', '#form', function (e) {
                e.preventDefault();
                let frm = $('#form').serialize();
                let url = 'api/calc/test/stickers?test=1';
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
