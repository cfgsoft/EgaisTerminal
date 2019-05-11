@extends('layouts.mobile')

@section('content')
    <h1>Инвентаризация</h1>
    <h6>
        <a href="{{ route('m.home.index') }}" >0-Выход</a>
        <a href="{{ route('m.inventory.create') }}" >1-Добавить</a>
    </h6>

    <form action="{{ action('m\InventoryController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    {{ isset($barcode) ? $barcode : '0' }}

    @include('m.errors')

    <table>
        <thead>
        <tr>
            <th>Инвентаризация</th>
            <th>Зак</th>
            <th>Наб</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($inventory as $item)
            <tr>
                <td class="tddescr bb">
                    <a href="{{ route('m.inventory.edit', ['id' => $item->id]) }}" >
                        {{$item->date}} № {{$item->number}} ID {{$item->id}}
                    </a>
                </td>
                <td class="bb">
                    {{$item->quantity_mark}}
                </td>
                <td class="bb">
                    {{$item->quantity_pack_mark}}
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    {{ $inventory->links("pagination.m-simple") }}

@endsection

@section('scripts')
@endsection

