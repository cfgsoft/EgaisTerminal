<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceLine;

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
        $invoice = Invoice::with('invoiceLines')
            ->orderBy('number', 'desc')
            ->paginate(50);

        return $invoice;
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
        $newInvoice = $request->all();

        $invoice = Invoice::where('doc_id', $newInvoice['doc_id'])->first();
        if ($invoice == null) {
            $invoice = Invoice::add($newInvoice);
            $invoice->save();
        } else {
            $invoice->edit($newInvoice);
            //$invoice->setCategory($request->get('category_id'));
            $invoice->save();
        }

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

        return $invoice;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
