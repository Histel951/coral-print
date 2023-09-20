<div class="container">
    <h4 class="text-primary">Count</h4>
    <div>Quantity - {{$calculable['quantity']}}</div>
    <div>Plate {{$calculable['plate']}}</div>
    <div>Counted {{$calculable['counted_items']}} items on page <i class="text-success">(по
            рапорту {{$calculable['knife']['count_rapport']}}, рядов {{$calculable['knife']['count_rows']}})</i></div>
    <p class="fw-bold">Counted {{$calculable['counted_plates'] }}</p>
    <hr>
    <h4 class="text-danger">Material</h4>
    <div>#Флеско/{{$calculable['material']['name']}}</div>
    <div>({{$calculable['material_cost_price']}}) {{$calculable['material_price']}} € |
        ({{$calculable['material_cost_price_rub']}}) {{$calculable['material_price_rub']}} rub
    </div>
    @if(isset($calculable['ribbon']))
    <div>#Флеско/{{$calculable['ribbon']['name']}}</div>
    <div>({{$calculable['ribbon_cost_price']}}) {{$calculable['ribbon_price']}} € |
        ({{$calculable['ribbon_cost_price_rub']}}) {{$calculable['ribbon_price_rub']}} rub
    </div>
    @endif
    <p class="text-danger fw-bold">Total ({{$calculable['material_cost_price_rub_total']}}
        ) {{$calculable['material_price_rub_total']}} rub</p>
    <hr>
    <h4 class="text-success">Print</h4>
    @if(isset($calculable['paints']) && is_array($calculable['paints']))
        @foreach($calculable['paints'] as $paint)
            <div>{{$paint['name'].' - '.$paint['color_price']}} €</div>
        @endforeach
    @endif
    <div>({{$calculable['print_cost_price']}}) {{$calculable['print_price']}} € |
        ({{$calculable['print_cost_price_rub']}}
        ) {{$calculable['print_price_rub']}} rub
    </div>
    <p class="text-success fw-bold">Total ({{$calculable['print_cost_price_rub']}}) {{$calculable['print_price_rub']}}
        rub</p>
    <hr>
    <h4 class="text-warning">Pre-Post-press</h4>
    <div>#Флексоформы ({{$calculable['add_printed_forms']}}
        ) {{$calculable['add_printed_forms_extra']}} € | ({{$calculable['add_printed_forms_rub']}}
        ) {{$calculable['add_printed_forms_rub_extra']}} rub
    </div>
    <div>#Флексприлпеч ({{$calculable['add_print_cost_price']}}
        ) {{$calculable['add_print_price']}} € | ({{$calculable['add_print_cost_price_rub']}}
        ) {{$calculable['add_print_price_rub']}} rub @if(isset($calculable['add_print_price_min']))<span
                class="fw-bold text-danger">- min price</span>@endif</div>
    @if(isset($calculable['sleeve_quantity']))
    <div>#Флексвтулки ({{$calculable['sleeve_cost_price']}}
        ) {{$calculable['sleeve_price_total']}} € | ({{$calculable['sleeve_cost_price_rub']}}
        ) {{$calculable['sleeve_price_total_rub']}} rub
    </div>
    @endif
    <div>#Флекснож ({{$calculable['add_knife_cost_price']}}
        ) {{$calculable['add_knife_price']}} rub
    </div>
    @if(isset($calculable['thermo_print']))
        <div>#Термоприладка {{$calculable['thermo_print']}} rub
        </div>
    @endif
    <p class="text-warning fw-bold">Total ({{$calculable['add_total_cost_price']}}) {{$calculable['add_total_price']}}
        rub</p>
    <hr>
    <h4 class="text-secondary">Result</h4>
    <div>Себес. расходников - {{$calculable['total_cost_price']}} rub</div>
    <div>Себес. первого тиража - {{$calculable['total_cost_price_first_circulation']}} rub</div>
    <div>Себес. повторного тиража - {{$calculable['total_cost_price_repeat_circulation']}} rub</div>
    <hr>
    <div>
        <div id="clipboard">
            Этикетка ({{$calculable['knife_form']}}) {{$calculable['knife']['height'].'х'.$calculable['knife']['width']}} мм,
            {{$calculable['material']['name']}} ({{$calculable['material']['article']}}), {{isset($calculable['color']) ?
            $calculable['color']['name'] : 'нет цвета'}} {{$calculable['quantity']}} шт -
            <b class="fw-bold">{{$calculable['total_price_first_circulation']}} р. ({{$calculable['total_price_first_circulation_item']}} р. шт.)
            </b>
            <br>Повторный тираж -
            <b class="fw-bold">{{$calculable['total_price_repeat_circulation']}} р. ({{$calculable['total_price_repeat_circulation_item']}} р. шт.)
            </b>
                @if(isset($calculable['custom_paints']))
{{--        проверка есть ли кастомные цвета        --}}
            <br>
                @if(count($calculable['custom_paints']))<span class="text-primary"> Цветность</span>
                    @foreach( $calculable['custom_paints_unic'] as $name=>$quantity)
                        <span class="text-primary">{{$loop->first?'(':''}}{{$name}}{{$quantity>1?'-'.$quantity.'шт':''}}{{!$loop->last?',':')'}}
                        </span>
                    @endforeach
                @elseif(isset($calculable['paints']))
                    @foreach( $calculable['paints'] as $paint)
                        <span class="text-primary">{{$loop->first?'(':''}}{{$paint->name}}{{!$loop->last?',':')'}}
                        </span>
                    @endforeach
                @else
{{--          если их нет          --}}
                    <b class="text-danger">Без печати</b>
                @endif
            @endif
            <br>Номер ножа: {{!empty($calculable['knife']['knife_number_summary'])? $calculable['knife']['knife_number_summary'].'/':''}}
            {{$calculable['knife']['marking']}}. Межэетикеточное расстояние {{$calculable['knife']['line_space']}} мм.
            @if(!empty($calculable['knife']['row_space']))
                Междурядное А1: {{$calculable['knife']['row_space']}} мм.
            @endif
            Скругление {{$calculable['knife']['radius']}} мм. Ширина печати {{$calculable['knife']['print_height']}} мм
            (по рапорту {{$calculable['knife']['count_rapport']}}, рядов {{$calculable['knife']['count_rows']}}). Длина
            печатного материала с приладкой {{$calculable['material_length_adds']}} м. Длина печати
            {{ceil($calculable['running_meters'])}} м.
            @if(!empty($calculable['material']['min_meters'])&&intval($calculable['material']['min_meters'])>intval($calculable['square_meters_adds']))
                <span class="text-danger">Неоплаченный остаток пленки {{intval($calculable['material']['min_meters'])-intval($calculable['square_meters_adds'])}}
                    м. кв. из {{$calculable['material']['min_meters']}} м. кв.  (по стоимости {{$calculable['material']['price']}} евро за метр кв.)</span>
            @endif
                Длина тиража {{ceil($calculable['length_circulation'])}} м. Примерный вес тиража -
            {{$calculable['material_weight']}} кг. Примерный объем тиража - {{$calculable['material_volume']}} м3.
            <br>@if($calculable['form']==4)<br>@if($calculable['form']!='4')<i class="text-danger">
                * Сумма не включает стоимость ножа, Нож рассчитывается отдельно, на основании макета.</i>
            @endif
            @endif
        </div>
        <button class="btn btn-primary float-end" id="copy">Copy</button>

    </div>
    @if($calculable['form']!='4')
        <div id="svg" onclick="generate();" style="cursor: pointer; width: 335px;">
            {{--    @include('print_previews.'.$calculable['print_preview'], ['position'=>$calculable['print_position']])--}}
            {{--            {!! $calculable['print_preview_file']!!}--}} {{-- todo: $print_preview_file не определена, потому что закоментировал setPreviewImage, сделать свою картинку чтобы юзать --}}
            {{--<img src='{{$calculable['print_preview_file']}}?v={{time()}}' alt="print_preview_file" style="width: 100%">--}}
            {{--            <div style="background: url('{{$calculable['print_preview_file']}}') no-repeat content-box; width: 200px; height: 100px" alt="">--}}
        </div>
    @else
        <a href='/{{ $calculable['knife']['image'] }}' download style="position:relative; display: block; width:400px; height: 220px">
            <img style="position:absolute; width:100%;" src='/assets/images/new_images/flex/previews/complex.svg?v={{time()}}' alt="complex">
            <img style="position: absolute; width:100%; height:94%; top:5%" src='/{{ $calculable['knife']['image'] }}' alt="knife.image" width="200"></a>
    @endif
