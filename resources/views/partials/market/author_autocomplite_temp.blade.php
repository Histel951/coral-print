@foreach ($authors as $author)
    <li class="on-artist__item">
        <a class="on-artist__link authorSelect" href=""
           data-value="{{ strtr($author['authorName'], ['<strong>'=>'', '</strong>'=>'']) }}">{!! '@' . $author['authorName'] !!}</a>
    </li>
@endforeach