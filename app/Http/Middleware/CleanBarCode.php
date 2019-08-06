<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class CleanBarCode extends TransformsRequest
{
    //https://code.tutsplus.com/ru/tutorials/understand-the-basics-of-laravel-middleware--cms-29147
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    /*
    public function handle($request, Closure $next)
    {
        dd($request->request);

        if ($request->request->has('BarCode')) {
            $barcode = $request->get('BarCode');

            if (strlen($barcode) > 8 and strlen($barcode) < 13) {
                $barcode = str_replace('*', '', $barcode);

                //$request->barcode = $barcode;
            }
        }

        return $next($request);
    }
    */


    /**
     * The attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if ($key == 'BarCode') {
            if (strlen($value) > 8 and strlen($value) < 13) {
                $value = str_replace('*', '', $value);
                return $value;
            }
        }

        return $value;

        //if (in_array($key, $this->except, true)) {
        //    return $value;
        //}
        //
        //return is_string($value) ? trim($value) : $value;
    }
}
