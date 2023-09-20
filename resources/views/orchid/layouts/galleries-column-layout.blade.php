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
        @foreach ($rows as $gallery)
            {{ $action($gallery) }}
        @endforeach
    </ul>
</div>
