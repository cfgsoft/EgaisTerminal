<?php

namespace App\Http\Controllers\m;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class mController extends Controller
{
    private $barcode;

    protected $validateNumberDoc = true;
    protected $menuHotKeys = [];

    public function barcode()
    {
        return $this->barcode;
    }

    private function menuAction()
    {
        if ($this->barcode == '0') return redirect()->action('m\HomeController@index');

        if (array_key_exists($this->barcode, $this->menuHotKeys)) {

            $action = $this->menuHotKeys[$this->barcode];

            if ($action != null) {
                return redirect()->action($action);
            }
        }
    }

    private function validateNumberDoc(Request $request)
    {
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
    }

    abstract protected function submitbarcode_new(Request $request);

    public function submitbarcode(Request $request)
    {
        $this->barcode = $request->input('BarCode', '');

        $result = $this->menuAction();
        if ($result != null) return $result;

        if ($this->validateNumberDoc) $this->validateNumberDoc($request);

        $result = $this->submitbarcode_new($request);

        return $result;
    }
}
