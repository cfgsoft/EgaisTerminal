@extends('layouts.mobile')

@section('content')
    <h1>Инвентаризация № {{ $inventory->number  }} </h1>
    <h6><a href="{{ route('m.inventory') }}" >0-Выход</a></h6>

    <form action="{{ action('m\InventoryController@submiteditbarcode', ['id' => $inventory->id]) }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" id="inventory_id" name="inventory_id" value="{{ $inventory->id }}" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    @include('m.errors')

    <table class="table">
        <thead>
            <tr>
                <th>№</th>
                <th>Наименование</th>
                <th>Штуки</th>
                <th>Упак</th>
                <th>Пл</th>
            </tr>
        </thead>
        <tbody>

        @foreach ($inventory->inventoryLines as $item)
            <tr>
                <td>{{$item->line_id}}</td>
                <td class="tddescr" colspan="3">{{$item->product_descr}}</td>
            </tr>
            <tr>
                <td class="bb regidf2" colspan="2">{{$item->f2reg_id}}</td>
                <td class="bb">{{$item->quantity}}</td>
                <td class="bb">{{$item->quantity_pack}}</td>
                <td class="bb">{{$item->quantity_pallet}}</td>
            </tr>
        @endforeach

    </tbody>
</table>

@endsection

@section('scripts')

@endsection

