@extends('layouts.mobile')

@section('content')
    <h6><a href="{{ route('m.home.index') }}" >0-Выход</a></h6>
    <p>Отсканируйте штрих код</p>

    <form action="{{ action('m\ReadBarCodeController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    @foreach ($barcode as $item)
        <h6> {{ $item->barcode }} </h6>
        @isset($item->f2regid)
            <h5> {{ $item->f2regid }} </h5>
        @endisset
        <h6> {{ $item->created_at }} </h6>
        <hr>
    @endforeach

@endsection

@section('scripts')
@endsection

