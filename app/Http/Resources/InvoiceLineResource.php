<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceLineResource extends JsonResource
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
            'line_id' => $this->line_id,
            'line_identifier' => $this->line_identifier,
            'f1reg_id' => $this->f1reg_id,
            'f2reg_id' => $this->f2reg_id,
            'product' => new ProductResource($this->product),
            'product_egais' => new ProductEgaisResource($this->product_egais),
        ];
    }
}
