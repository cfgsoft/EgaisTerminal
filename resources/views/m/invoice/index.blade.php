@extends('layouts.mobile')

@section('content')
    <div>Поступление товара</div>
    <h6><a href="{{ route('m.home.index') }}" accesskey="0" >0-Выход</a></h6>

    <!--
    <form action="{{ action('m\InvoiceController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>
    -->

    {{ isset($barcode) ? $barcode : '0' }}

    <table class="table">
        <thead>
        <tr>
            <th>
                Номер
            </th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoice as $item)
            <tr>
                <td>
                    {{$item->id}} . {{$item->number}}
                </td>
                <td>
                    <a href="{{ route('m.invoice.edit', ['id' => $item->id]) }}" >Собрать</a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    {{ $invoice->links("pagination.m-simple") }}

@endsection

@section('scripts')
@endsection

