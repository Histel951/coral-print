@if($content->calculators->first()?->calculatorType()->first()->galleries?->count())
    <div class="container">
        <h2 class="block-title block-title_dark block-title_center gallery-header" id="gallery-header">
            Примеры работ
        </h2>

        @if($content->calculators->first()->calculatorType()->first()->galleryCategories?->count() > 1)
            <div class="gallery-tabs" data-calculator-type-id="{{ $calculatorTypeId }}">
                <ul class="gallery-tabs__list">
                    @foreach($content->calculators->first()->calculatorType()->first()?->galleryCategories as $category)
                        @if($loop->first)
                            <li class="gallery-tabs__item featured-gallery
                            @if(!$default_calculator_id)
                                active
                            @endif" data-tab="0">
                                <i class="icon-cp-refresh"></i>
                                Подборка
                            </li>
                        @endif
                        <li class="gallery-tabs__item
                        @if(isset($calcs[$category->id]) && in_array($default_calculator_id, $calcs[$category->id]))
                            active
                        @endif" data-tab="{{$category->id}}" data-calcs="{{json_encode($calcs[$category->id] ?? '')}}">{{$category->name}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @include('partials.gallery_div_random')
        <div class=" block-title_center">
            <button class="link link_arrows show-more show-more-btn" type="button" >
                Показать все работы
            </button>
        </div>
    </div>
    @push('modals')
        <div class="modal " id="gallery-modal" aria-hidden="true">
            <div tabindex="-1" class="modal__overlay" data-micromodal-close>
                <div class="modal__holder_gallery_container" role="dialog" aria-modal="true">
                <div class="modal__holder_gallery" role="dialog" aria-modal="true">
                    <div class="swiper-container gallery-slider">
                        <div class="swiper-wrapper">
                                @foreach($files as $file)
                                    <div class="swiper-slide">
                                        <img src="{{ $file->src }}" alt="{{ $file->alt }}">
                                        <div class="text-center gallery-description-text">
                                            {!! $file->description !!}
                                        </div>
                                    </div>
                                @endforeach
                        </div>
                    </div>
                </div>
                    <div class="modal_gallery__close" data-micromodal-close><i class="icon-close"></i></div>
                    <div class="swiper-gallery-button-next">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="24" cy="24" r="24" fill="white"/>
                            <path d="M37.714 24L38.4211 24.7071L39.1282 24L38.4211 23.2928L37.714 24ZM26.421 11.2929C26.0304 10.9024 25.3973 10.9024 25.0067 11.2929C24.6162 11.6834 24.6162 12.3166 25.0068 12.7071L26.421 11.2929ZM25.0068 35.2929C24.6162 35.6834 24.6162 36.3166 25.0067 36.7071C25.3973 37.0976 26.0304 37.0976 26.421 36.7071L25.0068 35.2929ZM37.714 23H10V25H37.714V23ZM38.4211 23.2928L26.421 11.2929L25.0068 12.7071L37.0069 24.7071L38.4211 23.2928ZM37.0069 23.2928L25.0068 35.2929L26.421 36.7071L38.4211 24.7071L37.0069 23.2928Z" fill="#5A6E8C"/>
                        </svg>

                    </div>
                    <div class="swiper-gallery-button-prev">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="24" cy="24" r="24" fill="white"/>
                                <path d="M9.99999 24L9.29288 23.2929L8.58576 24.0001L9.29289 24.7072L9.99999 24ZM21.293 36.7071C21.6836 37.0976 22.3167 37.0976 22.7072 36.7071C23.0978 36.3166 23.0978 35.6834 22.7072 35.2929L21.293 36.7071ZM22.7072 12.7071C23.0978 12.3166 23.0978 11.6834 22.7072 11.2929C22.3167 10.9024 21.6836 10.9024 21.293 11.2929L22.7072 12.7071ZM9.99999 25L37.714 25L37.714 23L9.99999 23L9.99999 25ZM9.29289 24.7072L21.293 36.7071L22.7072 35.2929L10.7071 23.2929L9.29289 24.7072ZM10.7071 24.7072L22.7072 12.7071L21.293 11.2929L9.29288 23.2929L10.7071 24.7072Z" fill="#5A6E8C"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    @endpush
    <script>
        for(let i = 0; i < localStorage.length; i++) {
            const k = localStorage.key(i);
            k.includes('randomItem') && localStorage.removeItem(k)
        }
    </script>
@endif
