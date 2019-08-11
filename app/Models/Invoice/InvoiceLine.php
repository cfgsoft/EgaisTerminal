<?php

namespace App\Models\Invoice;

use App\Product;
use App\Models\RefEgais\ProductEgais;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    protected $table = 'doc_invoice_line';

    protected $fillable = ['line_id', 'line_identifier', 'product_descr', 'f1reg_id', 'f2reg_id',
        'quantity', 'quantity_pack', 'quantity_pallet'];

    public function invoice(){
        return $this->belongsTo("App\Models\Invoice\Invoice");
    }

    public function product(){
        return $this->belongsTo("App\Product");
    }

    public function product_egais(){
        return $this->belongsTo("App\Models\RefEgais\ProductEgais");
    }

    public function setProduct($id)
    {
        if($id == null) {return;}
        $this->product_id = $id;
    }

    public function setProductEgais($id)
    {
        if($id == null) {return;}
        $this->product_egais_id = $id;
    }

    public function setReference($fields)
    {
        if (array_key_exists('product_code', $fields))
        {
            $product = Product::where('code', $fields['product_code'])->first();
            if ($product != null) {$this->setProduct($product->id);}
        }

        if (array_key_exists('product_egais_code', $fields))
        {
            $productEgais = ProductEgais::where('code', $fields['product_egais_code'])->first();
            if ($productEgais != null) {$this->setProductEgais($productEgais->id);}
        }
    }
}
