@extends('layouts.mobile')

@section('content')
    <h1>Поступление №{{ $invoice->number  }}</h1>
    <h6>
        <a href="{{ route('m.invoice') }}" >0-Выход</a>
        <a href="{{ route('m.invoice.edit', ['id' => $invoice->id, 'show' => 'pallet']) }}" >2-Паллет</a>
        <a href="{{ route('m.invoice.edit', ['id' => $invoice->id, 'show' => 'box']) }}" >3-Ящик</a>
        <a href="{{ route('m.invoice.edit', ['id' => $invoice->id]) }}" >4-Бутылка</a>
    </h6>

    <form action="{{ action('m\InvoiceController@submiteditbarcode', ['id' => $invoice->id]) }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" id="invoiceId" name="invoiceId" value="{{ $invoice->id }}" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    @include('m.errors')

    @if ($palletId != null or $packId != null)
        <div class="invoicepack">1-Отчистить упаковку
            @if ($palletId != null)
                <p>Паллет № {{$palletId}}</p>
            @endif
            @if ($packId != null)
                <p><b>Упаковка № {{$packId}}</b></p>
            @endif
        </div>
    @endif

    {{--
    {{ $palletId or '' }}
    {{ isset($packId) ? 'Упаковка id ' . $packId : '' }}


    @foreach ($invoice->invoiceLines as $item)
        <div class="invoiceline">
            <div>{{$item->line_id}}. {{$item->product_descr}}</div>
            <h6>{{$item->f2reg_id}}</h6>
            <div> {{$item->quantity_pallet}} {{$item->quantity_pallet_mark}} | {{$item->quantity_pack}} {{$item->quantity_pack_mark}} | {{$item->quantity}} {{$item->quantity_mark}} </div>
        </div>
    @endforeach
    --}}

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
        @foreach ($invoice->invoiceLines as $item)
            <tr>
                <td rowspan="3" class="bb">{{$item->line_id}}</td>
                <td rowspan="3" class="tddescr bb">
                    {{$item->product_descr}}
                    <h6 class="regidf2">{{$item->f2reg_id}}</h6>
                </td>
                <td>{{$item->quantity_pallet}}</td>
                <td>{{$item->quantity_pallet_mark}}</td>
            </tr>
            <tr>
                <td>{{$item->quantity_pack}}</td>
                <td>{{$item->quantity_pack_mark}}</td>
            </tr>
            <tr>
                <td class="bb">{{$item->quantity}}</td>
                <td class="bb">{{$item->quantity_mark}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

@endsection

@section('scripts')

@endsection

