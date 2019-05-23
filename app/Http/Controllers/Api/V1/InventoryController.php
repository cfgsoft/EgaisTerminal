<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Inventory\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        header('Access-Control-Allow-Origin: *');

        $inventory = Inventory::orderBy('id', 'desc');

        if ($request->has('department_id')) {
            $inventory = $inventory->where('department_id', $request->get('department_id'));
        }

        $perPage = (integer)$request->get('per_page', 20);

        return $inventory->paginate($perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'	 =>	'required',
            'number' =>	'required',
            'department_id' =>	'required'
        ]);

        $newInventory = $request->all();

        $inventory = Inventory::add($newInventory);

        return $inventory;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
		header('Access-Control-Allow-Origin: *');
		
        //GET
        $inventory->inventoryLines;
        $inventory->inventoryMarkLines;

        return $inventory;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {		
        //PUT
        $newInventory = $request->all();

        //if (array_key_exists('marklines', $newInvoice))
        //{
        //    $newMarkInvoicesLines = $newInvoice['marklines'];
        //    foreach ($newMarkInvoicesLines as $line) {
        //        $invoiceMarkLine = InvoiceMarkLine::where([['invoice_id', '=', $invoice->id],['mark_code', '=', $line['mark_code']]])->first();
        //        if ($invoiceMarkLine == null) {
        //            $invoiceMarkLine = InvoiceMarkLine::add($line, $invoice);
        //        } else {
        //            $invoiceMarkLine->edit($line);
        //        }
        //    }
        //}

        return $inventory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
