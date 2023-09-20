@empty(!$title)
    <fieldset>
            <div class="col p-0 px-3">
                <legend class="text-black text-black mt-2 mx-2">
                    {{ $title }}
                </legend>
            </div>
    </fieldset>
@endempty

<div class="bg-white rounded shadow-sm mb-3">
    <ul class="list-group">
        @foreach ($rows as $category)
            <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <span>
                        {{ $category->name }}
                    </span>
                    <div class="d-flex gap-1">
                        @foreach ($categoryActions($category) as $action)
                            {{ $action }}
                        @endforeach
                    </div>
                </div>
            </li>
            @foreach ($category->galleries as $gallery)
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <div style="width: 2rem;"></div>
                            <span>
                                {{ $gallery->name }}
                            </span>
                        </div>
                        <div class="d-flex gap-1">
                            @foreach ($galleryActions($category, $gallery) as $action)
                                {{ $action }}
                            @endforeach
                        </div>
                    </div>
                </li>
            @endforeach
        @endforeach
    </ul>
</div>
