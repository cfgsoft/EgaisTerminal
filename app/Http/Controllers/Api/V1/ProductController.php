<?php

namespace App\Http\Controllers\api\v1;

use App\Product;
use App\Http\Resources\ProductResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		header('Access-Control-Allow-Origin: *');
		
        $products = Product::orderBy("descr");

        if ($request->has('category_id')) {
            $products = $products->where('category_id', $request->get('category_id'));
        }

        return response()->json($products->paginate(50));
    }		

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newProduct = $request->all();

        $product = Product::updateOrCreate(['code' => $newProduct["code"]], $newProduct);

        return $product;
    }

    public function storeBatch(Request $request)
    {
        $result = [];
        $newProducts = $request->all();

        foreach($newProducts['items'] as $newProduct) {
            $result[] = Product::updateOrCreate(['code' => $newProduct["code"]], $newProduct);
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
