<?php

namespace App\Http\Controllers\m;

use App\Models\Invoice\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$invoice = Invoice::orderBy("number", 'desc')->simplePaginate(4);
        $invoice = Invoice::orderBy("id", 'desc')->simplePaginate(4);

        $barcode = $request->input('barcode', '');

        return view('m/invoice/index', ['invoice' => $invoice, 'barcode' => $barcode]);
    }

    public function edit(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        $invoice->invoiceLines;
        $invoice->invoiceLines = $invoice->invoiceLines->sortBy('line_id')->sortByDesc('show_first');
        $invoice->invoicePackLines;
        $invoice->invoicePalletLines;

        $palletId = null;
        $packId   = null;

        if ($request->session()->has('invoice')) {
            $currentInvoice = $request->session()->get('invoice');

            if ($currentInvoice['invoiceId'] == $id) {
                $palletId =  $currentInvoice['palletId'];
                $packId   = $currentInvoice['packId'];
            } else{
                $request->session()->forget('invoice');
            }
        }

        $show = $request->input('show', '');

        if ($show == 'pallet')
        {
            $invoice->invoiceLines = $invoice->invoiceLines->filter(function ($item)
            {
                return $item['quantity_pallet'] != $item['quantity_pallet_mark'];
            });

        }
        if ($show == 'box')
        {
            $invoice->invoiceLines = $invoice->invoiceLines->filter(function ($item)
            {
                return $item['quantity_pack'] != $item['quantity_pack_mark'];
            });
        }

        /*
        foreach ($invoice->invoiceLines as $item)
        {
            $palletLines = $invoice->invoicePalletLines->filter(function ($itemPallet) use ($item) {
                return $itemPallet['line_identifier'] == $item['line_identifier'];
            });

            $item['invoicePalletLines'] = $palletLines;

            foreach ($item['invoicePalletLines'] as $itemPallet)
            {
                $packLines = $invoice->invoicePackLines->filter(function ($itemPack) use ($itemPallet) {
                    return $itemPack['pallet_number'] == $itemPallet['pallet_number'];
                });

                $itemPallet['invoicePackLines'] = $packLines;
            }
        }
        */

        return view('m/invoice/edit', ['invoice' => $invoice, 'palletId' => $palletId, 'packId' => $packId]);
    }

    public function submitbarcode(Request $request)
    {
        $barcode = $request->input('BarCode', '');

        if ($barcode == '0') {
            return redirect()->action('m\HomeController@index');
        } elseif ($barcode == '1') {
            //Prev
            //dd($request);
        } elseif ($barcode == '3') {
            //Next
        }

        if (strlen($barcode) > 8 and strlen($barcode) < 13) {
            $barcode = str_replace("*", "", $barcode);
        }

        $invoice = Invoice::where('barcode', '=', $barcode)->first();
        if ($invoice != null) {
            return redirect()->action('m\InvoiceController@edit', ['id' => $invoice->id]);
        } else {
            return redirect()->back()->withErrors(['BarCode' => 'Не найдено поступление № ' . $barcode]);
        }
    }

    public function submiteditbarcode(Request $request)
    {
        $barcode   = $request->input('BarCode', '');
        $invoiceId = $request->input('invoiceId', '');

        if ($barcode == '0') {
            return redirect()->action('m\InvoiceController@index');
        } elseif ($barcode == '1'){
            $request->session()->forget('invoice');

            return redirect()->action('m\InvoiceController@edit', ['id' => $invoiceId]);
        } elseif ($barcode == '2'){

            return redirect()->action('m\InvoiceController@edit', ['id' => $invoiceId, 'show' => 'pallet']);
        } elseif ($barcode == '3'){
            return redirect()->action('m\InvoiceController@edit', ['id' => $invoiceId, 'show' => 'box']);

        } elseif ($barcode == '4'){
            return redirect()->action('m\InvoiceController@edit', ['id' => $invoiceId]);
        }

        $this->validate($request,
            ['BarCode'	=>
                ['required',
                    'min:9',
                    'max:150',
                ]
            ]
            ,
            ['BarCode.required' => 'Заполните ШК',
             'BarCode.min'      => 'ШК минимум 9 символов',
             'BarCode.max'      => 'ШК максимум 150 символов'
            ]
        );

        $palletId = null;
        $packId   = null;

        if ($request->session()->has('invoice')) {
            $currentInvoice = $request->session()->get('invoice');
            if ($currentInvoice['invoiceId'] == $invoiceId) {
                $palletId =  $currentInvoice['palletId'];
                $packId   = $currentInvoice['packId'];
            } else{
                $request->session()->forget('invoice');
            }
        }

        $invoice = Invoice::find($invoiceId);
        $result = $invoice->addBarCode($barcode, $palletId, $packId);

        $errorBarCode = $result['error'];
        $errorMessage = $result['errorMessage'];
        $palletId     = $result['palletId'];
        $packId       = $result['packId'];;

        if ($errorBarCode) {
            return redirect()->back()->withErrors(['errorMessage' => $errorMessage]);
        }

        $invoiceSession = ['invoiceId' => $invoiceId,
                           'packId'    => $packId,
                           'palletId'  => $palletId];

        $request->session()->put('invoice', $invoiceSession);

        return redirect()->action('m\InvoiceController@edit', ['id' => $invoiceId]);
    }

}
