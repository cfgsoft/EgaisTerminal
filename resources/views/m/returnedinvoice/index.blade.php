@extends('layouts.mobile')

@section('content')
    <div>Возврат от покупателя</div>
    <h6><a href="{{ route('m.home.index') }}" >0-Выход</a></h6>

    <form action="{{ action('m\ReturnedInvoiceController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    {{ isset($barcode) ? $barcode : '0' }}

    @include('m.errors')

    @foreach ($returnedInvoice as $item)
        <div class="card">
            <a href="{{ route('m.returnedinvoice.edit', ['id' => $item->id]) }}" >
                <div>{{$item->date}} № {{$item->number}}</div>
            </a>
        </div>
    @endforeach

    <!--
    <h5>Документы набора</h5>
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
        @foreach ($returnedInvoice as $item)
            <tr>
                <td>
                    {{$item->number}}
                </td>
                <td>
                    <a href="{{ route('m.returnedinvoice.edit', ['id' => $item->id]) }}" >Собрать</a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    -->

    {{ $returnedInvoice->links("pagination.m-simple") }}

@endsection

@section('scripts')
@endsection

