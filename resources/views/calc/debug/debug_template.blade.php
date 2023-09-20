@if(!isset($error))
    <div class="container">
        <h4>Layout</h4>
        Item {{$calculable['layout_width']}} x {{$calculable['layout_height']}} (margin {{$calculable['departure']}})
        = {{$calculable['layout_width'] + $calculable['departure'] * 2}}
        x {{$calculable['layout_height'] + $calculable['departure'] * 2}} <br> Quantity {{$calculable['product_count']}}
        <br>
        @if(isset($calculable['wide_print_height']))
            Printing space {{$calculable['print_count']}} <br>
            Material space {{$calculable['material_count']}} <br>
            Counted {{$calculable['items_on_page']}} items on page <p class="fw-bold">
                @isset($calculable['linear_meters'])
                    Linear meters {{$calculable['linear_meters']}} <br>
                @endisset
                @elseif(isset($calculable['type']) && $calculable['type']==='banner')
                    Printing space {{$calculable['print_count']}} <br>
                @else
                    Printing space {{$calculable['print']['width']}} x {{$calculable['print']['height']}} <br>
                    Counted {{$calculable['items_on_page']}} items on page <p class="fw-bold">
                Counted {{$calculable['material_count']}}
                layouts</p>
        @endif
        <hr>

        {{--        Material debug--}}
        <h4 class="text-danger">Material { {{ $calculable['material']['id'] }} id }</h4>
        {{-- var_dump($calculable['material']) --}}
        {{-- $calculable['material']['code']}} {{$calculable['material']['code']--}} {
        {{$calculable['material']['cost_price']}} * {{$calculable['material_count']}} rub }
        {{$calculable['material_price_total']}} rub<br>
        <b class="fw-bold text-danger">total { {{$calculable['total_material_cost']}} }
            {{$calculable['material_price_total']}} rub</b>
        <hr>

        {{--        Print debug--}}
        @if(isset($calculable['print_price_total']) && !empty($calculable['print_price_total']))
            <h4 class="text-primary">Print</h4>
            @if(isset($calculable['print']['index_name']) && !empty($calculable['print']['index_name']))
                <b class="fw-bold"> {{$calculable['print']['index_name']}} </b><br>
            @endif
            @if(isset($calculable['interpol_print']))
                Interpolation - {{$calculable['interpol_print']}} % <br>
            @endif
            Print - { {{$calculable['print_cost']}} rub} {{$calculable['print_price_total']}} rub<br>
            <b class="fw-bold text-primary">total { {{$calculable['print_cost']}}
                rub } {{$calculable['print_price_total']}} rub</b>
            <hr>
        @endif
        @if(isset($calculable['jobs']))
            {{--        Add jobs debug--}}
            <h4 class="text-success">Post-press</h4>
            @foreach (array_keys($calculable['jobs']) as $key)
                @foreach ($calculable['jobs'][$key] as $job)
                    <span class="fw-bold text-white"
                          style="background-color: {{$job['color']}}; color: #fff">{{$job['code']}}</span> - { {{$job['job_cost']}}
                    rub }
                    {{$job['count']}} rub @if($job['coefficient']!=1)
                        (coefficient: {{$job['coefficient']}})
                    @endif @if(isset($job['total_weight']) && isset($job['total_volume']))
                        (Weight: {{$job['total_weight']}} Volume: {{$job['total_volume']}})
                    @endif<br>
                @endforeach
            @endforeach
        @endif
        @if(isset($calculable['add_job_cost']))
            <b class="fw-bold text-success">total { {{$calculable['add_job_cost']}}
                rub } {{$calculable['add_jobs_total']}}
                rub</b> @if(isset($calculable['add_jobs_weight']) && isset($calculable['add_jobs_volume']))
                (Weight: {{$calculable['add_jobs_weight']}} Volume: {{$calculable['add_jobs_volume']}})
            @endif
            <hr>
        @endif
        {{--        total count--}}
        <h4 class="text-secondary">Result</h4>
        SUM price = { {{$calculable['total_cost']}} rub } {{$calculable['total_price']}} rub <br>
        Item price = {{$calculable['item_price']}} = {{$calculable['count_item_price']}} rub <br>
        @if(isset($calculable['discount_prices']))
            @foreach($calculable['discount_prices'] as $discount)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="discount" id="discount{{$loop->iteration}}"
                           @if($loop->first) checked @endif>
                    <label class="form-check-label" for="discount{{$loop->iteration}}">
                        <span class="text-success"
                              style="font-weight: bold">{{$discount['percent']}}% </span> {{$discount['product_count']}}
                        шт {{$discount['count_item_price']}} руб/шт
                    </label>
                </div>SUM price =
            @endforeach
        @endif
        <b class="fw-bold text-secondary">Price = {{$calculable['total_price'] }} rub</b>
        @if(isset($calculable['weight']) && !empty($calculable['weight']))
            <br><b class="fw-bold text-secondary">Weight = {{$calculable['weight']}} kg</b>
        @endif
        @if(isset($calculable['volume']) && !empty($calculable['volume']))
            <br><b class="fw-bold text-secondary">Volume = {{$calculable['volume']}} m3</b>
        @endif
        @if (isset($calculable['type']))
            @if($calculable['type']==='book' || $calculable['type']==='euro' || $calculable['type']==='acord' || $calculable['type']==='acord2' || $calculable['type']==='snail')
                @includeIf('booklets.'.$calculable['type'].'.'.$calculable['layout_width'].'x'.$calculable['layout_height'])
            @endif
    </div>
@endif

@else
    <div class="container">
        <h4>Layout</h4>
        Item {{$width}} x {{$height}} (margin {{$departure ?? 2}})
        = {{$width + $departure * 2}}
        x {{$height + $departure * 2}} <br> Quantity {{$product_count}}<br>
        Printing space {{$max_width ?? 'бесконечность'}} x {{$max_height ?? 'бесконечность'}} <br>
        Counted 0 items on page <p class="fw-bold">
            <span style="color: #ef0000; font-weight: 600">Error: {!! $error !!}</span>
        </p>
    </div>
@endif
