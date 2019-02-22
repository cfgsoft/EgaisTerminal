@extends('layouts.mobile')

@section('content')
    <h6>
        <a href="{{ route('m.home.index') }}" accesskey="0" >0-Выход</a>
    </h6>
    <h1>Поступление товара</h1>

    <form action="{{ action('m\InvoiceController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    {{ isset($barcode) ? $barcode : '0' }}

    @foreach ($invoice as $item)
        <div class="card">
            <a href="{{ route('m.invoice.edit', ['id' => $item->id]) }}" >
                <div>{{$item->incoming_date}} № {{$item->incoming_number}}</div>

                <!--
                <div>Руссалко.....ООО</div>
                -->

                <div>{{$item->date}} № {{$item->number}}</div>

                <div>Сумма {{$item->sum}}  <span>{{$item->id}}</span> </div>
            </a>
        </div>
    @endforeach

    {{ $invoice->links("pagination.m-simple") }}

@endsection

@section('scripts')
@endsection

