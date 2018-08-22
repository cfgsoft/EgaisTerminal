<?php

namespace App\Http\Controllers\api\v1;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $code = "S650000006";
//        $bdCategory = Category::where("code", $code)->first();
//
//        if ($bdCategory == null) {
//
//        } else {
//
//        }
//
//        return response()->json($bdCategory);


        //return response()->json(["data" => $cats, "status" => 1]);

        //$category = Category::latest()->paginate();
        //return $category;

        $cats = Category::all();
        return response()->json($cats);
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
    public function store(Request $request)
    {
        $newCategory = $request->all();

        if (isset($newCategory["parent_code"])) {
            $parentCategory = Category::where("code", $newCategory["parent_code"])->first();
            if ($parentCategory != null) {
                $newCategory["parent_id"] = $parentCategory->id;
            }
        }

        $category = Category::where("code", $newCategory["code"])->first();
        if ($category == null) {
            $category = Category::create($newCategory);
        } else {
            //$category = Category::findOrFail($category->id);
            //$category->update($newCategory);

            $category->update($newCategory);
        }

        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Category::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return 'OK';
    }
}
