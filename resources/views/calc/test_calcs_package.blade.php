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
                <div class="col-12" id="product_countWrap">
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
    </div>
    <script>

        $(function (e) {
            $(document).on('submit', '#form', function (e) {
                e.preventDefault();
                let frm = $('#form').serialize();
                let url = 'api/calc/test/package';
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
