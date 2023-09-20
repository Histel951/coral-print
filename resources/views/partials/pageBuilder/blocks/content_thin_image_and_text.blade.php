<div class="row mb-5 center-block">
    @foreach($block['images'] as $image)
        <div class="col-md-4">
            <img src="{{ $image['image'] }}" alt="">
            <p>{!! $image['text'] !!}</p>
        </div>
    @endforeach
</div>