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

        return view('m/invoice/edit', ['invoice' => $invoice]);
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
            $invoice = Invoice::where('barcode', '=', $barcode)->first();

            if ($invoice != null) {
                return redirect()->action('m\InvoiceController@edit', ['id' => $invoice->id]);
            }
        }

        $barcode = 'Не найдено поступление №' . $barcode;

        return redirect()->action('m\InvoiceController@index', ['barcode' => $barcode]);
    }

    public function submiteditbarcode(Request $request)
    {
        $barcode  = $request->input('BarCode', '');
        $invoice_id = $request->input('invoice_id', '');

        if ($barcode == '0') {
            return redirect()->action('m\InvoiceController@index');
        }

        if ($barcode != '')
        {
            $invoice = Invoice::find($invoice_id);
            $result = $invoice->addBarCode($barcode);

            $errorBarCode = $result['error'];
            $errorMessage = $result['errorMessage'];

            if ($errorBarCode) {
                return redirect()->action('m\InvoiceController@edit', ['id' => $invoice_id, 'errorMessage' => $errorMessage]);
            }
        }

        return redirect()->action('m\InvoiceController@edit', ['id' => $invoice_id]);

    }
}
