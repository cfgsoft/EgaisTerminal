<?php

namespace App\Http\Controllers\m;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    public function login()
    {
        return view('m/auth/login');
    }

    public function submitbarcode(Request $request)
    {
        //dd($request->all());

        $this->validate($request, [
            'BarCode' => 'required'
        ]);

        echo 'ok';

        $barcode = $request->input('BarCode', '');

        if ($barcode == '0') {
            return redirect()->action('m\HomeController@index');
        } elseif ($barcode == '1') {
            //Prev
            //dd($request);
        } elseif ($barcode == '3') {
            //Next
        }

        /*
        if (strlen($barcode) > 8 and strlen($barcode) < 13) {
            $barcode = str_replace("*", "", $barcode);
            //$barcode = str_replace("C", "С", $barcode);
            //$barcode = substr($barcode, 0, 4) . '_' . substr($barcode, 4);
            //$order = Order::where('number', '=', $barcode)->first();

            $order = Order::where('barcode', '=', $barcode)->first();

            if ($order != null) {
                return redirect()->action('m\OrderController@edit', ['id' => $order->id]);
            }
        }

        $barcode = 'Не найден заказ №' . $barcode;

        return redirect()->action('m\OrderController@index', ['barcode' => $barcode]);
        */

        return redirect()->action('m\HomeController@index');
    }
}
