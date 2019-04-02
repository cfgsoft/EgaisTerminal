@extends('layouts.mobile')

@section('content')
    <h5>Отгрузка товара</h5>
    <h6><a href="{{ route('m.home.index') }}" >0-Выход</a></h6>

    <form action="{{ action('m\OrderController@submitbarcode') }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    {{ isset($barcode) ? $barcode : '0' }}

    @include('m.errors')

    <!-- <h5>Документы набора</h5> -->

    <table>
        <thead>
            <tr>
                <th>Заявка</th>
                <th>Зак</th>
                <th>Наб</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($order as $item)
                <tr>
                    <td class="tddescr bb">
                        <a href="{{ route('m.order.edit', ['id' => $item->id]) }}" >
                            {{$item->date}} № {{$item->number}}
                        </a>
                    </td>
                    <td class="bb">
                        {{$item->quantity}}
                    </td>
                    <td class="bb">
                        {{$item->quantity_mark}}
                    </td>
                </tr>
        @endforeach

        </tbody>
    </table>

    {{--
    @foreach ($order as $item)
    <div class="card">
        <a href="{{ route('m.order.edit', ['id' => $item->id]) }}" >
            <div>{{$item->date}} № {{$item->number}} <span>{{$item->quantity}}</span> <span>{{$item->quantity_mark}}</span> </div>
        </a>
    </div>
    @endforeach
    --}}

    {{ $order->links("pagination.m-simple") }}

@endsection

@section('scripts')
@endsection

