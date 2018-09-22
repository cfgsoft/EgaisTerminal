@extends('layouts.mobile')

@section('content')
    <h6><a href="{{ route('m.home.index') }}" >0-Выход</a></h6>
    <p>Отсканируйте штрих код</p>

    <form action="{{ action('m\ReadBarCodeController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="23" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    @foreach ($barcode as $item)
        <h6> {{ $item->barcode }} </h6>
        <h5> {{ $item->created_at }} </h5>
    @endforeach

@endsection

@section('scripts')
    window.onload = setFocus;
    document.getElementById('InputBarCode').onpaste = setPasteInputBarCode;
@endsection

