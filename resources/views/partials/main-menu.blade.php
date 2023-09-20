<div class="nav" data-id="nav">
    @foreach($menuTree as $type)
        @if($type['is_visible'])
            <div class="nav__item" data-nav="item">
                <a class="nav__link @if(count($type['child_items']) > 0) link_arrows @endif" href="{{$type['url'] ?? '#'}}"
                   data-item="menu">{{$type['name']}}</a>
                @if(count($type['child_items']) > 0)
                    <div class="nav__dropdown">
                        <div class="nav__desc">
                            <a href="#" class="btn-back" data-btn="back"></a>
                            <ul>
                                @foreach($type['child_items'] as $item)
                                    @if($item['is_visible'])
                                        <li><a href="{{$item['url'] ?? '#'}}">{{$item['name']}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    @endforeach
</div>
