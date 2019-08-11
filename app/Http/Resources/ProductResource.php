<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //https://scotch.io/tutorials/laravel-eloquent-api-resources#toc-prerequisites-
        //https://stackoverflow.com/questions/49494472/laravel-eloquent-resource-collection-response

        /*
        switch ($request->view) {
            case 'datatable':
                self::withoutWrapping();
                return DataTables::of($this->collection)->make(true);
        }
        return parent::toArray($request);
        */

        self::withoutWrapping();

        return [
            'id' => $this->id,
            'descr' => $this->descr,
            'code' => $this->code,
        ];
    }
}
