<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceMarkLineResource extends JsonResource
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
            'mark_code' => $this->mark_code,
        ];
    }
}
