<?php

namespace App\Http\Controllers\m;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ReadBarCode;
use App\ExciseStamp;
use App\ExciseStampBox;

class ReadBarCodeController extends Controller
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
        $barcode = ReadBarCode::orderBy("created_at", 'desc') //'asc'
                                ->take(10)->get();

        return view('m/readbarcode/index',['barcode' => $barcode]);

        //test token
        //$result = $request->session()->all();//получаем данные из сессии
        //$token = $result['_token'];

        //return view('m/readbarcode/index',['barcode' => $barcode, 'token' => $token]);
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

        ReadBarCode::add($barcode);

        return redirect()->action('m\ReadBarCodeController@index');
    }

    public function submitbarcodeajax(Request $request)
    {
        if ($request->has('BarCode')) {
            $barcode = $request->get('BarCode');

            if ($barcode == '0') {
                return redirect()->action('m\HomeController@index');
            }

            $newbarcode = ReadBarCode::add($barcode);

            return $newbarcode;
        }
    }
}
