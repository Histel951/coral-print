@extends('calc.test_calcs_layout')

@section('title')
    {{ $title }}
@endsection

@section('content')
        <a class="btn btn-danger" href="{{ url()->previous() }}">Назад</a>
    <div class="row">
        <div class="col-4">
            <h1 class="text-center">{{ $title }}</h1>
            <form class="row g-3" id="form">
                <div class="col-12">
                    <label for="type" class="form-label">Тип</label>
                    <select id="type" name="type" class="form-select">
                        @foreach($types as $type)
                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="size" class="form-label">Размер</label>
                    <select id="size" name="size" class="form-select">
                        @foreach($sizes as $size)
                            <option value="{{$size['id']}}">{{$size['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="size_typeWrap">
                    <label for="size_type" class="form-label">Рекламные поля</label>
                    <select id="size_type" name="size_type" class="form-select">
                        @foreach($size_types as $type)
                            <option data-weight="{{$type['weight']}}" data-volume="{{$type['volume']}}"
                                    data-description="{{$type['description']}}" data-image="{{$type['image']}}"
                                    value="{{$type['id']}}">{{$type['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="lamWrap">
                    <label for="lam" class="form-label">Ламинация</label>
                    <select id="lam" name="lam" class="form-select">
                        @foreach($lams as $lam)
                            <option value="{{$lam['id']}}">{{$lam['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="designWrap">
                    <label for="design" class="form-label">Дизайн</label>
                    <select id="design" name="design" class="form-select">
                        @foreach($designs as $key=>$designs_category)
                            <optgroup label="{{$key}}">
                                @foreach($designs_category as $design)
                                    <option data-image="{{$design['image']}}"
                                            data-image-small="{{$design['image_small']}}"
                                            value="{{$design['id']}}">{!! $design['name']!!}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="product_countWrap">
                    <label for="product_count" class="form-label">Количество</label>
                    <select id="product_count" name="product_count" class="form-select">
                        @foreach($product_counts as $key => $product_count)
                            <option data-price-item="{{ceil(round($product_count['price']/$product_count['quantity'] * 100, 2))/100}}"
                                    data-price="{{$product_count['price']}}"
                                    data-quantity="{{$product_count['quantity']}}"
                                    value="{{$product_count['quantity']}}">{{$product_count['quantity']}} шт.
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="col-3 align-self-center">
            <h6>Картинка дизайна основная</h6>
            <img id="design_image" src="/{{$design_image}}"
                 style="width: 100%">
            <h6>Картинка дизайна маленькая</h6>
            <img id="design_image_small" src="/{{$design_image_small}}"
                 style="width: 100%">
        </div>
        <div class="col-3 align-self-center">
            <img id="preview" src="{{$size_types[0]['image']}}"
                 style="width: 100%">
            <h3 class="text-center mt-3"><span id="price_show">{{$product_counts[0]['price']}}</span> руб <br> (цена за
                шт <span
                        id="price_item_show">{{ceil(round($product_counts[0]['price']/$product_counts[0]['quantity'] * 100, 2))/100}}</span>
                руб)</h3>
        </div>
        <div class="col-2 align-self-center">
            <div id="description">
                {!! $size_types[0]['description'] !!}
            </div>
            <div style="font-weight: bold">Вес: <span id="weight">{{$weight}}</span> kg</div>
            <div style="font-weight: bold">Объем: <span id="volume">{{$volume}}</span> m3</div>
        </div>
    </div>
    <script>
        function setWeightVolume() {
            let productCount = parseFloat($('#product_count option:selected').data('quantity'));
            let sizeTypeSelected = $('#size_type option:selected');
            $('#volume').html(productCount * parseFloat(sizeTypeSelected.attr('data-volume')));
            $('#weight').html(productCount * parseFloat(sizeTypeSelected.data('weight')));
        }

        $(function (e) {
            $('#type,#size,#size_type,#lam').each(function () {
                $(this).on('change', function () {
                    if ($(this).prop('id') === 'type') {
                        if ($('#type').val() == '7' || $('#type').val() == '8') {
                            $('#design_image').show();
                            $('#design_image_small').show();
                            $('#designWrap').show();
                        } else {
                            $('#design_image').hide();
                            $('#design_image_small').hide();
                            $('#designWrap').hide();
                        }
                        let label = $('#type').val() === '3' || $('#type').val() === '6' ? 'Блок' : 'Рекламные поля';
                        $('#size_typeWrap label').html(label);
                    }
                    $.get(`/api/calc/test/calendars?name=${$(this).prop('name')}&value=${$(this).val()}`, (data) => {
                        for (const field in data.selects) {
                            $(`#${field}`).html(data.selects[field]);
                        }
                        if ($('#size_type option:selected').html() === 'none') {
                            $('#size_typeWrap').hide();
                        } else {
                            $('#size_typeWrap').show();
                        }
                        $('#price_show').html(data['price']);
                        $('#price_item_show').html(data['price_item']);
                        if ($(this).prop('id') !== 'lam') {
                            $('#preview').prop('src', data.preview)
                            $('#description').html(data.description)
                        }
                        if ($(this).prop('id') === 'type' && $(this).prop('id') === 'size') {
                            $('#design_image').prop('src', data.design_image);
                            $('#design_image_small').prop('src', data.design_image_small);
                        }
                        setWeightVolume();
                    })
                })
            })
            $('#design').on('change', function () {
                let selectedOption = $(this).find('option:selected');
                let image = selectedOption.attr('data-image');
                $('#design_image').prop('src', image);
                let image_small = selectedOption.attr('data-image-small');
                $('#design_image_small').prop('src', image_small);
            })
            $('#product_count').on('change', function () {
                let price = ($(this).find('option:selected').attr('data-price'));
                let priceItem = ($(this).find('option:selected').attr('data-price-item'));
                $('#price_show').html(price);
                $('#price_item_show').html(priceItem);
                setWeightVolume();
            })
        })
    </script>
@endsection
