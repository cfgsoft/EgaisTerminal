<?php

namespace App\Http\Controllers\m;

use App\Models\ReturnedInvoice\ReturnedInvoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReturnedInvoiceController extends Controller
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
        $returnedInvoice = ReturnedInvoice::orderBy("number", 'desc')
            ->take(10)->get();

        $barcode = '';
        if ($request->has('barcode')) {
            $barcode = $request->get('barcode');
        }

        return view('m/returnedinvoice/index', ['returnedInvoice' => $returnedInvoice, 'barcode' => $barcode]);
    }

    public function edit(Request $request)
    {
        $returnedInvoice = ReturnedInvoice::find($request->get('id'));
        $returnedInvoice->returnedInvoicelines;
        $returnedInvoice->returnedInvoicelines = $returnedInvoice->returnedInvoicelines->sortBy('lineid')->sortByDesc('show_first');

        $errorMessage = '';
        if ($request->has('errorMessage')) {
            $errorMessage = $request->get('errorMessage');
        }

        return view('m/returnedinvoice/edit', ['returnedInvoice' => $returnedInvoice, 'errorMessage' => $errorMessage]);
    }

    public function submitbarcode(Request $request)
    {
        $barcode = $request->input('BarCode', '');
        if ($barcode == '0') {
            return redirect()->action('m\ReturnedInvoiceController@index');
        }

        if (strlen($barcode) > 8 and strlen($barcode) < 13) {
            $barcode = str_replace("*", "", $barcode);
            $returnedInvoice = ReturnedInvoice::where('barcode', '=', $barcode)->first();

            if ($returnedInvoice != null) {
                return redirect()->action('m\ReturnedInvoiceController@edit', ['id' => $returnedInvoice->id]);
            }
        }

        $barcode = 'Не найден заказ №' . $barcode;

        return redirect()->action('m\ReturnedInvoiceController@index', ['barcode' => $barcode]);
    }

    public function submiteditbarcode(Request $request)
    {
        $barcode  = $request->input('BarCode', '');
        $returned_invoice_id = $request->input('returned_invoice_id', '');

        if ($barcode == '0') {
            return redirect()->action('m\ReturnedInvoiceController@index');
        }

        //Переход на другой заказ
//        if (strlen($barcode) > 8 and strlen($barcode) < 13) {
//            $barcode = str_replace("*", "", $barcode);
//
//            $order = Order::where('barcode', '=', $barcode)->first();
//
//            if (isset($order)) {
//                return redirect()->action('m\ReturnedInvoiceController@edit', ['id' => $order->id]);
//            }
//        }

        $returnedInvoice = ReturnedInvoice::find($returned_invoice_id);
        $result = $returnedInvoice->addBarCode($barcode);

//        if (strlen($barcode) == 26) {
//            $result = $this->addPackExciseStamp($barcode, $order_id);
//        } else {
//            $result = $this->addExciseStamp($barcode, $order_id);
//        }
//
        $errorBarCode = $result['error'];
        $errorMessage = $result['errorMessage'];

        if ($errorBarCode) {
            return redirect()->action('m\ReturnedInvoiceController@edit', ['id' => $returned_invoice_id, 'errorMessage' => $errorMessage ]);
        }

        return redirect()->action('m\ReturnedInvoiceController@edit', ['id' => $returned_invoice_id]);

    }

}
