<div class="need-labels" data-block="need-labels">
    <a href="@makeUrl($data['link'])" class="need-labels__link">
        <div class="need-labels__text">
            <span class="need-labels__title">{{$data['title']}}</span>
            <span class="need-labels__title link_arrows">{{$data['link_text']}}</span>
        </div>
        <div class="need-labels__img">
            <img src="{{$data['image']}}" alt="icon-labels">
        </div>
    </a>
    <button class="need-labels__close " type="button" aria-label="Close" data-close="need-labels">
        <span class="plus"></span>
    </button>
</div>