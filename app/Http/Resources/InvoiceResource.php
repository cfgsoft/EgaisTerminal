<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        self::withoutWrapping();

        return [
            'id' => $this->id,
            'date' => $this->date,
            'number' => $this->number,
            'shipper' => new ClientEgaisResource($this->shipper),
            'consignee' => new ClientEgaisResource($this->consignee),
            'invoiceLines' => new InvoiceLineResourceCollection($this->invoiceLines),
            'invoiceMarkLines' => new InvoiceMarkLineResourceCollection($this->invoiceMarkLines),
        ];
    }
}
