<?php

$settings = \App\Models\CommonSetting::first();
$departments = \App\Models\Department::all();
$childItems = $mainChildItems ?? \App::make(\App\Services\ContentService::class)->getChildItems(\App\Services\ContentService::PARENT_ID, true);
$menuTree = App::make(\App\Services\MenuService::class)->getMenuItemsTree();

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width ,initial-scale=1.0, user-scalable=0" id="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Coral Print</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @stack('styles')
</head>
<body>

<div class="site-holder">
    <header class="header">
        @include('partials.header')
    </header>
    <main>
        @yield('main')
    </main>
    <footer class="footer">
        @include('partials.footer')
    </footer>
</div>

<button class="go-top" data-id="btn-scroll" type="button">
    <svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M11 0.75L22 11.957L20.5345 13.3955L12.0267 4.72752V22.7503H9.97324V4.72753L1.46549 13.3955L0 11.957L11 0.75Z"/>
    </svg>
</button>

@include('partials.modals')

@yield('additional_modals')

@stack('modals')

<script type="application/javascript" src="{{asset('js/app.js')}}"></script>
<script type="application/javascript" src="{{ asset('js/vue/main.js') }}"></script>
@stack('scripts')
</body>
</html>
