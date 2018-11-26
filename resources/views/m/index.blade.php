@extends('layouts.mobile')

@section('content')
    <p>Выберите действие:</p>

    <form action="{{ action('m\HomeController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="23" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    <ul class="mainmenu">
        <li><a href="{{ action('m\OrderController@index') }}">(1) Отгрузка</a></li>
        <li><a href="{{ action('m\ReadBarCodeController@index') }}">(9) Сканировать штрихкоды</a></li>
        <li><a href="{{ route('m.home.ajax') }}">(0) AJAX</a></li>
        <li><a href="{{ route('m.home.index') }}">(0) Помощь</a></li>
    </ul>
@endsection

@section('scripts')
    window.onload = setFocus;
    document.getElementById('InputBarCode').onpaste = setPasteInputBarCode;
@endsection

