<div class="container">
    @if($content->is_show_sections_helpers)
        <div class="need-labels" data-block="need-labels">
            <a href="#" class="need-labels__link">
                <div class="need-labels__text">
                    <span class="need-labels__title">Нужны этикетки?</span>
                    <span class="need-labels__title link_arrows">Это здесь</span>
                </div>
                <div class="need-labels__img">
                    <img src="{{asset('images/icon/icon-labels.svg')}}" alt="icon-labels">
                </div>
            </a>
            <button class="need-labels__close " type="button" aria-label="Close" data-close="need-labels">
                <span class="plus"></span>
            </button>
        </div>
    @endif
    <h1 class="page-title page-title_inner">{{$content->title}}</h1>
</div>
<div id="calc" data-calculator="{{ $types }}" data-only-default-calculator-id="{{ $content->only_default_calculator_id }}"></div>
