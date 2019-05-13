<?php

namespace App\Http\Controllers\m;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Inventory\Inventory;
use App\Models\Inventory\InventoryMarkLine;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inventory = Inventory::orderBy("id", 'desc')->simplePaginate(4);

        $barcode = $request->input('barcode', '');

        return view('m/inventory/index', ['inventory' => $inventory, 'barcode' => $barcode]);
    }

    public function create(Request $request)
    {
        $date = Carbon::now();
        $number = '1';

        return view('m/inventory/create', ['date' => $date, 'number' => $number]);
    }

    public function store(Request $request)
    {
        //dd($request);

        $this->validate($request, [
            'date'	 =>	'required',
            'number' =>	'required'
        ]);

        Inventory::add($request->all());

        return redirect()->route('m.inventory');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $inventory = Inventory::find($id);
        if ($inventory == null)
        {
            return redirect()->action('m\InventoryController@index');
        }
        $inventory->inventoryLines;
        $inventory->inventoryLines = $inventory->inventoryLines->sortBy('id')->sortByDesc('show_first');

        $f2reg_id = null;
        $order_id = null;
        if ($request->session()->has('inventory')) {
            $currentInventory = $request->session()->get('inventory');

            $barcode = $currentInventory['barcode'];

            $inventoryMarkLine = InventoryMarkLine::where( [['inventory_id', '=', $id],['mark_code', '=', $barcode]] )->first();
            if ($inventoryMarkLine != null)
            {
                $order_id = $inventoryMarkLine->order_id;
                $f2reg_id = $inventoryMarkLine->f2reg_id;
            }
        }

        return view('m/inventory/edit', ['inventory' => $inventory, 'order_id' => $order_id, 'f2reg_id' => $f2reg_id]);
    }

    public function submitbarcode(Request $request)
    {
        $barcode = $request->input('BarCode', '');

        if ($barcode == '0') {
            return redirect()->action('m\HomeController@index');
        } else if ($barcode == '1') {
            return redirect()->action('m\InventoryController@create');
        }

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

        /*
        $inventory = Inventory::where('barcode', '=', $barcode)->first();
        if ($inventory != null) {
            return redirect()->action('m\InventoryController@edit', ['id' => $inventory->id]);
        } else {
            return redirect()->back()->withErrors(['BarCode' => 'Не найдена инвентаризация № ' . $barcode]);
        }
        */
    }

    public function submiteditbarcode(Request $request)
    {
        $barcode  = $request->input('BarCode', '');
        $inventory_id = $request->input('inventory_id', '');

        if ($barcode == '0') {
            return redirect()->action('m\InventoryController@index');
        }

        $this->validate($request,
            ['BarCode'	=>
                ['required',
                    'min:9',
                    'max:150',
                ]
            ]
            ,
            ['BarCode.required' => 'Заполните ШК',
                'BarCode.min'      => 'ШК минимум 9 символов',
                'BarCode.max'      => 'ШК максимум 150 символов'
            ]
        );

        $inventory = Inventory::find($inventory_id);
        $result = $inventory->addBarCode($barcode);

        $errorBarCode = $result['error'];
        $errorMessage = $result['errorMessage'];

        if ($errorBarCode) {
            return redirect()->back()->withErrors(['errorMessage' => $errorMessage]);
        }

        $inventorySession = ['inventoryId' => $inventory_id,
                             'barcode'     => $barcode];

        //$request->session()->put('inventory', $inventorySession);
        $request->session()->flash('inventory', $inventorySession);

        return redirect()->action('m\InventoryController@edit', ['id' => $inventory_id]);
    }
}
