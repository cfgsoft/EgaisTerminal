<?php

namespace App\Http\Controllers\m;

use Illuminate\Http\Request;

use App\ReadBarCode;
use App\Services\ReadBarCodeService;

class ReadBarCodeController extends mController
{
    protected $validateNumberDoc = false;
    protected $readBarCodeService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReadBarCodeService $readBarCodeService)
    {
        $this->readBarCodeService = $readBarCodeService;

        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barcode = $this->readBarCodeService->get();

        //$barcode = ReadBarCode::orderBy("created_at", 'desc') //'asc'
        //                        ->take(10)->get();

        return view('m/readbarcode/index',['barcode' => $barcode]);       
    }

    public function submitbarcode_new(Request $request)
    {
        return ReadBarCode::add($this->barcode());
    }
}
