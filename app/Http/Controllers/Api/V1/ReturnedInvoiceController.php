<?php

namespace App\Http\Controllers\api\v1;

use App\Models\ReturnedInvoice\ReturnedInvoice;
use App\Models\ReturnedInvoice\ReturnedInvoiceLine;
use App\Models\ReturnedInvoice\ReturnedInvoiceMarkLine;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReturnedInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returnedInvoice = ReturnedInvoice::with('returnedInvoiceLines')
            ->orderBy('number', 'desc')
            ->paginate(50);

        return $returnedInvoice;
    }

    public function indexMarkLine()
    {
        $returnedInvoice = ReturnedInvoiceMarkLine::where('savedin1c', '=', false)->orderBy('returned_invoice_id')->get();

        return response()->json($returnedInvoice);
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
        $newReturnedInvoice = $request->all();

        $returnedInvoice = ReturnedInvoice::where('doc_id', $newReturnedInvoice['doc_id'])->first();
        if ($returnedInvoice == null) {
            $returnedInvoice = ReturnedInvoice::create($newReturnedInvoice);
        } else {
            $returnedInvoice->date     = $newReturnedInvoice['date'];
            $returnedInvoice->barcode  = $newReturnedInvoice['barcode'];
            $returnedInvoice->doc_type = $newReturnedInvoice['doc_type'];
            $returnedInvoice->doc_id   = $newReturnedInvoice['doc_id'];
            $returnedInvoice->Save();
        }

        //Обнуляем количество, загружаем повторно
        ReturnedInvoiceLine::where('returned_invoice_id', '=', $returnedInvoice->id)->update(['quantity' => 0]);

        $oldReturnedInvoiceLines = $returnedInvoice->returnedInvoiceLines;

        //Добавляем новые записи, изменяем существующее количество
        $returnedInvoicesLinesLines = $newReturnedInvoice['ReturnedInvoicesLines'];
        foreach ($returnedInvoicesLinesLines as $line){
            $oldReturnedInvoiceLine = $oldReturnedInvoiceLines->firstWhere('f2regid', $line['F2RegId']);

            if ($oldReturnedInvoiceLine == null) {
                //add
                $newReturnedInvoiceLine = new ReturnedInvoiceLine();
                $newReturnedInvoiceLine->lineid         = $line['OrderLineId'];
                $newReturnedInvoiceLine->productdescr   = $line['ProductDescr'];
                $newReturnedInvoiceLine->productcode    = $line['ProductCode'];
                $newReturnedInvoiceLine->f1regid        = $line['F1RegId'];
                $newReturnedInvoiceLine->f2regid        = $line['F2RegId'];
                $newReturnedInvoiceLine->quantity       = $line['Quantity'];
                $newReturnedInvoiceLine->returned_invoice_id = $returnedInvoice->id;
                $newReturnedInvoiceLine->show_first          = 0;
                $newReturnedInvoiceLine->Save();
            } else {
                //update
                if ($oldReturnedInvoiceLine->quantity != $line['Quantity']) {
                    $oldReturnedInvoiceLine->quantity  = $line['Quantity'];
                    $oldReturnedInvoiceLine->Save();
                }
            }
        }

        return $returnedInvoice;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReturnedInvoice  $returnedInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(ReturnedInvoice $returnedInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReturnedInvoice  $returnedInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturnedInvoice $returnedInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReturnedInvoice  $returnedInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReturnedInvoice $returnedInvoice)
    {
        //
    }

    public function updateMarkLine(Request $request, $id)
    {
        $returnedInvoiceMarkLine = ReturnedInvoiceMarkLine::findOrFail($id);
        $returnedInvoiceMarkLine->savedin1c = true;
        $returnedInvoiceMarkLine->save();

        return $returnedInvoiceMarkLine;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReturnedInvoice  $returnedInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturnedInvoice $returnedInvoice)
    {
        //
    }
}
