@extends('layouts.mobile')

@section('content')
    <h1>Новая инвентаризация</h1>

    <form action="{{ action('m\InventoryController@store') }}" id="formInputBarCode" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >

        Номер:<br>
        <input id="InputBarCode1" name="BarCode1" title="Barcode1" value={{$number}} /><br>
        Дата:<br>
        <input id="InputDate" type="date" name="Date" title="Date" value={{$date}} />
        {{--<input type="hidden" id="inventory_id" name="order_id" value="{{ $inventory->id }}" /> --}}
        <input type="submit" value="Записать" />
    </form>

    @include('m.errors')

@endsection

@section('scripts')

@endsection

