@extends('layouts.mobile')

@section('content')
    <h1>Выберите действие</h1>

    <form action="{{ action('m\HomeController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    <ul class="mainmenu">
        <li><a href="{{ action('m\OrderController@index') }}">          (1) Отгрузка ЕГАИС</a></li>
        <li><a href="{{ action('m\ReturnedInvoiceController@index') }}">(2) Возврат от покупателя</a></li>
        <li><a href="{{ action('m\InvoiceController@index') }}">        (3) Поступление ЕГАИС</a></li>
        <li><a href="{{ action('m\ReadBarCodeController@index') }}">    (9) Сканировать штрихкоды</a></li>
        <li><a href="{{ route('m.home.ajax') }}">(0) AJAX</a></li>
        <li><a href="{{ route('m.home.about') }}">(0) Помощь</a></li>
    </ul>
@endsection

@section('scripts')
@endsection
