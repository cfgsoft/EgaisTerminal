<?php

namespace App\Http\Controllers\m;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
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
    public function index()
    {
        $order = Order::orderBy("number", 'desc')
                 ->take(10)->get();

        return view('m/order/index', ['order' => $order]);
    }

    public function edit(Request $request)
    {
        $order = Order::find($request->get('id'));
        $order->orderlines;

        return view('m/order/edit', ['order' => $order]);
    }

    public function submitbarcode(Request $request)
    {
        $barcode = '';
        if ($request->has('BarCode')) {
            $barcode = $request->get('BarCode');
        }

        if ($barcode == '0') {
            return redirect()->action('m\HomeController@index');
        }

//        if (isset($barcode)) {
//            $newbarbode = new ReadBarCode;
//            $newbarbode->barcode = $barcode;
//            $newbarbode->save();
//        }

        return redirect()->action('m\OrderController@index');
    }

    public function submiteditbarcode(Request $request)
    {
        $barcode = '';
        if ($request->has('BarCode')) {
            $barcode = $request->get('BarCode');
        }

        $order_id = '';
        if ($request->has('order_id')) {
            $order_id = $request->get('order_id');
        }

        if ($barcode == '0') {
            return redirect()->action('m\OrderController@index');
        }

        return redirect()->action('m\OrderController@edit', ['id' => $order_id]);
    }
}
