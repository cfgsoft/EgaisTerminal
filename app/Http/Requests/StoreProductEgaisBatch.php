<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductEgaisBatch extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'items' =>'required|array|min:1|max:1000',
                'items.*.descr'     => 'required|string',
                'items.*.code'      => 'required|string',
                'items.*.capacity'  => 'required',
                'items.*.alc_volume'     => 'required',
                'items.*.product_v_code' => 'required',
                'items.*.version'        => 'required|string'
        ];

        /*
        return [
            '*.descr'	       => 'required',
            '*.code'           => 'required',
            '*.capacity'       => 'required',
            '*.alc_volume'     => 'required',
            '*.product_v_code' => 'required',
            '*.version'        => 'required'
        ];
        */
    }
}
