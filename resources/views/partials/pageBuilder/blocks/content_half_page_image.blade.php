<div class="row">
    @foreach ($block['images'] as $image)
        <div class="col-md-6">
            <img src="{{ $image['image'] }}" alt="" class="mb-4">
        </div>
    @endforeach
</div>