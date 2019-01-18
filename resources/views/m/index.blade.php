@extends('layouts.mobile')

@section('content')
    <div>Выберите действие:</div>

    <form action="{{ action('m\HomeController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    <ul class="mainmenu">
        <li><a href="{{ action('m\OrderController@index') }}">(1) Отгрузка</a></li>
        <li><a href="{{ action('m\ReturnedInvoiceController@index') }}">(2) Возврат от покупателя</a></li>
        <li><a href="{{ action('m\ReadBarCodeController@index') }}">(9) Сканировать штрихкоды</a></li>
        <li><a href="{{ route('m.home.ajax') }}">(0) AJAX</a></li>
        <li><a href="{{ route('m.home.index') }}">(0) Помощь</a></li>
    </ul>
@endsection

@section('scripts')
@endsection
