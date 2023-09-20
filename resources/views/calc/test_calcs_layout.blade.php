<!doctype html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
            crossorigin="anonymous"></script>
    @stack('scripts')
    <title>
        @yield('title')
    </title>
</head>
<body>
<div class="container">
    {{--    <h1 class="text-center">{{$documentObject['pagetitle']}}</h1>--}}
    <div class='text-center py-5'>
        <div class="btn-group btn-group-lg" role="group">
            <a class="btn btn-success" href="{{ route('calc.test.business') }}">Визитки</a>
            <a class="btn btn-info" href="{{ route('calc.test.booklets') }}">Листовки и буклеты</a>
            <a class="btn btn-secondary" href="{{ route('calc.test.stickers') }}">Наклейки</a>
            <a class="btn btn-light" href="{{ route('calc.test.calendars') }}">Календари</a>
            <a class="btn btn-warning" href="{{ route('calc.test.flexa') }}">Флекса</a>
            <a class="btn btn-dark" href="{{ route('calc.test.tags') }}">Бирки</a>
            <a class="btn btn-success bg-gradientr" href="{{ route('calc.test.package') }}">Пакеты</a>
            <a class="btn btn-primary" href="{{ route('calc.test.catalogs') }}">Каталоги</a>
            <a class="btn btn-danger" href="{{ route('calc.test.offset') }}">Оффсет</a>
            <a class="btn btn-info" href="{{ route('calc.test.wide') }}">Широкий</a>
        </div>
    </div>
    @yield('content')
</div>
</body>
</html>
