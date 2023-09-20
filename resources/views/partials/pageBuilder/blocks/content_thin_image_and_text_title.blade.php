<div class="row">
    @foreach ($block['images'] as $image)
        <div class="col-md-4 mb-5">
            <img src="{{ $image['image'] }}" alt="" class="mb-4">
            <h3>{{ $image['title'] }}</h3>
            {!! $image['text'] !!}
        </div>
    @endforeach
</div>