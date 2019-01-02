<?php

namespace App\Models\ReturnedInvoice;

use Illuminate\Database\Eloquent\Model;

class ReturnedInvoice extends Model
{
    protected $table = 'doc_returned_invoice';

    protected $fillable = ['date', 'number', 'barcode', 'status',
        'quantity', 'quantity_marks', 'doc_type', 'doc_id'];

    public function returnedInvoiceLines(){
        return $this->hasMany("App\Models\ReturnedInvoice\ReturnedInvoiceLine");
    }

    public function returnedInvoiceMarkLines(){
        return $this->hasMany("App\Models\ReturnedInvoice\ReturnedInvoiceMarkLine");
    }

    public function returnedInvoicePackLines(){
        return $this->hasMany("App\Models\ReturnedInvoice\ReturnedInvoicePackLine");
    }

    public function returnedInvoiceErrorLines(){
        return $this->hasMany("App\Models\ReturnedInvoice\ReturnedInvoiceErrorLine");
    }

    public function addExciseStamp($barcode)
    {
        //$post = new static;
        //$post->fill($fields);
        //$post->user_id = Auth::user()->id;
        //$post->save();

        //return $post;
    }

    public function addPackExciseStamp($barcode)
    {


    }
}