</div>
<script>
    (function (exports) {
        function screenshotPage() {
            var wrapper = document.getElementById('svg');
            html2canvas(wrapper).then(canvas => {
                // document.body.appendChild(canvas)
                canvas.toBlob(function (blob) {
                    saveAs(blob, 'flex_preview.png');
                });
            });
        }

        function generate() {
            screenshotPage();
        }

        exports.screenshotPage = screenshotPage;
        exports.generate = generate;
    })(window);

    function CopyToClipboard(element) {

        var doc = document
            , text = doc.getElementById(element)
            , range, selection;
        text.style.fontFamily = 'initial';
        let styles = JSON.parse(JSON.stringify(text.style));
        if (doc.body.createTextRange) {
            range = doc.body.createTextRange();
            range.moveToElementText(text);
            range.select();
        } else if (window.getSelection) {
            selection = window.getSelection();
            range = doc.createRange();
            range.selectNodeContents(text);
            selection.removeAllRanges();
            selection.addRange(range);
        }
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
        document.getElementById("copy").innerHTML = "Copied";
        text.style = styles;
    }

    function get_content() {
        var html = document.getElementById("clipboard").innerHTML;
        html = html.replaceAll('<br>', '\n');
        html = html.replace(/<[^>]*>/g, "");
        return html;
        // return html.replace(/\s{2,}|\t/g, " ");
    }

    function fallbackCopyTextToClipboard(text) {
        let textArea = document.createElement("textarea");
        textArea.value = text;

        // Avoid scrolling to bottom
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            let successful = document.execCommand('copy');
            let msg = successful ? 'successful' : 'unsuccessful';
            console.log('Fallback: Copying text command was ' + msg);
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
        }

        document.body.removeChild(textArea);
    }

    function copyTextToClipboard(text) {
        if (!navigator.clipboard) {
            fallbackCopyTextToClipboard(text);
            return;
        }
        navigator.clipboard.writeText(text).then(function () {
            console.log('Async: Copying to clipboard was successful!');
        }, function (err) {
            console.error('Async: Could not copy text: ', err);
        });
    }

    $(function () {
        $('#copy').on('click', function (e) {
            // CopyToClipboard('clipboard');
            let text = get_content();
            copyTextToClipboard(text);
        });
        // $('#svg').on('click', function (e){
        {{--$.post('/convertsvgtopng',{svg:$(this).html(), print_preview:'{{$calculable['print_preview']}}', position:'{{$calculable['print_position']}}' },function(returnedData){--}}
        {{--    const a = document.createElement('a');--}}
        {{--    a.style.display = 'none';--}}
        {{--    a.href = returnedData;--}}
        {{--    a.download = 'print_preview.png';--}}
        {{--    document.body.appendChild(a);--}}
        {{--    a.click();--}}
        {{--})--}}
        // })
    });
</script>
