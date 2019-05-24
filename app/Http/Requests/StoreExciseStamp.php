<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExciseStamp extends FormRequest
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
            'barcode'	  =>	'required',
            'productcode' =>	'required',
            'f1regid'     =>	'required',
            'f2regid'     =>	'required',
            'department_code' => 'required',
            'department_id'   => 'filled'
        ];
    }
}
