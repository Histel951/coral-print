@extends('calc.test_calcs_layout')
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>--}}
    <script src="/assets/js/html2canvas.min.js"></script>
@endpush

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
                    <label for="flexForm" class="form-label">Форма</label>
                    <select id="flexForm" name="form" class="form-select">
                        @foreach($forms as $form)
                            <option value="{{$form['id']}}">{{$form['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="knife" class="form-label">Размер</label>
                    <select id="knife" name="knife" class="form-select">
                        @foreach($knifes as $knife)
                            <option value="{{$knife['id']}}" data-price="{{$knife['price']}}"
                                    data-price-percent="{{$knife['price_percent']}}">{{$knife['height'].'x'.$knife['width'].' мм'}}
                                (R={{$knife['radius']}} мм)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="product_count" class="form-label">Количество</label>
                    <input type="number" value="1000" name="product_count" class="form-control" id="product_count"
                           placeholder="Количество"
                           required>
                </div>
                <div class="col-6">
                    <label for="sleeve_quantity" class="form-label">Количество втулок</label>
                    <input type="number" name="sleeve_quantity" class="form-control" id="sleeve_quantity"
                           placeholder="Количество втулок">
                </div>
                <div class="col-12">
                    <label for="material" class="form-label">Материал</label>
                    <select class="form-select" id="material" name="material">
                        @foreach($materials_select as $material_name=>$material_group)
                            <optgroup label="{{$material_name}}">
                                @foreach($material_group as $material)
                                    <option data-type={{$material['type']}} value="{{$material['id']}}">{{$material['name']}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="color" class="form-label">Цветность</label>
                    <select id="color" name="color" class="form-select">
                        @foreach($colors as $color)
                            <option data-paints="{{$color['paints']}}"
                                    value="{{$color['id']}}">{{$color['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="ribbon" class="form-label">Термо печать</label>
                    <select id="ribbon" name="ribbon" class="form-select" disabled>
                        @foreach($ribbon as $item)
                            <option value="{{$item['id']}}">{{$item['label']}}</option>
                        @endforeach
                    </select>
                </div>
                <div id="custom-colors"></div>
                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="additional">
                                <label class="form-check-label" for="additional">
                                    Доп параметры
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" name="dummy" type="checkbox" id="dummy">
                                <label class="form-check-label" for="dummy">
                                    Пустышка
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" name="thermal" type="checkbox" id="thermal">
                                <label class="form-check-label" for="thermal">
                                    Термо печать
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="additionalBlock" class="row d-none">
                    <div class="col-6">
                        <label for="quantity_colors" class="form-label">Количество цветов
                            <svg data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right"
                                 data-bs-content="* этот параметр влияет на приладки и печатные формы, таким образом мы читаем весь заказ с общим ножом (размер этикеток одинаковый) к примеру заказ использует несколько видов цветных но один из цветов там общий к примеру черный, по этому черная форма по нему будет одна общая для всех видов цветных наклеек"
                                 xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#0d6efd"
                                 class="bi bi-info-circle curso" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>
                        </label>
                        <input type="text" name="quantity_colors" class="form-control" id="quantity_colors"
{{--                               placeholder="{{count(explode(",", $colors[0]['paints']))}}">--}}
                               placeholder="2">
                    </div>
                    <div class="col-6">
                        <label for="fixed_price" class="form-label">Фиксированная стоимость (евро)</label>
                        <input type="text" name="fixed_price" class="form-control" id="fixed_price"
                               placeholder="{{$settings['fixed_price']}}">
                    </div>
                    <div class="col-6">
                        <label for="makeready" class="form-label">Приладка (метры)</label>
                        <input type="text" name="makeready" class="form-control" id="makeready"
                               placeholder="{{$settings['makeready']}}">
                    </div>
                    <div class="col-6">
                        <label for="flexa_min_price" class="form-label">Мин. стоимость приладки (руб)</label>
                        <input type="text" name="flexa_min_price" class="form-control" id="flexa_min_price"
                               placeholder="{{$settings['flexa_min_price']}}">
                    </div>
                    <div class="col-6">
                        <label for="knife_price" class="form-label">Себестоимость ножа</label>
                        <input type="text" name="knife_price" class="form-control" id="knife_price"
                               placeholder="{{$knifes[0]['price']}}">
                    </div>
                    <div class="col-6">
                        <label for="knife_price_percent" class="form-label">Наценка на нож</label>
                        <input type="text" name="knife_price_percent" class="form-control" id="knife_price_percent"
                               placeholder="{{$knifes[0]['price_percent']}}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="row mx-4">
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="print_position" id="inlineRadio1"
                                       value="up" checked>
                                <label class="form-check-label" for="inlineRadio1">1</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="print_position" id="inlineRadio2"
                                       value="down">
                                <label class="form-check-label" for="inlineRadio2">2</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="print_position" id="inlineRadio3"
                                       value="left">
                                <label class="form-check-label" for="inlineRadio3">3</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="print_position" id="inlineRadio4"
                                       value="right">
                                <label class="form-check-label" for="inlineRadio4">4</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="print_position" id="inlineRadio5"
                                       value="up-reverse">
                                <label class="form-check-label" for="inlineRadio5">5</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="print_position" id="inlineRadio6"
                                       value="down-reverse">
                                <label class="form-check-label" for="inlineRadio6">6</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="print_position" id="inlineRadio7"
                                       value="left-reverse">
                                <label class="form-check-label" for="inlineRadio7">7</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="print_position" id="inlineRadio8"
                                       value="right-reverse">
                                <label class="form-check-label" for="inlineRadio8">8</label>
                            </div>
                        </div>
                    </div>
                </div>
                <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="595.3px" height="56.7px" viewBox="-147.6 121.7 595.3 56.7"
                     enable-background="new -147.6 121.7 595.3 56.7"
                     xml:space="preserve">
<g>

    <rect x="392.3" y="124.1" fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" width="47.6"
          height="36.6"/>
    <path fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" d="M374.1,131.8v36.4c0,4.2,8.2,7.7,18.2,7.7
		c10.1,0,18.2-3.4,18.2-7.7v-36.4H374.1z"/>

    <rect x="316.3" y="124.1" fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" width="47.6"
          height="36.6"/>
    <path fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" d="M298.1,131.8v36.4c0,4.2,8.2,7.7,18.2,7.7
		c10.1,0,18.2-3.4,18.2-7.7v-36.4H298.1z"/>

    <rect x="240.3" y="124.1" fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" width="47.6"
          height="36.6"/>
    <path fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" d="M222.1,131.8v36.4c0,4.2,8.2,7.7,18.2,7.7
		c10.1,0,18.2-3.4,18.2-7.7v-36.4H222.1z"/>

    <rect x="164.3" y="124.1" fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" width="47.6"
          height="36.6"/>
    <path fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" d="M146.1,131.8v36.4c0,4.2,8.2,7.7,18.2,7.7
		c10.1,0,18.2-3.4,18.2-7.7v-36.4H146.1z"/>

    <rect x="-139.9" y="131.8" fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" width="36.5"
          height="32.6"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="-121.7" cy="131.8" rx="18.2"
             ry="7.7"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="-121.7" cy="131.8" rx="8.1"
             ry="3.4"/>
    <path fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" d="M-121.7,139.5c-10.1,0-18.2-3.4-18.2-7.7v7.7
		v27.7c0,4.2,8.2,7.7,18.2,7.7h39.8v-35.3H-121.7z"/>
    <g>
        <path d="M-99,160.5l-1.9,5.8h-2.5l6.3-18.5h2.8l6.3,18.5h-2.5l-2-5.8H-99z M-93,158.7l-1.8-5.3c-0.4-1.2-0.7-2.3-1-3.4h-0.1
			c-0.3,1.1-0.5,2.2-0.9,3.3l-1.8,5.3H-93z"/>
    </g>

    <rect x="-72.9" y="131.8" fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" width="36.5"
          height="32.6"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="-54.7" cy="131.8" rx="18.2"
             ry="7.7"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="-54.7" cy="131.8" rx="8.1"
             ry="3.4"/>
    <path fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" d="M-54.7,139.5c-10.1,0-18.3-3.4-18.3-7.7v7.7
		v27.7c0,4.2,8.2,7.7,18.3,7.7h39.8v-35.3H-54.7z"/>
    <g>
        <path d="M-25.3,153.7l1.9-5.8h2.5l-6.3,18.5h-2.8l-6.3-18.5h2.5l2,5.8H-25.3z M-31.4,155.6l1.8,5.3c0.4,1.2,0.7,2.3,1,3.4h0.1
			c0.3-1.1,0.5-2.2,0.9-3.3l1.8-5.3H-31.4z"/>
    </g>

    <rect x="-5.9" y="131.8" fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" width="36.5"
          height="32.6"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="12.3" cy="131.8" rx="18.2"
             ry="7.7"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="12.3" cy="131.8" rx="8.1"
             ry="3.4"/>
    <path fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" d="M12.3,139.5c-10.1,0-18.2-3.4-18.2-7.7v7.7
		v27.7c0,4.2,8.2,7.7,18.2,7.7h39.8v-35.3H12.3z"/>
    <g>
        <path d="M41.7,160.5l5.8,1.9v2.5l-18.5-6.3v-2.8l18.5-6.3v2.5l-5.8,2V160.5z M39.9,154.4l-5.3,1.8c-1.2,0.4-2.3,0.7-3.4,1v0.1
			c1.1,0.3,2.2,0.5,3.3,0.9l5.3,1.8V154.4z"/>
    </g>

    <rect x="61.1" y="131.8" fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" width="36.5"
          height="32.6"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="79.3" cy="131.8" rx="18.2"
             ry="7.7"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="79.3" cy="131.8" rx="8.1"
             ry="3.4"/>
    <path fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" d="M79.3,139.5c-10.1,0-18.2-3.4-18.2-7.7v7.7
		v27.7c0,4.2,8.2,7.7,18.2,7.7h39.8v-35.3H79.3z"/>
    <g>
        <path d="M101.9,153.8l-5.8-1.9v-2.5l18.5,6.3v2.8l-18.5,6.3v-2.5l5.8-2V153.8z M103.7,159.9l5.3-1.8c1.2-0.4,2.3-0.7,3.4-1V157
			c-1.1-0.3-2.2-0.5-3.3-0.9l-5.3-1.8V159.9z"/>
    </g>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="164.3" cy="131.8" rx="18.2"
             ry="7.7"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="164.3" cy="131.8" rx="8.1"
             ry="3.4"/>
    <g>
        <path d="M193.7,145.8l-1.9,5.8h-2.5l6.3-18.5h2.8l6.3,18.5h-2.5l-2-5.8H193.7z M199.8,144l-1.8-5.3c-0.4-1.2-0.7-2.3-1-3.4h-0.1
			c-0.3,1.1-0.5,2.2-0.9,3.3l-1.8,5.3H199.8z"/>
    </g>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="240.3" cy="131.8" rx="18.2"
             ry="7.7"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="240.3" cy="131.8" rx="8.1"
             ry="3.4"/>
    <g>
        <path d="M276.4,139l1.9-5.8h2.5l-6.3,18.5h-2.8l-6.3-18.5h2.5l2,5.8H276.4z M270.3,140.9l1.8,5.3c0.4,1.2,0.7,2.3,1,3.4h0.1
			c0.3-1.1,0.5-2.2,0.9-3.3l1.8-5.3H270.3z"/>
    </g>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="316.3" cy="131.8" rx="18.2"
             ry="7.7"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="316.3" cy="131.8" rx="8.1"
             ry="3.4"/>
    <g>
        <path d="M352.5,145.8l5.8,1.9v2.5l-18.5-6.3V141l18.5-6.3v2.5l-5.8,2V145.8z M350.6,139.7l-5.3,1.8c-1.2,0.4-2.3,0.7-3.4,1v0.1
			c1.1,0.3,2.2,0.5,3.3,0.9l5.3,1.8V139.7z"/>
    </g>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="392.3" cy="131.8" rx="18.2"
             ry="7.7"/>
    <ellipse fill="#FFFFFF" stroke="#7F7D7C" stroke-width="0.75" stroke-miterlimit="10" cx="392.3" cy="131.8" rx="8.1"
             ry="3.4"/>
    <g>
        <path d="M421.6,139.1l-5.8-1.9v-2.5l18.5,6.3v2.8l-18.5,6.3v-2.5l5.8-2V139.1z M423.5,145.2l5.3-1.8c1.2-0.4,2.3-0.7,3.4-1v-0.1
			c-1.1-0.3-2.2-0.5-3.3-0.9l-5.3-1.8V145.2z"/>
    </g>
</g>
</svg>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Посчитать</button>
                </div>
            </form>
        </div>
        <div id="debug"
             class="col-12 col-lg-6">
            <h1 class="text-center">Debug will be here</h1>
            <div id="debugBody" style="padding: 5px">
            </div>
        </div>
    </div>
    <script>
        function getKnives() {
            let dummy = $('#dummy').prop('checked');
            dummy = dummy ? '1' : '0';
            $.ajax({
                url: '/api/calc/test/flexa/knives?form=' + $('#flexForm').val() + '&dummy=' + dummy,
                success: (data) => {
                    let markup = ``;
                    data.forEach((item, index) => {
                        if (index === 0) {
                            $('#knife_price').attr('placeholder', item.price);
                            $('#knife_price_percent').attr('placeholder', item.price_percent);
                        }
                        let radius = $('#flexForm').val() == 1 ? ` (R=${item['radius']} мм)` : '';
                        markup += `<option data-price="${item.price}" data-price-percent="${item.price_percent}" value="${item['id']}">${item['height'] + 'x' + item['width']} мм ${radius} ${item['description'] ? '(' + item['description'] + ')' : ''}</option>`
                    })
                    $('#knife').html(markup);
                }
            });
        }

        function setMaterials(type) {
            let materialOptions = $('#material option');
            let ribbonOptions = $('#ribbon option');
            switch (type) {
                case 'none':
                    materialOptions.each(function (index) {
                        $(this).attr('disabled', false);
                    })
                    $('#ribbon').attr('disabled', true);
                    break;
                case 'thermal':
                    materialOptions.each(function (index) {
                        if ($(this).data('type') != 3) {
                            $(this).attr('disabled', true)
                        } else {
                            $(this).attr('disabled', false)
                        }
                    })
                    $('#ribbon').attr('disabled', false);
                    break;
                case 'ribbon':
                    materialOptions.each(function (index) {
                        if ($(this).data('type') == 3) {
                            $(this).attr('disabled', true)
                        } else {
                            $(this).attr('disabled', false)
                        }
                    })
                    break;
            }
            $('#material').val($('#material option:not([disabled]):first').attr('value'));
        }

        $(function () {
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })
            $(document).on('submit', '#form', function (e) {
                e.preventDefault();
                let frm = $('#form').serialize();
                $.ajax({
                    url: '/api/calc/test/flexa',
                    data: frm,
                    method: 'post',
                    success: function (data) {
                        $('#debugBody').html(data);
                    }
                });
            })
            $('#flexForm').on('change', function (e) {
                getKnives();
            });
            $('#knife').on('change', function (e) {
                let price = $(this).find(':selected').attr('data-price');
                let percent = $(this).find(':selected').attr('data-price-percent');
                $('#knife_price').attr('placeholder', price);
                $('#knife_price_percent').attr('placeholder', percent);
            });
            $('#color').on('change', function (e) {
                if ($(this).val() === '92') {
                    let paints = JSON.parse('{!! $paints!!}');
                    let options = `<option value="not_choose">Не выбрано</option>`;
                    for (const key in paints) {
                        options += `<option value="${paints[key]['id']}">${paints[key]['name']}</option>`;
                    }
                    let markup = ``;
                    for (let i = 1; i < 6; i++) {
                        markup += `<div class="col-12">
                   <label for="paint${i}" class="form-label">Цвет ${i}</label>
                   <select id="paint${i}" name="paints[]" class="form-select">
                       ${options}
                   </select>
               </div>`;
                    }
                    $('#quantity_colors').attr('placeholder', 0);
                    $('#custom-colors').html(markup);
                    $('#custom-colors select').on('change', function (e) {
                        let paintsQuantity = 0;
                        $('#custom-colors select').each(function (item) {
                            if ($(this).val() != 'not_choose') {
                                paintsQuantity++;
                            }
                        });
                        $('#quantity_colors').attr('placeholder', paintsQuantity);
                    });
                } else {
                    let paintsQuantity = $(this).find(':selected').attr('data-paints').split(',').length;
                    $('#quantity_colors').attr('placeholder', paintsQuantity);
                    $('#custom-colors').html('');
                }
            });
            $('#additional').on('change', function (e) {
                $('#additionalBlock').toggleClass('d-none');
                // $(this).prop("checked");
            })
            $('#dummy').on('change', function () {
                getKnives()
            })
            $('#thermal').on('change', function () {
                if ($(this).prop('checked')) {
                    setMaterials('thermal');
                } else {
                    setMaterials('none')
                }
            })
            $('#ribbon').on('change', function () {
                console.log($(this).val())
                if ($(this).val() != 37) {
                    setMaterials('ribbon')
                } else {
                    setMaterials('thermal')
                }
            })
        })

    </script>
@endsection
