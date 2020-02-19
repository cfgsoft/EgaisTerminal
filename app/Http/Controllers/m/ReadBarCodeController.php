<?php

namespace App\Http\Controllers\m;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ReadBarCode;

class ReadBarCodeController extends mController
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
        $result = parent::submitbarcode($request);
        if ($result != null) return $result;

        $result = ReadBarCode::add($this->barcode);
        return $result;
    }
}
