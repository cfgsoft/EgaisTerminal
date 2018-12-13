<?php

namespace App\Http\Controllers\m;

use App\ReadBarCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        if (isset($barcode)) {
            $newbarbode = new ReadBarCode;
            $newbarbode->barcode = $barcode;

            //СКАНИРОВАНИЕ АКЦИЗНОЙ МАРКИ
            //101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI
            if (strlen($barcode) == 150 or strlen($barcode) == 68)
            {
                $exciseStamp = ExciseStamp::find($barcode);
                if ($exciseStamp != null) {
                    $newbarbode->productcode = $exciseStamp->productcode;
                    $newbarbode->f1regid = $exciseStamp->f1regid;
                    $newbarbode->f2regid = $exciseStamp->f2regid;
                }
            }

            //СКАНИРОВАНИЕ ЯЩИКА
            if (strlen($barcode) == 26)
            {
                $exciseStampBox = ExciseStampBox::where('barcode', '=', $barcode)->first();
                if ($exciseStampBox != null)
                {
                    $newbarbode->productcode = $exciseStampBox->productcode;
                    $newbarbode->f1regid = $exciseStampBox->f1regid;
                    $newbarbode->f2regid = $exciseStampBox->f2regid;
                }
            }

            $newbarbode->save();
        }

        return redirect()->action('m\ReadBarCodeController@index');
    }

    public function submitbarcodeajax(Request $request)
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
