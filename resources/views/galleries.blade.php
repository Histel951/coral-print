@if($galleries->count())
    <h3>Галереи</h3>
@endif
<ul class="list-group">
    @foreach ($galleries as $gallery)
        <li class="list-group-item">
            <span style="color: #7c2b9d">
                @svg('grommet-gallery')
            </span>

            <a href="{{route('platform.gallery.edit', ['calculator_type_id' => $calculator_type_id, 'gallery_id' => $gallery->id])}}" class="link-primary">
                <span class="link-primary">{{$gallery->name}}</span>
            </a>
            <ul class="list-group collapse" id="galleryTabs{{$gallery->id}}">

            </ul>
        </li>
    @endforeach
</ul>
