@extends('layouts.mobile')

@section('content')
    <h1>Отгрузка № {{ $order->number  }} </h1>
    <h6><a href="{{ route('m.order') }}" >0-Выход</a></h6>

    <form action="{{ action('m\OrderController@submiteditbarcode', ['id' => $order->id]) }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" id="order_id" name="order_id" value="{{ $order->id }}" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    {{--
    {{ isset($errorMessage) ? $errorMessage : '' }}
    --}}

    @include('m.errors')

    <table class="table">
        <thead>
            <tr>
                <th>№</th>
                <th>Наименование</th>
                <th>Зак</th>
                <th>Наб</th>
            </tr>
        </thead>
        <tbody>

        @foreach ($order->orderLines as $item)
            @if ($item->quantity != $item->quantity_mark)
                <tr>
                    <td>{{$item->line_id}}</td>
                    <td class="tddescr" colspan="3">{{$item->product_descr}}</td>
                </tr>
                <tr>
                    <td class="bb regidf2" colspan="2">{{$item->f2reg_id}}</td>
                    <td class="bb">{{$item->quantity}}</td>
                    <td class="bb">{{$item->quantity_mark}}</td>
                </tr>

            @endif
        @endforeach

        </tbody>
    </table>

@endsection

@section('scripts')

@endsection

