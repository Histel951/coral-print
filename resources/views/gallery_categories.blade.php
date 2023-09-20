@if($categories->count())
<h3>Категории</h3>
@endif
<ul class="list-group">
    @foreach ($categories as $category)
        <li class="list-group-item">
            <a href="#" data-bs-toggle="collapse" data-bs-target="#gallery{{$category->id}}">
                <span style="color: #104fb9">
                @svg('css-tab')
                </span>
                <span>{{$category->name}}</span>
            </a>
            <a href="#" class="link-success" data-toggle="tooltip" data-placement="bottom" title="Добавить галерею"
               data-controller="modal-toggle" data-action="click->modal-toggle#targetModal"
               data-modal-toggle-title="Добавление галереи" data-modal-toggle-key="asyncAddModal"
               data-modal-toggle-async="" data-modal-toggle-params=@json(['id' => $category->id, 'calculator_type_id' => $calculator_type_id])
               data-modal-toggle-action="{{route("platform.galleries.attachGalleryCategory", ['id' => $category->id])}}"
            >
                @svg('css-add')
            </a>
            <a href="#" class="link-primary" data-toggle="tooltip" data-placement="bottom" title="Редактировать категорию"
               data-controller="modal-toggle" data-action="click->modal-toggle#targetModal"
               data-modal-toggle-title="Редактирование категории" data-modal-toggle-key="asyncGalleryCategoryModal"
               data-modal-toggle-async="" data-modal-toggle-params="{{json_encode(['id' => $category->id, 'name' => $category->name,
'calculator_type_id' => $calculator_type_id, 'calculator_id' => $category->calculator_id])}}"
               data-modal-toggle-action="{{route("platform.galleries.saveGalleryCategory", ['id' => $category->id])}}"
            >
                <span class="link-primary">@svg('antdesign-edit-o')</span>
            </a>
            <a href="#" class="link-danger" data-toggle="tooltip" data-placement="bottom" title="Удалить категорию"
                data-controller="modal-toggle" data-action="click->modal-toggle#targetModal"
               data-modal-toggle-title="Удалить категорию" data-modal-toggle-key="asyncGalleryCategoryDeleteModal"
               data-modal-toggle-async="" data-modal-toggle-params=@json(['id' => $category->id])
               data-modal-toggle-action="{{route("platform.galleries.deleteGalleryCategory", ['id' => $category->id])}}"
            >
                @svg('entypo-cross')
            </a>
            <ul class="list-group" id="gallery{{$category->id}}">
                @foreach ($category->galleries as $gallery)
                    <li class="list-group-item">
                        <span style="color: #7c2b9d">
                        @svg('grommet-gallery')
                        </span>
                            {{$gallery->name}}
                        <a href="#" class="link-danger" data-toggle="tooltip" data-placement="bottom" title="Открепить галерею"
                           data-controller="modal-toggle" data-action="click->modal-toggle#targetModal"
                           data-modal-toggle-title="Удалить галерею" data-modal-toggle-key="asyncGalleryDeleteModal"
                           data-modal-toggle-async="" data-modal-toggle-params="[]"
                           data-modal-toggle-action="{{route("platform.galleries.detachGallery", ['gallery_id' => $gallery->id, 'category_id' => $category->id])}}"
                        >
                            @svg('entypo-cross')
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>
