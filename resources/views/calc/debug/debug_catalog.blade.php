<style>
    .full__close {
        width: 70px;
        margin: 0 auto;
        border: 1px solid #c3c3c3;
        height: 90px;
    }

    .spring_catalog .full__close, .presentations .full__close {
        background: url('/theme/images/skoba.png') repeat-y -5px top #fff;
    }

    .bracket_catalog .full__close, .notebooks .full__close, .adhesive_catalog .full__close {
        background: #fff;
    }

    .notepads .full__close {
        background: url('/theme/images/top-blocknot.png') repeat-x top #fff;
    }

    .full__open {
        width: 140px;
        margin: 0 auto;
        border: 1px solid #c3c3c3;
        height: 90px;
    }

    .bracket_catalog .full__open, .notebooks .full__open {
        background: url('/theme/images/skoba2.png') repeat-y center center #fff;
    }

    .spring_catalog .full__open, .presentations .full__open, .notepads .full__open {
        background: url('/theme/images/skoba.png') repeat-y center top #fff;
    }

    .adhesive_catalog .full__open {
        background: url('/theme/images/cley.png') repeat-y center top #fff;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-4" style="display: inline-block">
            <h3 class="text-info">Обложка</h3>
            <h5>Layout</h5>
            Item {{$calculable['cover']['layout_width']}} x {{$calculable['cover']['layout_height']}}
            (margin {{$calculable['cover']['departure']}})
            = {{$calculable['cover']['layout_width'] + $calculable['cover']['departure'] * 2}}
            x {{$calculable['cover']['layout_height'] + $calculable['cover']['departure'] * 2}} <br>
            Quantity {{$calculable['cover']['product_count']}}<br>
            @if(isset($calculable['cover']['print']['width']) && !empty($calculable['cover']['print']['width']) &&isset($calculable['cover']['print']['height']) && !empty($calculable['cover']['print']['height']))
                Printing space {{$calculable['cover']['print']['width']}} x {{$calculable['cover']['print']['height']}}
                <br>
            @endif
            Counted {{$calculable['cover']['items_on_page']}} items on page <p class="fw-bold">
                Counted {{$calculable['cover']['material_count']}}
                layouts</p>
            {{--        Material debug--}}
            @if(isset($calculable['cover']['paper']))
                <h5 class="text-danger">Material { {{ $calculable['cover']['paper']['id'] }} id }</h5>
                <h6 class="mt-2">{!! $calculable['cover']['paper']['name']!!} ({{$calculable['cover']['paper']['id']}}
                    )</h6>
                {{$calculable['cover']['paper']['code']}} {{$calculable['cover']['paper']['code']}} {
                {{$calculable['cover']['paper']['cost_price']}} * {{$calculable['cover']['material_count']}} rub }
                {{$calculable['cover']['paper_price_total']}} rub<br>
            @endif
            @if(isset($calculable['cover']['plastic']))
                <h6 class="mt-2">{!!$calculable['cover']['plastic']['name']!!}
                    ({{$calculable['cover']['plastic']['id']}})</h6>
                {{$calculable['cover']['plastic']['code']}} {{$calculable['cover']['plastic']['code']}} {
                {{$calculable['cover']['plastic']['cost_price']}} * {{$calculable['cover']['material_count']}} rub }
                {{$calculable['cover']['plastic_price_total']}} rub<br>
            @else
                <h6 class="mt-2">{!!$calculable['cover']['material']['name']!!}
                    ({{$calculable['cover']['material']['id']}})</h6>
                {{$calculable['cover']['material']['code']}} {{$calculable['cover']['material']['code']}} {
                {{$calculable['cover']['material']['cost_price']}} * {{$calculable['cover']['material_count']}} rub }
                {{$calculable['cover']['material_price_total']}} rub<br>
            @endif
            <p class="fw-bold text-danger">total { {{$calculable['cover']['total_material_cost']}} }
                {{$calculable['cover']['material_price_total']}} rub</p>


            {{--        Print debug--}}
            @if(isset($calculable['cover']['print_price_total']) && !empty($calculable['cover']['print_price_total']))
                <h5 class="text-primary">Print</h5>
                <b class="fw-bold"> {{$calculable['cover']['print']['index_name']}} </b><br>
                @if(isset($calculable['cover']['interpol_print']))
                    Interpolation - {{$calculable['cover']['interpol_print']}} % <br>
                @endif
                Print - { {{$calculable['cover']['print_cost']}} rub} {{$calculable['cover']['print_price_total']}} rub
                <br>


                <p class="fw-bold text-primary">total { {{$calculable['cover']['print_cost']}}
                    rub } {{$calculable['cover']['print_price_total']}} rub</p>

            @endif
            {{--        Add jobs debug--}}
            <h5 class="text-success">Post-press</h5>
            @if(isset($calculable['cover']['jobs']))
                @foreach (array_keys($calculable['cover']['jobs']) as $key)
                    @foreach ($calculable['cover']['jobs'][$key] as $job)
                        <span class="fw-bold text-white"
                              style="background-color: {{$job['color']}}; color: #fff">{{$job['code']}}</span> -
                        { {{$job['job_cost']}} rub }
                        {{$job['count']}} rub @if($job['coefficient']!=1) (coefficient: {{$job['coefficient']}})@endif<br>
                    @endforeach
                @endforeach
            @endif

            @if(isset($calculable['cover']['add_job_cost']))
                <p class="fw-bold text-success">total { {{$calculable['cover']['add_job_cost']}}
                    rub } {{$calculable['cover']['add_jobs_total']}} rub</p>
            @endif


            {{--        total count--}}
            <h5 class="text-secondary">Result</h5>
            SUM price = { {{$calculable['cover']['total_cost']}} rub } {{$calculable['cover']['total_price']}} rub <br>
            {{--            Item price = {{$calculable['cover']['item_price']}} = {{$calculable['cover']['count_item_price']}} rub <br>--}}
            {{--            <p class="fw-bold text-secondary">Price = {{$calculable['cover']['total_price'] }} rub</p>--}}
            <br><b class="fw-bold text-secondary">Weight = {{$calculable['cover']['weight']}} kg</b>
            <br><b class="fw-bold text-secondary">Volume = {{$calculable['cover']['volume']}} m3</b>
        </div>
        <div class="col-4" style="display: inline-block;">
            <h3 class="text-info">Блок</h3>
            <h5>Layout</h5>
            Item {{$calculable['block']['layout_width']}} x {{$calculable['block']['layout_height']}}
            (margin {{$calculable['block']['departure']}})
            = {{$calculable['block']['layout_width'] + $calculable['block']['departure'] * 2}}
            x {{$calculable['block']['layout_height'] + $calculable['block']['departure'] * 2}} <br>
            Quantity {{$calculable['block']['product_count']}}<br>
            @if(isset($calculable['block']['print']['width']) && !empty($calculable['block']['print']['width']) &&isset($calculable['block']['print']['height']) && !empty($calculable['block']['print']['height']))
                Printing space {{$calculable['block']['print']['width']}} x {{$calculable['block']['print']['height']}}
                <br>
            @endif
            Counted {{$calculable['block']['items_on_page']}} pages <p class="fw-bold">
                Counted {{$calculable['block']['material_count']}}
                layouts</p>


            {{--        Material debug--}}
            <h5 class="text-danger">Material { {{ $calculable['block']['material']['id'] }} id }</h5>
            <h6 class="mt-2">{!!$calculable['block']['material']['name']!!} ({{$calculable['block']['material']['id']}}
                )</h6>
            {{$calculable['block']['material']['code']}} {{$calculable['block']['material']['code']}} {
            {{$calculable['block']['material']['cost_price']}} * {{$calculable['block']['material_count']}} rub }
            {{$calculable['block']['material_price_total']}} rub<br>
            <p class="fw-bold text-danger">total { {{$calculable['block']['total_material_cost']}} }
                {{$calculable['block']['material_price_total']}} rub</p>


            {{--        Print debug--}}
            @if(isset($calculable['block']['print_price_total']) && !empty($calculable['block']['print_price_total']))
                <h5 class="text-primary">Print</h5>
                <b class="fw-bold"> {{$calculable['block']['print']['index_name']}} </b><br>
                @if(isset($calculable['block']['interpol_print']))
                    Interpolation - {{$calculable['block']['interpol_print']}} % <br>
                @endif
                Print - { {{$calculable['block']['print_cost']}} rub} {{$calculable['block']['print_price_total']}} rub
                <br>


                <p class="fw-bold text-primary">total { {{$calculable['block']['print_cost']}}
                    rub } {{$calculable['block']['print_price_total']}} rub</p>

            @endif
            {{--        Add jobs debug--}}
            <h5 class="text-success">Post-press</h5>
            @if(isset($calculable['block']['jobs']))
                @foreach (array_keys($calculable['block']['jobs']) as $key)
                    @foreach ($calculable['block']['jobs'][$key] as $job)
                        <span class="fw-bold text-white"
                              style="background-color: {{$job['color']}}; color: #fff">{{$job['code']}}</span> -
                        { {{$job['job_cost']}} rub }
                        {{$job['count']}} rub @if($job['coefficient']!=1) (coefficient: {{$job['coefficient']}})@endif<br>
                    @endforeach
                @endforeach
            @endif

            @if(isset($calculable['block']['add_job_cost']))
                <p class="fw-bold text-success">total { {{$calculable['block']['add_job_cost']}}
                    rub } {{$calculable['block']['add_jobs_total']}} rub</p>
            @endif

            {{--        total count--}}
            <h5 class="text-secondary">Result</h5>
            SUM price = { {{$calculable['block']['total_cost']}} rub } {{$calculable['block']['total_price']}} rub <br>
            {{--            Item price = {{$calculable['block']['item_price']}} = {{$calculable['block']['count_item_price']}} rub <br>--}}
            {{--            <p class="fw-bold text-secondary">Price = {{$calculable['block']['total_price'] }} rub</p>--}}
            <br><b class="fw-bold text-secondary">Weight = {{$calculable['block']['weight']}} kg</b>
            <br><b class="fw-bold text-secondary">Volume = {{$calculable['block']['volume']}} m3</b>
        </div>
        @if($calculable['substrate'])
            <div class="col-4" style="display: inline-block">
                <h3 class="text-info">Подложка</h3>
                <h5>Layout</h5>
                Item {{$calculable['substrate']['layout_width']}} x {{$calculable['substrate']['layout_height']}}
                (margin {{$calculable['substrate']['departure']}})
                = {{$calculable['substrate']['layout_width'] + $calculable['substrate']['departure'] * 2}}
                x {{$calculable['substrate']['layout_height'] + $calculable['substrate']['departure'] * 2}} <br>
                Quantity {{$calculable['substrate']['product_count']}}<br>
                @if(isset($calculable['substrate']['print']['width']) && !empty($calculable['substrate']['print']['width']) &&isset($calculable['substrate']['print']['height']) && !empty($calculable['substrate']['print']['height']))
                    Printing space {{$calculable['substrate']['print']['width']}}
                    x {{$calculable['substrate']['print']['height']}} <br>
                @endif
                Counted {{$calculable['substrate']['items_on_page']}} items on page <p class="fw-bold">
                    Counted {{$calculable['substrate']['material_count']}}
                    layouts</p>


                {{--        Material debug--}}
                @if(isset($calculable['substrate']['paper']))
                    <h5 class="text-danger">Material { {{ $calculable['substrate']['paper']['id'] }} id }</h5>
                    <h6 class="mt-2">{!! $calculable['substrate']['paper']['name']!!}
                        ({{$calculable['substrate']['paper']['id']}})</h6>
                    {{$calculable['substrate']['paper']['code']}} {{$calculable['substrate']['paper']['code']}}
                    {
                    {{$calculable['substrate']['paper']['cost_price']}} * {{$calculable['substrate']['material_count']}}
                    rub }
                    {{$calculable['substrate']['paper_price_total']}} rub<br>
                @endif
                @if(isset($calculable['substrate']['plastic']))
                    <h6 class="mt-2">{!!$calculable['substrate']['plastic']['name']!!}
                        ({{$calculable['substrate']['plastic']['id']}})</h6>
                    {{$calculable['substrate']['plastic']['code']}} {{$calculable['substrate']['plastic']['code']}}
                    {
                    {{$calculable['substrate']['plastic']['cost_price']}}
                    * {{$calculable['substrate']['material_count']}} rub }
                    {{$calculable['substrate']['plastic_price_total']}} rub<br>
                @else
                    <h6 class="mt-2">{!!$calculable['substrate']['material']['name']!!}
                        ({{$calculable['substrate']['material']['id']}})</h6>
                    {{$calculable['substrate']['material']['code']}} {{$calculable['substrate']['material']['code']}}
                    {
                    {{$calculable['substrate']['material']['cost_price']}}
                    * {{$calculable['substrate']['material_count']}} rub }
                    {{$calculable['substrate']['material_price_total']}} rub<br>
                @endif
                <p class="fw-bold text-danger">total { {{$calculable['substrate']['total_material_cost']}} }
                    {{$calculable['substrate']['material_price_total']}} rub</p>


                {{--        Print debug--}}
                @if(isset($calculable['substrate']['print_price_total']) && !empty($calculable['substrate']['print_price_total']))
                    <h5 class="text-primary">Print</h5>
                    <b class="fw-bold"> {{$calculable['substrate']['print']['index_name']}} </b><br>
                    @if(isset($calculable['substrate']['interpol_print']))
                        Interpolation - {{$calculable['substrate']['interpol_print']}} % <br>
                    @endif
                    Print - { {{$calculable['substrate']['print_cost']}}
                    rub} {{$calculable['substrate']['print_price_total']}}
                    rub<br>


                    <p class="fw-bold text-primary">total { {{$calculable['substrate']['print_cost']}}
                        rub } {{$calculable['substrate']['print_price_total']}} rub</p>

                @endif
                {{--        Add jobs debug--}}
                @if(isset($calculable['substrate']['jobs']))
                    <h5 class="text-success">Post-press</h5>
                    @foreach (array_keys($calculable['substrate']['jobs']) as $key)
                        @foreach ($calculable['substrate']['jobs'][$key] as $job)
                            <span class="fw-bold text-white"
                                  style="background-color: {{$job['color']}}; color: #fff">{{$job['code']}}</span> -
                            { {{$job['job_cost']}}
                            rub }
                            {{$job['count']}} rub @if($job['coefficient']!=1) (coefficient: {{$job['coefficient']}})@endif
                            <br>
                        @endforeach
                    @endforeach
                @endif

                @if(isset($calculable['substrate']['add_job_cost']))
                    <p class="fw-bold text-success">total { {{$calculable['substrate']['add_job_cost']}}
                        rub } {{$calculable['substrate']['add_jobs_total']}} rub</p>
                @endif

                {{--        total count--}}
                <h5 class="text-secondary">Result</h5>
                SUM price = { {{$calculable['substrate']['total_cost']}} rub
                } {{$calculable['substrate']['total_price']}} rub
                <br>
                {{--                Item price = {{$calculable['substrate']['item_price']}} = {{$calculable['substrate']['count_item_price']}} rub--}}
                {{--                <br>--}}
                {{--                <p class="fw-bold text-secondary">Price = {{$calculable['substrate']['total_price'] }} rub</p>--}}
                <br><b class="fw-bold text-secondary">Weight = {{$calculable['substrate']['weight']}} kg</b>
                <br><b class="fw-bold text-secondary">Volume = {{$calculable['substrate']['volume']}} m3</b>
            </div>
        @endif
        <div class="col-12 {{$calculable['cover']['type']}}">
            <hr>
            <div class="row">
                <div class="col-4">
                    <h3 class="text-info">Итого</h3>
                    SUM price = { {{$calculable['total']['total_cost']}} rub } {{$calculable['total']['total_price']}}
                    rub
                    <br>
                    Item price = {{$calculable['total']['item_price']}} = {{$calculable['total']['count_item_price']}}
                    rub
                    <br>
                    <div style="margin-top: 10px">
                        <h5 class="text-info">Weight = {{ number_format($weight, 10) }} kg</h5>
                        <h5 class="text-info">Volume = {{ number_format($volume, 10) }} m3</h5>
                    </div>
                </div>
                <div class="col-4 text-center">
                    <div class="full__close"
                         style="width: {{intval($calculable['cover']['width']/3)}}px; height: {{intval($calculable['cover']['height']/3)}}px;"></div>
                    <br>
                    <span>Размер в готовом виде <br> 210x297 мм</span>
                </div>
                <div class="col-4 text-center">
                    @if($calculable['cover']['type']==='notepads')
                        <div class="full__open"
                             style="width: {{intval($calculable['cover']['layout_height']/3*2)}}px; height: {{intval($calculable['cover']['width']/3)}}px;">
                        </div>
                    @else
                        <div class="full__open"
                             style="width: {{intval($calculable['cover']['layout_width']/3)*($calculable['cover']['type']=='spring_catalog' || $calculable['cover']['type']=='presentations'?2:1)}}px; height: {{intval($calculable['cover']['layout_height']/3)}}px;">
                        </div>
                    @endif
                    <br>
                    <span>Размер в развернутом виде <br> 420x297 мм</span>
                </div>
            </div>
        </div>
    </div>
</div>
