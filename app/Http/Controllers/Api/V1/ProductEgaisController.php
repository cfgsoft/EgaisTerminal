<?php

namespace App\Http\Controllers\api\v1;

use App\Models\RefEgais\ProductEgais;
use App\Http\Requests\StoreProductEgais;
use App\Http\Requests\StoreProductEgaisBatch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductEgaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductEgais $request)
    {
        $newProduct = $request->all();

        $product = ProductEgais::updateOrCreate(['code' => $newProduct["code"]], $newProduct);

        return $product;
    }

    public function storeBatch(StoreProductEgaisBatch $request)
    {
        $result = [];
        $newProducts = $request->all();

        foreach($newProducts['items'] as $newProduct) {
            $result[] = ProductEgais::updateOrCreate(['code' => $newProduct["code"]], $newProduct);
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RefEgais\ProductEgais  $productEgais
     * @return \Illuminate\Http\Response
     */
    public function show(ProductEgais $productEgais)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RefEgais\ProductEgais  $productEgais
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductEgais $productEgais)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RefEgais\ProductEgais  $productEgais
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductEgais $productEgais)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RefEgais\ProductEgais  $productEgais
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductEgais $productEgais)
    {
        //
    }
}
