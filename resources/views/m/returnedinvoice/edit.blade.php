@extends('layouts.mobile')

@section('content')
    <h1>Возврат № {{ $returnedInvoice->number  }}</h1>
    <h6><a href="{{ route('m.returnedinvoice') }}" >0-Выход</a></h6>

    <form action="{{ action('m\ReturnedInvoiceController@submiteditbarcode', ['id' => $returnedInvoice->id]) }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" id="returned_invoice_id" name="returned_invoice_id" value="{{ $returnedInvoice->id }}" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    @include('m.errors')

    <table>
        <thead>
        <tr>
            <th>№</th>
            <th>Наименование</th>
            <th>Зак</th>
            <th>Наб</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($returnedInvoice->returnedInvoiceLines as $item)
            @if ($item->quantity != $item->quantity_mark)
                <tr>
                    <td>{{$item->lineid}}</td>
                    <td class="tddescr" colspan="3">{{$item->productdescr}}</td>
                </tr>
                <tr>
                    <td class="bb regidf2" colspan="2">{{$item->f2regid}}</td>
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

