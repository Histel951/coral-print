@extends('layouts.layout')
@section('main')
    {!! \Flynsarmy\DbBladeCompiler\Facades\DbView::make($template, $params)->render() !!}
@endsection
