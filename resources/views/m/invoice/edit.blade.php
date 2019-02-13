@extends('layouts.mobile')

@section('content')
    <h5>Считайте штрихкод</h5>
    <h6><a href="{{ route('m.invoice') }}" >0-Выход</a></h6>

    <form action="{{ action('m\InvoiceController@submiteditbarcode', ['id' => $invoice->id]) }}" id="formInputBarCode" method="post">
        <input id="InputBarCode" name="BarCode" title="Barcode" size="22" />
        <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoice->id }}" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input type="submit" value=".." />
    </form>

    {{ isset($errorMessage) ? $errorMessage : '' }}

    <div> {{ $invoice->number  }} </div>

    <table class="table">
        <thead>
        <tr>
            <th>
                №
            </th>
            <th>
                Наименование
            </th>
            <th>
                Зак
            </th>
            <th>
                Наб
            </th>
        </tr>
        </thead>
        <tbody>

        @foreach ($invoice->invoiceLines as $item)
            @if ($item->quantity != $item->quantity_mark)
                <tr>
                    <td>
                        {{$item->line_id}}
                    </td>
                    <td class="tddescr">
                        {{$item->product_descr}}
                        <h6>
                            {{$item->f2reg_id}}
                        </h6>
                    </td>
                    <td>
                        {{$item->quantity}}
                    </td>
                    <td>
                        {{$item->quantity_mark}}
                    </td>
                </tr>
            @endif
        @endforeach

        </tbody>
    </table>

@endsection

@section('scripts')

@endsection

