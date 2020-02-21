<?php

namespace App\Http\Controllers\m;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ReadBarCode;

class ReadBarCodeController extends mController
{
    protected $validateNumberDoc = false;

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
    }

    public function submitbarcode_new(Request $request)
    {
        return ReadBarCode::add($this->barcode());
    }
}
