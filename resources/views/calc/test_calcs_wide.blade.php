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
                <div class="col-12" id="assemblyWrap">
                    <div class="row">
                        <div class="col-6">
                            <label for="assembly" class="form-label">Сборка</label>
                            <select id="assembly" name="assembly" class="form-select">
                                @foreach($assemblies as $key=>$assembly)
                                    <option value="{{$key}}">{{$assembly}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3" id="assembly_widthWrap">
                            <label for="assembly_width" class="form-label">Ширина</label>
                            <select id="assembly_width" name="assembly_width" class="form-select">
                                @foreach($assemble_sizes as $key=>$assembly_size)
                                    <option data-size="{{$assembly_size}}" value="{{$key}}">{{$assembly_size}}см
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="assembly_width_size" id="assembly_width_size">
                        </div>
                        <div class="col-3" id="assembly_heightWrap">
                            <label for="assembly_height" class="form-label">Высота</label>
                            <select id="assembly_height" name="assembly_height" class="form-select">
                                @foreach($assemble_sizes as $key=>$assembly_size)
                                    <option data-size="{{$assembly_size}}" value="{{$key}}">{{$assembly_size}}см
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="assembly_height_size" id="assembly_height_size">
                        </div>
                    </div>

                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-6" id="sizeWrap">
                            <label for="size" class="form-label">Размер в развороте</label>
                            <select id="size" name="size" class="form-select">
                                @foreach($size_options as $key=>$option)
                                    <option value="{{$key}}">{{$option}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3" id="widthWrap">
                            <label for="width" class="form-label">Ширина (<span>м</span>)</label>
                            <input type="number" value="1" step="any" name="width" class="form-control"
                                   id="width" placeholder="Ширина" required>
                        </div>
                        <div class="col-3" id="heightWrap">
                            <label for="height" class="form-label">Высота (<span>м</span>)</label>
                            <input type="number" value="1" step="any" name="height" class="form-control"
                                   id="height" placeholder="Высота" required>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label for="product_count" class="form-label">Количество</label>
                    <input type="number" name="product_count" value="{{$product_count}}" class="form-control"
                           id="product_count"
                           placeholder="Количество"
                           required>
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
                <div class="col-12" id="grommetWrap">
                    <label for="grommet" class="form-label">Люверсы</label>
                    <select id="grommet" name="grommet" class="form-select">
                        @foreach($grommets as $key=>$grommet)
                            <option value="{{$key}}">{{$grommet}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="baseWrap">
                    <label for="base" class="form-label">Основа</label>
                    <select id="base" name="base" class="form-select">
                        @foreach($bases as $key=>$base)
                            <option value="{{$key}}">{{$base}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-4" id="gluingWrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gluing" name="gluing">
                                <label class="form-check-label" for="gluing">
                                    Проклейка
                                </label>
                            </div>
                        </div>
                        <div class="col-4" id="varnishWrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="varnish" name="varnish">
                                <label class="form-check-label" for="varnish">
                                    Покрытие лаком
                                </label>
                            </div>
                        </div>
                        <div class="col-4" id="knurlingWrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="knurling" name="knurling">
                                <label class="form-check-label" for="knurling">
                                    Накатка с двух сторон
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
        function setMaterials(type) {
            $.get(`/api/calc/test/wide/materials?type=${type}`, function (data) {
                $('#material').html(data);
            });

        }

        function setCalcFields(fieldsToShow) {
            let allCalcFields = ["assemblyWrap", "sizeWrap", "widthWrap", "heightWrap", "lamWrap", "grommetWrap", "gluingWrap", "varnishWrap", "knurlingWrap", "baseWrap", "assembly_widthWrap", "assembly_heightWrap"];
            allCalcFields.forEach(item => {
                if (fieldsToShow.includes(item)) {
                    $(`#${item}`).show();
                } else {
                    $(`#${item}`).hide();
                    let checkbox = $(`#${item} input[type="checkbox"]`);
                    if (checkbox.length) {
                        checkbox.prop("checked", false);
                        if (checkbox.attr('onclick')) {
                            checkbox.removeAttr('onclick');
                        }
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

        function setCheckboxState(name, setChecked, disableCheckbox) {
            let checkbox = $(`#${name}`);
            checkbox.prop("checked", setChecked);
            if (disableCheckbox) {
                checkbox.attr("onclick", "return false;");
            } else if (checkbox.attr("onclick")) {
                checkbox.removeAttr("onclick");
            }
        }

        function blockCheckbox(name, disableCheckbox) {
            let checkbox = $(`#${name}`);
            checkbox.prop("checked", true);
            if (disableCheckbox) {
                checkbox.attr("onclick", "return false;");
            }
        }

        function setAssemblySize(name) {
            let size = $('#' + name).find('option:selected').attr('data-size');
            let size_name = $('#' + name).attr('id');
            $('#' + size_name + '_size').val(size);
        }

        $(function (e) {
            setCalcFields(["grommetWrap", "widthWrap", "heightWrap", "gluingWrap"]);
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
            $('#type').on('change', function () {
                if ($(this).val() != 'banner') {
                    let sizeValue = $('#size').val();
                    let size = sizeValue.split('x');
                    $('#width').val(size[0]);
                    $('#height').val(size[1]);
                    $('#widthWrap label span').html('мм');
                    $('#heightWrap label span').html('мм');
                } else {
                    $('#widthWrap label span').html('м');
                    $('#width').val(1);
                    $('#heightWrap label span').html('м');
                    $('#height').val(1);
                }
                let fields = [];
                switch ($(this).val()) {
                    case 'banner':
                        fields = ["grommetWrap", "widthWrap", "heightWrap", "gluingWrap"];
                        break;
                    case 'posters':
                        fields = ["sizeWrap", "lamWrap"];
                        break;
                    case 'film':
                        fields = ["widthWrap", "heightWrap", "lamWrap"];
                        break;
                    case 'canvas':
                        fields = ["assemblyWrap", "sizeWrap", "varnishWrap"];
                        break;
                    case 'plaques':
                        fields = ["widthWrap", "heightWrap", "lamWrap", "knurlingWrap", "baseWrap"];
                        break;
                }
                setCalcFields(fields)
                setMaterials($(this).val());
            })
            $('#assembly').on('change', function () {
                if ($(this).val() != 'none') {
                    $('#assembly_widthWrap').show();
                    $('#assembly_heightWrap').show();
                    $('#sizeWrap').hide();
                    setAssemblySize('assembly_height')
                    setAssemblySize('assembly_width')
                } else {
                    $('#assembly_widthWrap').hide();
                    $('#assembly_heightWrap').hide();
                    $('#sizeWrap').show();
                }

            })
            $('#assembly_width, #assembly_height').each(function () {
                $(this).on('change', function () {
                    setAssemblySize($(this).attr('id'))
                })
            })
            $('#grommet').on('change', function () {
                if ($(this).val() === 'corners') {
                    setCheckboxState("gluing", true, true);
                } else {
                    setCheckboxState("gluing", false, false);
                }
            })
            $(document).on('submit', '#form', function (e) {
                e.preventDefault();
                if ($('#type').val() === 'banner') {
                    $('#width').val(parseFloat($('#width').val()) * 1000)
                    $('#height').val(parseFloat($('#height').val()) * 1000)
                }
                let frm = $('#form').serialize();
                if ($('#type').val() === 'banner') {
                    $('#width').val(parseFloat($('#width').val()) / 1000)
                    $('#height').val(parseFloat($('#height').val()) / 1000)
                }
                let url = 'api/calc/test/wide';
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
