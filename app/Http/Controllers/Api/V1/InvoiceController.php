<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceMarkLine;
use App\Models\RefEgais\ClientEgais;

use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoiceResourceCollection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GET
        $invoice = Invoice::with('invoiceLines')
            ->orderBy('number', 'desc')
            ->paginate(50);

        return $invoice;
    }

    public function indexReadLine()
    {
        $invoiceReadLine = InvoiceReadLine::where('savedin1c', '=', false)->orderBy('invoice_id')->get();

        return response()->json($invoiceReadLine);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST
        $newInvoice = $request->all();

        $invoice = Invoice::where('doc_id', $newInvoice['doc_id'])->first();
        if ($invoice == null) {
            $invoice = Invoice::add($newInvoice);
        } else {
            $invoice->edit($newInvoice);
        }
        $invoice->save();


        if (array_key_exists('lines', $newInvoice))
        {
            $invoice->deleteLines();
            $newInvoicesLines = $newInvoice['lines'];
            foreach ($newInvoicesLines as $line) {
                $invoice->addLines($line);
            }
        }

        if (array_key_exists('marklines', $newInvoice))
        {
            $invoice->deleteMarkLines();
            $newMarkInvoicesLines = $newInvoice['marklines'];
            foreach ($newMarkInvoicesLines as $line) {
                $invoice->addMarkLines($line);
            }
        }

        if (array_key_exists('packlines', $newInvoice))
        {
            $invoice->deletePackLines();
            $newPackInvoicesLines = $newInvoice['packlines'];
            foreach ($newPackInvoicesLines as $line) {
                $invoice->addPackLines($line);
            }
        }

        if (array_key_exists('palletlines', $newInvoice))
        {
            $invoice->deletePalletLines();
            $newPalletInvoicesLines = $newInvoice['palletlines'];
            foreach ($newPalletInvoicesLines as $line) {
                $invoice->addPalletLines($line);
            }
        }

        return $invoice;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //GET
        return Invoice::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //PUT
        $newInvoice = $request->all();

        if (array_key_exists('marklines', $newInvoice))
        {
            $newMarkInvoicesLines = $newInvoice['marklines'];
            foreach ($newMarkInvoicesLines as $line) {
                $invoiceMarkLine = InvoiceMarkLine::where([['invoice_id', '=', $invoice->id],['mark_code', '=', $line['mark_code']]])->first();
                if ($invoiceMarkLine == null) {
                    $invoiceMarkLine = InvoiceMarkLine::add($line, $invoice);
                } else {
                    $invoiceMarkLine->edit($line);
                }

            }
        }

        return $invoice;
    }

    public function updateMarkLine(Request $request, $id)
    {
        //PUT

        $invoiceReadLine = InvoiceReadLine::findOrFail($id);
        $invoiceReadLine->savedin1c = true;
        $invoiceReadLine->save();

        return $invoiceReadLine;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //DELETE
        //
    }


    //region Lic

    public function indexLic(Request $request, $consignee_code)
    {
        $clientEgais = ClientEgais::where('code', '=', $consignee_code)->first();

        if ($clientEgais == null) {
            return abort('404');
        }

        $invoice = Invoice::with('shipper', 'consignee', 'invoiceLines', 'invoiceLines.product', 'invoiceLines.product_egais', 'invoiceMarkLines')
            ->where([['consignee_id','=', $clientEgais->id], ['savedin1c','=', 0]])
            ->orderBy("id", 'desc');

        return new InvoiceResourceCollection( $invoice->paginate(10) );
    }

    public function showLic(Request $request, $consignee_code, $id)
    {
        //GET
        $invoice = Invoice::findOrFail($id);

        return new InvoiceResource($invoice);
    }

    public function updateLic(Request $request, $consignee_code, $id)
    {
        $clientEgais = ClientEgais::where('code', '=', $consignee_code)->first();

        if ($clientEgais == null) {
            return abort('404', 'Resource item not found.');
        }

        $invoice = Invoice::where([['consignee_id','=', $clientEgais->id], ['id','=', $id]])->first();

        if ($invoice == null) {
            return abort('404', 'Resource item not found.');
        }

        return $invoice->SavedIn1c();
    }

    //endregion
}
