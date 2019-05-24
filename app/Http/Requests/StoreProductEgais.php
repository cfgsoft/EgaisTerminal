<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductEgais extends FormRequest
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
            'descr'	         =>	'required',
            'code'           =>	'required',
            'capacity'       =>	'required',
            'alc_volume'     =>	'required',
            'product_v_code' => 'required',
            'version'        => 'required'
        ];
    }
}
