@extends('calc.test_calcs_layout')

@section('title')
    Оффсет
@endsection

@section('content')
    {{--    <a class="btn btn-danger" href="@makeUrl($documentObject['parent'])">Назад</a>--}}
    <div class="row">
        <div class="col-5">
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
                <div class="col-12" id="materialWrap">
                    <label for="material" class="form-label">Материал</label>
                    <select id="material" name="material" class="form-select">
                        @foreach($materials as $material)
                            <option data-weight="{{$material['weight']}}" data-volume="{{$material['volume']}}"
                                    value="{{$material['id']}}">{!! $material['name'] !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12" id="product_countWrap">
                    <label for="product_count" class="form-label">Количество</label>
                    <select id="product_count" name="product_count" class="form-select">
                        @foreach($product_counts as $key => $product_count)
                            <option data-price-item="{{ceil(round($product_count['price']/$product_count['quantity'] * 100, 2))/100}}"
                                    data-price="{{$product_count['price']}}"
                                    value="{{$product_count['id']}}">{{$product_count['quantity']}} шт.
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="col-7 align-self-center">
            <h3>Себестоимость: <span id="price_cost">{{$price_cost}}</span> руб (цена за шт <span
                        id="price_item_cost">{{$price_item_cost}}</span> руб)</h3>
            <h3>Цена: <span id="price">{{$price}}</span> руб (цена за шт <span id="price_item">{{$price_item}}</span>
                руб)</h3>
            <h5>Вес: <span id="weight">{{$weight}}</span> kg</h5>
            <h5>Объем: <span id="volume">{{$volume}}</span> m3</h5>
        </div>
    </div>
    <script>
        // function setWeightVolume(){
        //     let productCount = parseFloat($('#product_count option:selected').data('quantity'));
        //     let materialSelected = $('#material option:selected');
        //     $('#volume').html(productCount*parseFloat(materialSelected.attr('data-volume')));
        //     $('#weight').html(productCount*parseFloat(materialSelected.data('weight')));
        // }
        $(function (e) {
            $('#type,#material,#size,#product_count').each(function () {
                $(this).on('change', function () {
                    $.get(`/api/calc/test/offset?name=${$(this).prop('name')}&value=${$(this).val()}`, (data) => {
                        if (data.selects) {
                            for (const field in data.selects) {
                                $(`#${field}`).html(data.selects[field]);
                            }
                        }
                        $('#price_cost').html(data['price_cost']);
                        $('#price_item_cost').html(data['price_item_cost']);
                        $('#price').html(data['price']);
                        $('#price_item').html(data['price_item']);
                        $('#weight').html(data['weight']);
                        $('#volume').html(data['volume']);
                    })
                })
            })
            // $('#product_count').on('change', function () {
            //     let price = ($(this).find('option:selected').attr('data-price'));
            //     let priceItem = ($(this).find('option:selected').attr('data-price-item'));
            //     $('#price_cost').html(price);
            //     $('#price_item_cost').html(priceItem);
            // })
        })
    </script>
@endsection
