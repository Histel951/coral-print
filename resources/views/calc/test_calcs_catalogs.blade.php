@extends('calc.test_calcs_layout')

@section('title')
    {{ $title }}
@endsection

@section('content')
        <a class="btn btn-danger" href="{{ url()->previous() }}">Назад</a>
    <div class="row">
        <div class="col-12 col-lg-4">
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
                <div class="col-12" id="springWrap">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="spring" id="spring1" value="top">
                        <label class="form-check-label" for="spring1">Сверху</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="spring" id="spring2" value="left">
                        <label class="form-check-label" for="spring2">Слева</label>
                    </div>
                </div>
                <div class="col-12" id="sizeWrap">
                    <label for="size" class="form-label">Формат/размер</label>
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
                </div>
                <div class="col-6" id="heightWrap">
                    <label for="height" class="form-label">Высота</label>
                    <input type="number" name="height" class="form-control" value="{{$size_height}}"
                           id="height" placeholder="Высота" required>
                </div>
                <div class="col-12" id="page_selectWrap">
                    <label for="page_select" class="form-label">Страниц в каталоге</label>
                    <select id="page_select" name="page_select" class="form-select">
                        @foreach($page_options as $key=>$option)
                            <option value="{{$key}}">{{$option}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="page_countWrap">
                    <label for="page_count" class="form-label">Количество страниц</label>
                    <input type="number" name="page_count" value="{{$page_count}}" class="form-control"
                           id="page_count"
                           placeholder="Количество страниц"
                           required>
                </div>
                <div class="col-12" id="product_countWrap">
                    <label for="product_count" class="form-label">Количество</label>
                    <input type="number" name="product_count" value="{{$product_count}}" class="form-control"
                           id="product_count"
                           placeholder="Количество"
                           required>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills justify-content-around mb-3 border p-3">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-cover-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-cover" type="button" role="tab"
                                            aria-controls="pills-cover"
                                            aria-selected="true">Обложка
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-block-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-block" type="button" role="tab"
                                            aria-controls="pills-block"
                                            aria-selected="false">Блок
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-substrate-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-substrate" type="button" role="tab"
                                            aria-controls="pills-substrate"
                                            aria-selected="false">Подложка
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-cover" role="tabpanel"
                                     aria-labelledby="pills-home-tab">
                                    <div class="row">
                                        <div class="col-12 mb-3" id="materialCoverWrap">
                                            <label for="material_cover" class="form-label">Материал</label>
                                            <select id="material_cover" name="material_cover" class="form-select">
                                                @foreach($materials_cover as $key=>$materials_category)
                                                    <optgroup label="{{$key}}">
                                                        @foreach($materials_category as $material)
                                                            <option value="{{$material['id']}}">{!! $material['title']!!}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 mb-3" id="print_type_coverWrap">
                                            <label for="print_type_cover" class="form-label">Цветность</label>
                                            <select id="print_type_cover" name="print_type_cover" class="form-select">
                                                @foreach($print_types as $type)
                                                    <option value="{{$loop->index}}">{{$type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 mb-3" id="lam_coverWrap">
                                            <label for="lam_cover" class="form-label">Ламинация</label>
                                            <select id="lam_cover" name="lam_cover" class="form-select">
                                                @foreach($lams as $key=>$lam)
                                                    <option value="{{$key}}">{{$lam}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 mb-3" id="foilWrap">
                                            <label for="foil" class="form-label">Фольга</label>
                                            <select id="foil" name="foil" class="form-select">
                                                @foreach($foiling_colors as $key=>$color)
                                                    <option value="{{$key}}">{{$color}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12" id="varnishWrap">
                                            <div class="row">
                                                <div class="col-6" id="varnishWrap">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="varnish"
                                                               name="varnish">
                                                        <label class="form-check-label" for="varnish">
                                                            Лак
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6" id="plastic_coverWrap">
                                                    <input class="form-check-input" type="checkbox" id="plastic_cover"
                                                           name="plastic_cover" value="plastic">
                                                    <label class="form-check-label" for="varnish">
                                                        Пластик
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-block" role="tabpanel"
                                     aria-labelledby="pills-contact-tab">
                                    <div class="row">
                                        <div class="col-12 mb-3" id="materialBlockWrap">
                                            <label for="material_block" class="form-label">Материал</label>
                                            <select id="material_block" name="material_block" class="form-select">
                                                @foreach($materials_block as $key=>$materials_category)
                                                    <optgroup label="{{$key}}">
                                                        @foreach($materials_category as $material)
                                                            <option value="{{$material['id']}}">{!! $material['title']!!}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 mb-3" id="print_type_blockWrap">
                                            <label for="print_type_block" class="form-label">Цветность</label>
                                            <select id="print_type_block" name="print_type_block" class="form-select">
                                                @foreach($print_types as $type)
                                                    <option value="{{$loop->index}}">{{$type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-substrate" role="tabpanel"
                                     aria-labelledby="pills-contact-tab">
                                    <div class="row">
                                        <div class="col-12 mb-3" id="substrateWrap">
                                            <div class="row">
                                                <div class="col-12 mb-3" id="plastic_substrateWrap">
                                                    <label for="plastic_substrate" class="form-label">Пластик</label>
                                                    <select id="plastic_substrate" name="plastic_substrate"
                                                            class="form-select">
                                                        @foreach($plastics as $key=>$plastic)
                                                            <option value="{{$key}}">{{$plastic}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 mb-3" id="materialSubstrateWrap">
                                                    <label for="material_substrate" class="form-label">Материал</label>
                                                    <select id="material_substrate" name="material_substrate"
                                                            class="form-select">
                                                        @foreach($materials_substrate as $key=>$materials_category)
                                                            <optgroup label="{{$key}}">
                                                                @foreach($materials_category as $material)
                                                                    <option value="{{$material['id']}}">{!! $material['title']!!}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 mb-3" id="print_type_substrateWrap">
                                                    <label for="print_type_substrate"
                                                           class="form-label">Цветность</label>
                                                    <select id="print_type_substrate" name="print_type_substrate"
                                                            class="form-select">
                                                        @foreach($print_types as $type)
                                                            <option value="{{$loop->index}}">{{$type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3" id="lamSubstrateWrap">
                                                <label for="lam_substrate" class="form-label">Ламинация</label>
                                                <select id="lam_substrate" name="lam_substrate" class="form-select">
                                                    @foreach($lams as $key=>$lam)
                                                        <option value="{{$key}}">{{$lam}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
             class="col-12 col-lg-8">
            <h1 class="text-center">Debug will be here</h1>
            <div id="debugBody">
            </div>
        </div>
    </div>
    <script>
        function setCalcFields(fieldsToShow) {
            let allCalcFields = ["pills-substrate-tab", "plastic_coverWrap", "plastic_substrateWrap", "springWrap", 'page_selectWrap', 'page_countWrap'];
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
            $(`#${name}`).prop('disabled', false);
            if (input.length) {
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

        function setPrintTypeOptions(name, showOptions) {
            let allOptionsNames = [0, 1, 2, 3, 4];
            allOptionsNames.forEach((item) => {
                $(`#${name} option[value="${item}"]`).prop('disabled', !showOptions.includes(item));
            })
            $(`#${name}`).val(showOptions[0]);
        }

        function setLamOptions(name, showOptions) {
            let allOptionsNames = ['none', 'mat_25', 'mat_25_1', 'glossy_25', 'glossy_25_1', 'soft_touch', 'soft_touch_1'];
            allOptionsNames.forEach((item) => {
                $(`#${name} option[value="${item}"]`).prop('disabled', !showOptions.includes(item));
                $(`#${name}`).val(showOptions[0]);
            })
        }

        function unblockPlasticOnly(name) {
            activateSelect('material_' + name);
            activateSelect('lam_' + name);
            activateSelect('print_type_' + name);
            activateSelect('foil');
            $('#varnish').prop('disabled', false);
        }

        function addPlasticEvent(name) {
            $('#plastic_' + name).on('change', function () {
                if ($(this).val() === 'plastic_only') {
                    blockSelect('lam_' + name, 'none');
                    blockSelect('print_type_' + name, '0');
                    blockSelect('material_' + name, 'none');
                    blockSelect('foil', '0');
                    let varnish = $('#varnish');
                    varnish.prop('checked', false);
                    varnish.prop('disabled', true);
                } else {
                    unblockPlasticOnly(name)
                }
            })
        }

        function blockCheckbox(name, disableCheckbox) {
            let checkbox = $(`#${name}`);
            checkbox.prop("checked", true);
            if (disableCheckbox) {
                checkbox.attr("onclick", "return false;");
            }
        }

        $(function (e) {
            setCalcFields(['page_selectWrap']);
            setPrintTypeOptions('print_type_block', [2, 4]);
            setPrintTypeOptions('print_type_cover', [1, 2, 3, 4]);
            $('#width').closest('div').hide();
            $('#height').closest('div').hide();
            $('#type').on('change', function () {
                unblockPlasticOnly('cover')
                unblockPlasticOnly('substrate')
                setPrintTypeOptions('print_type_block', [2, 4]);
                setPrintTypeOptions('print_type_cover', [1, 2, 3, 4]);
                $('#page_countWrap label').html('Количество страниц');
                if ($(this).val() === 'adhesive_catalog') {
                    setCalcFields(["page_countWrap"]);
                    setPrintTypeOptions('print_type_cover', [1, 2]);
                    setPrintTypeOptions('print_type_block', [1, 2, 3, 4]);
                } else if ($(this).val() === 'presentations') {
                    setCalcFields(["pills-substrate-tab", "plastic_coverWrap", "plastic_substrateWrap", "springWrap", "page_countWrap"]);
                    setPrintTypeOptions('print_type_block', [1, 2, 3, 4]);
                } else if ($(this).val() === 'notepads' || $(this).val() === 'spring_catalog') {
                    setCalcFields(["pills-substrate-tab", "page_countWrap"]);
                    let options = [1, 2, 3, 4];
                    if ($(this).val() === 'notepads') {
                        options.unshift(0);
                    }
                    setPrintTypeOptions('print_type_block', options);
                    if ($(this).val() === 'notepads') {
                        $('#page_countWrap label').html('Количество листов');
                    }
                } else if ($(this).val() === 'notebooks' || $(this).val() === 'bracket_catalog') {
                    setCalcFields(['page_selectWrap']);
                    $('#page_count').val(8);
                    $('#page_select').val(8);
                    if ($(this).val() === 'notebooks') {
                        setPrintTypeOptions('print_type_block', [0, 2, 4]);
                    }
                }
            })
            // $('#material').on('change', function () {
            //     if ($(this).val() == '79' || $(this).val() == '82' || $(this).val() == '84' || $(this).val() == '85' || $(this).val() == '86' || $(this).val() == '87' || $(this).val() == '88' || $(this).val() == '89') {
            //         blockSelect('lam', 'none');
            //     } else {
            //         activateSelect('lam');
            //     }
            // });

            $('#varnish').on('change', function () {
                if ($(this).prop('checked') === true) {
                    setLamOptions('lam_cover', ['mat_25', 'mat_25_1']);
                } else {
                    setLamOptions('lam_cover', ['none', 'mat_25', 'mat_25_1', 'glossy_25', 'glossy_25_1', 'soft_touch', 'soft_touch_1']);
                }
            })

            $('#foil').on('change', function () {
                if ($(this).val() !== '0') {
                    setLamOptions('lam_cover', ['mat_25', 'mat_25_1']);
                } else {
                    setLamOptions('lam_cover', ['none', 'mat_25', 'mat_25_1', 'glossy_25', 'glossy_25_1', 'soft_touch', 'soft_touch_1']);
                }
            });

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
            $('#page_select').on('change', function () {
                $('#page_count').val($(this).val());
            })
            addPlasticEvent('cover');
            addPlasticEvent('substrate');
            $(document).on('submit', '#form', function (e) {
                e.preventDefault();
                let frm = $('#form').serialize();
                let url = 'api/calc/test/catalog';
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
