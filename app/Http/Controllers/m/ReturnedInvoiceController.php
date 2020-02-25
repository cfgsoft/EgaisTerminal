<?php

namespace App\Http\Controllers\m;

use App\Models\ReturnedInvoice\ReturnedInvoice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

class ReturnedInvoiceController extends Controller
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
        $returnedInvoice= ReturnedInvoice::orderBy("id", 'desc')->simplePaginate(4);

        $barcode = $request->input('barcode', '');

        return view('m/returnedinvoice/index', ['returnedInvoice' => $returnedInvoice, 'barcode' => $barcode]);
    }

    public function edit(Request $request, $id)
    {
        $returnedInvoice = ReturnedInvoice::find($id);
        if ($returnedInvoice == null)
        {
            return redirect()->action('m\ReturnedInvoiceController@index');
            //abort(404, 'Страница не найдена');
        }
        $returnedInvoice->returnedInvoicelines;
        $returnedInvoice->returnedInvoicelines = $returnedInvoice->returnedInvoicelines->sortBy('lineid')->sortByDesc('show_first');

        $errorMessage = '';
        if ($request->has('errorMessage')) {
            $errorMessage = $request->get('errorMessage');
        }

        return view('m/returnedinvoice/edit', ['returnedInvoice' => $returnedInvoice, 'errorMessage' => $errorMessage]);
    }

    public function submitbarcode(Request $request)
    {
        $barcode = $request->input('BarCode', '');
        if ($barcode == '0') {
            return redirect()->action('m\HomeController@index');
        }

        /*
        $this->validate($request,
            ['BarCode'	=>
                ['required',
                    'min:9',
                    'max:12',
                    Rule::exists('doc_returned_invoice')->where(function ($query) use ($barcode) {
                        $query->where('barcode', $barcode);
                    }) ]
            ]
            ,
            ['BarCode.required' => 'Заполните ШК',
                'BarCode.min'      => 'ШК минимум 9 символов',
                'BarCode.max'      => 'ШК максимум 12 символов',
                'BarCode.exists'   => 'Не найден заказ № ' . $request->input('BarCode', '')
            ]
        );
        */

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

        if (strlen($barcode) > 8 and strlen($barcode) < 13) {
            $barcode = str_replace("*", "", $barcode);
        }

        $returnedInvoice = ReturnedInvoice::where('barcode', '=', $barcode)->first();
        if ($returnedInvoice != null) {
            return redirect()->action('m\ReturnedInvoiceController@edit', ['id' => $returnedInvoice->id]);
        } else {
            //return redirect()->action('m\ReturnedInvoiceController@index');
            return redirect()->back()->withErrors(['Не найден заказ по ШК ' . $barcode]);
        }

        //https://laravel-news.com/custom-validation-rule-objects
        /*
        Работающий код
        $this->validate($request,
            ['BarCode'	=>
                ['required',
                    'min:9',
                    'max:12',
                    function ($attribute, $value, $fail) {
                        if ($value == '222222222') {
                            $fail(':attribute needs more cowbell!');
                        }
                    }
                ]
            ]
            ,
            ['BarCode.required' => 'Заполните ШК',
             'BarCode.exists'   => 'Не найден заказ № ' . $request->input('BarCode', '')
            ]
        );

        if (strlen($barcode) > 8 and strlen($barcode) < 13)
        {
            $barcode = str_replace("*", "", $barcode);
            $returnedInvoice = ReturnedInvoice::where('barcode', '=', $barcode)->first();

            if ($returnedInvoice != null) {
                return redirect()->action('m\ReturnedInvoiceController@edit', ['id' => $returnedInvoice->id]);
            }
        }

        $barcode = 'Не найден заказ №' . $barcode;
        return redirect()->action('m\ReturnedInvoiceController@index', ['barcode' => $barcode]);
        */
    }

    public function submiteditbarcode(Request $request)
    {
        $barcode             = $request->input('BarCode', '');
        $returned_invoice_id = $request->input('returned_invoice_id', '');

        if ($barcode == '0') {
            return redirect()->action('m\ReturnedInvoiceController@index');
        }

        $this->validate($request,
            ['BarCode'	=>
                ['required',
                 'min:26',
                 'max:150',
                ]
            ]
            ,
            ['BarCode.required' => 'Не считан ШК акцизной марки',
             'BarCode.min'      => 'ШК минимум 26 символов',
             'BarCode.max'      => 'ШК максимум 150 символов'
            ]
        );

        if (strlen($barcode) > 0) {
            $returnedInvoice = ReturnedInvoice::find($returned_invoice_id);
            $result = $returnedInvoice->addBarCode($barcode);

            $errorBarCode = $result['error'];
            $errorMessage = $result['errorMessage'];

            if ($errorBarCode) {
                //return redirect()->action('m\ReturnedInvoiceController@edit', ['id' => $returned_invoice_id, 'errorMessage' => $errorMessage]);
                return redirect()->back()->withErrors(['errorMessage' => $errorMessage]);
            }
        }

        return redirect()->action('m\ReturnedInvoiceController@edit', ['id' => $returned_invoice_id]);
    }

}
