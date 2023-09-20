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
                        <div class="col-6" id="widthWrap">
                            <label for="width" class="form-label">Ширина</label>
                            <input type="number" name="width" value="{{$size_width}}" class="form-control"
                                   aria-describedby="validationFeedback" id="width" placeholder="Ширина"
                                   required>
                        </div>
                        <div class="col-6" id="heightWrap">
                            <label for="height" class="form-label">Высота</label>
                            <input type="number" name="height" value="{{$size_height}}" class="form-control"
                                   id="height" placeholder="Высота" required>
                        </div>
                    </div>
                </div>
                <div class="col-12" id="product_countWrap">
                    <label for="product_count" class="form-label">Количество</label>
                    <input type="number" name="product_count" value="{{$product_count}}" class="form-control"
                           id="product_count"
                           placeholder="Количество"
                           required>
                </div>
                <div class="col-12" id="duplexWrap">
                    <label for="duplex" class="form-label">Цветность</label>
                    <select id="duplex" name="duplex" class="form-select">
                        <option value="1">Односторонние цветные</option>
                        <option value="2">Двухсторонние цветные</option>
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
                <div class="col-12" id="holeWrap">
                    <label for="hole" class="form-label">Отверстие</label>
                    <select id="hole" name="hole" class="form-select">
                        @foreach($holes as $key=>$hole)
                            <option value="{{$key}}">{{$hole}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-6" id="rounding_cornersWrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rounding_corners"
                                       name="rounding_corners">
                                <label class="form-check-label" for="rounding_corners">
                                    Скругдение углов
                                </label>
                            </div>
                        </div>
                        <div class="col-6" id="foldedWrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="folded" name="folded">
                                <label class="form-check-label" for="folded">
                                    Изделие со сложением
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
        function setCalcFields(fieldsToShow) {
            let allCalcFields = ["diameterWrap", "widthWrap", "heightWrap", "holeWrap", "rounding_cornersWrap", "foldedWrap"];
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
                $(`#${name}`).val($(`#${name}`).find('option')[0].getAttribute('value'));
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

        function setDiameter() {
            $('#diameter').val($('#width').val());
            $('#height').val($('#width').val());
        }

        $(function (e) {
            setCalcFields(["widthWrap", "heightWrap", "holeWrap", "rounding_cornersWrap", "foldedWrap"]);
            $('#type').on('change', function () {
                activateSelect('lam');
                if ($(this).val() === 'simple_tags') {
                    setCalcFields(["widthWrap", "heightWrap", "holeWrap", "rounding_cornersWrap", "foldedWrap"]);
                } else if ($(this).val() === 'round_tags') {
                    setCalcFields(["diameterWrap", "holeWrap"]);
                    setDiameter();
                } else if ($(this).val() === 'complex_tags') {
                    setCalcFields(["widthWrap", "heightWrap", "holeWrap"]);
                } else if ($(this).val() === 'simple_wobblers') {
                    setCalcFields(["widthWrap", "heightWrap", "rounding_cornersWrap"]);
                } else if ($(this).val() === 'round_wobblers') {
                    setCalcFields(["diameterWrap"]);
                    setDiameter();
                } else if ($(this).val() === 'complex_wobblers' || $(this).val() === 'hangers') {
                    setCalcFields(["widthWrap", "heightWrap"]);
                }
            })
            $('#diameter').on('change', function () {
                $('#width').val($(this).val());
                $('#height').val($(this).val());
            });
            $('#material').on('change', function () {
                if ($(this).val() == '79' || $(this).val() == '82' || $(this).val() == '84' || $(this).val() == '85' || $(this).val() == '86' || $(this).val() == '87' || $(this).val() == '88' || $(this).val() == '89') {
                    blockSelect('lam', 'none');
                } else {
                    activateSelect('lam');
                }
            });

            $('#foilWrap select').each(function () {
                $(this).on('change', function () {
                    if ($('#foil_face').val() !== '0' || $('#foil_back').val() !== '0') {
                        blockSelect('lam', 'mat_25_1')
                    } else {
                        activateSelect('lam');
                    }
                })
            });

            $(document).on('submit', '#form', function (e) {
                e.preventDefault();
                let frm = $('#form').serialize();
                let url = 'api/calc/test/tags';
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
