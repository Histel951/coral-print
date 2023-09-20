@if($item['is_folder'])
    <li class="list-group-item">
        <a href="#" data-bs-toggle="collapse" data-bs-target="#ellement{{$item['content_id']}}">
            <span style="color:{{isset($item['items']) ? "#f5bc08" : "wheat"}};"><svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" fill="currentColor"><path d="M880 298.4H521L403.7 186.2a8.15 8.15 0 0 0-5.5-2.2H144c-17.7 0-32 14.3-32 32v592c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V330.4c0-17.7-14.3-32-32-32zM632 577c0 3.8-3.4 7-7.5 7H540v84.9c0 3.9-3.2 7.1-7 7.1h-42c-3.8 0-7-3.2-7-7.1V584h-84.5c-4.1 0-7.5-3.2-7.5-7v-42c0-3.8 3.4-7 7.5-7H484v-84.9c0-3.9 3.2-7.1 7-7.1h42c3.8 0 7 3.2 7 7.1V528h84.5c4.1 0 7.5 3.2 7.5 7v42z"></path></svg></span>
            <span style="color:{{$item['is_visible'] ? 'darkblue' : 'gray'}}">{{$item['title'] }}</span>
            <sup>{{ $item['content_id'] }}</sup>
        </a>
        <a href="{{ route('platform.content.edit',['content_id' => $item['content_id']]) }}" class="link-success"
           data-toggle="tooltip" data-placement="bottom" title="Редактировать">
            <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" fill="currentColor"><path d="M257.7 752c2 0 4-.2 6-.5L431.9 722c2-.4 3.9-1.3 5.3-2.8l423.9-423.9a9.96 9.96 0 0 0 0-14.1L694.9 114.9c-1.9-1.9-4.4-2.9-7.1-2.9s-5.2 1-7.1 2.9L256.8 538.8c-1.5 1.5-2.4 3.3-2.8 5.3l-29.5 168.2a33.5 33.5 0 0 0 9.4 29.8c6.6 6.4 14.9 9.9 23.8 9.9zm67.4-174.4L687.8 215l73.3 73.3-362.7 362.6-88.9 15.7 15.6-89zM880 836H144c-17.7 0-32 14.3-32 32v36c0 4.4 3.6 8 8 8h784c4.4 0 8-3.6 8-8v-36c0-17.7-14.3-32-32-32z"></path></svg></a>
        @if(isset($item['items']))
        <ul class="list-group collapse" id="ellement{{$item['content_id']}}">
                @foreach($item['items'] as $value)
                    @include('partials.content_ul', ['item' => $value])
                @endforeach
        </ul>
        @endif
    </li>
@else
    <li class="list-group-item">
        <span style="color: {{$item['is_visible'] ? 'darkblue' : 'gray'}}">{{ $item['title'] }}</span>
        <sup>{{ $item['content_id'] }}</sup>
        <a href="{{ route('platform.content.edit',['content_id' => $item['content_id']]) }}" class="link-success">
            <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" fill="currentColor"><path d="M257.7 752c2 0 4-.2 6-.5L431.9 722c2-.4 3.9-1.3 5.3-2.8l423.9-423.9a9.96 9.96 0 0 0 0-14.1L694.9 114.9c-1.9-1.9-4.4-2.9-7.1-2.9s-5.2 1-7.1 2.9L256.8 538.8c-1.5 1.5-2.4 3.3-2.8 5.3l-29.5 168.2a33.5 33.5 0 0 0 9.4 29.8c6.6 6.4 14.9 9.9 23.8 9.9zm67.4-174.4L687.8 215l73.3 73.3-362.7 362.6-88.9 15.7 15.6-89zM880 836H144c-17.7 0-32 14.3-32 32v36c0 4.4 3.6 8 8 8h784c4.4 0 8-3.6 8-8v-36c0-17.7-14.3-32-32-32z"></path></svg></a>
    </li>
@endif
