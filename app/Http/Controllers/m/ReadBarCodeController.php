<?php

namespace App\Http\Controllers\m;

use App\ReadBarCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    public function index()
    {
        $barcode = ReadBarCode::orderBy("created_at", 'desc') //'asc'
                                ->take(10)->get();

        return view('m\readbarcode\index',["barcode" => $barcode]);
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

        if (isset($barcode)) {
            $newbarbode = new ReadBarCode;
            $newbarbode->barcode = $barcode;
            $newbarbode->save();
        }

        return redirect()->action('m\ReadBarCodeController@index');
    }
}
