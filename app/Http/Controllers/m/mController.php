<?php

namespace App\Http\Controllers\m;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class mController extends Controller
{
    public $barcode;

    protected function menuAction()
    {
        if ($this->barcode == '0') {
            return redirect()->action('m\HomeController@index');
        } elseif ($this->barcode == '1') {
            //Prev
            //dd($request);
        } elseif ($this->barcode == '3') {
            //Next
        }
    }

    public function submitbarcode_new(Request $request)
    {
        $this->barcode = $request->input('BarCode', '');

        $this->menuAction();
    }
}
