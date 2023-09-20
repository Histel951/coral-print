@extends('layouts.layout')
@section('main')
    <div class="container">
        <ul class="breadcrumbs">
            <li><a href="/" >← На главную</a></li>
        </ul>
    </div>
    <section class="section-inner">
        <div class="container">
            <h1 class="page-title page-title_center page-title_404">Ой, такой страницы нет</h1>
            <div class="p-404">
                <div class="p-404__img">
                    <img src="/images/404.png" alt="" width="352" height="360">
                </div>
                <div class="p-404__text">
                    <p>Страницы с таким адресом нет на нашем сайте. <br>Скорее всего вас заинтересуют страницы:</p>
                </div>
                <ul class="p-404__nav">
                    <li><a href="#">Главная →</a></li>
                    <li><a href="#">Продукция →</a></li>
                    <li><a href="#">Услуги →</a></li>
                </ul>
            </div>
        </div>
    </section>
@endsection
