@if(isset($mf_content) && !empty($mf_content))
    @foreach($mf_content as $content)
        @include('partials.mf.'.$content['_name'], ['data'=>$content['group']])
    @endforeach
@endif