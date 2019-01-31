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

    public function edit(Request $request)
    {
        $invoice = Invoice::find($request->get('id'));
        $invoice->invoicelines;
        //$invoice->invoicelines = $invoice->invoicelines->sortBy('line_id')->sortByDesc('show_first');

        $errorMessage = '';
        if ($request->has('errorMessage')) {
            $errorMessage = $request->get('errorMessage');
        }

        return view('m/invoice/edit', ['invoice' => $invoice, 'errorMessage' => $errorMessage]);
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

//        if ($barcode == '0') {
//            return redirect()->action('m\OrderController@index');
//        }
//
//        //Переход на другой заказ
//        if (strlen($barcode) > 8 and strlen($barcode) < 13) {
//            $barcode = str_replace("*", "", $barcode);
//            //$barcode = str_replace("C", "С", $barcode);
//            //$barcode = substr($barcode, 0, 4) . '_' . substr($barcode, 4);
//            //$order = Order::where('number', '=', $barcode)->first();
//
//            $order = Order::where('barcode', '=', $barcode)->first();
//
//            if (isset($order)) {
//                return redirect()->action('m\OrderController@edit', ['id' => $order->id]);
//            }
//        }
//
//        if (strlen($barcode) == 26) {
//            $result = $this->addPackExciseStamp($barcode, $order_id);
//        } else {
//            $result = $this->addExciseStamp($barcode, $order_id);
//        }
//
//        $errorBarCode = $result['error'];
//        $errorMessage = $result['errorMessage'];
//
//        if ($errorBarCode) {
//            return redirect()->action('m\OrderController@edit', ['id' => $order_id, 'errorMessage' => $errorMessage ]);
//        }

        return redirect()->action('m\InvoiceController@edit', ['id' => $invoice_id]);

    }
}