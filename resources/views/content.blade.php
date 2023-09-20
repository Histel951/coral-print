<ul class="list-group">
    @foreach($data as $datum)
        @include('partials.content_ul', ['item' => $datum])
    @endforeach
</ul>
