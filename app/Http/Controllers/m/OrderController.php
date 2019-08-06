<?php

namespace App\Http\Controllers\m;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\Rule;

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
    public function index(Request $request)
    {
        //$order = Order::orderBy("number", 'desc')->take(10)->get();

        //$barcode = '';
        //if ($request->has('barcode')) {
        //    $barcode = $request->get('barcode');
        //}

        $order = Order::orderBy("number", 'desc')->simplePaginate(4);

        $barcode = $request->input('barcode', '');

        //dd($order);

        return view('m/order/index', ['order' => $order, 'barcode' => $barcode]);
    }

    public function edit(Request $request, $id)
    {
        //$order = Order::find($request->get('id'));
        $order = Order::find($id);
        if ($order == null)
        {
            return redirect()->action('m\OrderController@index');
        }
        $order->orderLines;
        $order->orderLines = $order->orderLines->sortBy('line_id')->sortByDesc('show_first');

        //$order->orderlines->sortBy('orderlineid');
        //$order->orderlines->sortByDesc('orderlineid');

        //$orderlines = $orderlines->sortByDesc('orderlineid');
        //$order->orderlines = $orderlines;

        //$sorted->values()->all();
        //
        //return var_dump($sorted->values()->all());

        $errorMessage = '';
        if ($request->has('errorMessage')) {
            $errorMessage = $request->get('errorMessage');
        }

        return view('m/order/edit', ['order' => $order, 'errorMessage' => $errorMessage]);
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

        $this->validate($request,
            ['BarCode'	=>
                ['required',
                 'min:9',
                 'max:12',
                ]
            ]
            ,
            ['BarCode.required' => 'Заполните ШК',
             'BarCode.min'      => 'ШК минимум 9 символов',
             'BarCode.max'      => 'ШК максимум 12 символов'
            ]
        );

        $order = Order::where('barcode', '=', $barcode)->first();
        if ($order != null) {
            return redirect()->action('m\OrderController@edit', ['id' => $order->id]);
        } else {
            return redirect()->back()->withErrors(['BarCode' => 'Не найден заказ № ' . $barcode]);
        }
    }

    public function submiteditbarcode(Request $request)
    {
        $barcode  = $request->input('BarCode', '');
        $order_id = $request->input('order_id', '');

        if ($barcode == '0') {
            return redirect()->action('m\OrderController@index');
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

        //Переход на другой заказ
        if (strlen($barcode) > 8 and strlen($barcode) < 13) {
            //$barcode = str_replace("*", "", $barcode);

            $order = Order::where('barcode', '=', $barcode)->first();
            if ($order != null) {
                return redirect()->action('m\OrderController@edit', ['id' => $order->id]);
            }
        }


        $order = Order::find($order_id);
        $result = $order->addBarCode($barcode);


        $errorBarCode = $result['error'];
        $errorMessage = $result['errorMessage'];

        if ($errorBarCode) {
            return redirect()->back()->withErrors(['errorMessage' => $errorMessage]);
        }

        return redirect()->action('m\OrderController@edit', ['id' => $order_id]);
    }

}
