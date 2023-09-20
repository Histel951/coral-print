<div class="container">
    <div class="need-labels" data-block="need-labels">
        <a href="#" class="need-labels__link">
            <div class="need-labels__text">
                <span class="need-labels__title link_arrows">{{$content->title}}</span>
            </div>
            <div class="need-labels__img">
                <img src="{{asset('images/icon/icon-labels.svg')}}" alt="icon-labels">
            </div>
        </a>
        <button class="need-labels__close " type="button" aria-label="Close" data-close="need-labels">
            <span class="plus"></span>
        </button>
    </div>
    <h1 class="page-title-product">{{$content->long_title}}</h1>
    <div class="text">
        <p>{{$content->description}}</p>
    </div>
</div>
<!-- Calculator -->
<div class="calculator calculator_internal">
    <div class="container">
        <div class="calculator__content"></div>
    </div>

</div>
