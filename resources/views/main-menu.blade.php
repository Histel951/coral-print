<ul class="list-group">
    @foreach($items as $item)
        @include('partials.main-menu-ul', ['item' => $item])
    @endforeach
</ul>
