<?php

namespace App\Http\Controllers\m;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class mController extends Controller
{
    public $barcode;

    protected function menuAction()
    {
        switch($this->barcode)
        {
            case '0': //Main Menu
                return redirect()->action('m\HomeController@index');
                break;
            case '1': //Prev
                return null;
                break;
            case '3': //Next
                return null;
                break;
        }

    }

    public function submitbarcode(Request $request)
    {
        $this->barcode = $request->input('BarCode', '');

        return $this->menuAction();
    }
}
