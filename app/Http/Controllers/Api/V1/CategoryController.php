<?php

namespace App\Http\Controllers\api\v1;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$request->user()->authorizeRoles('AdminApi');

        header('Access-Control-Allow-Origin: *');

        $category = Category::orderBy("descr");

        if ($request->has('parent_id')) {
            $category = $category->where('parent_id', $request->get('parent_id'));
        } else {
            $category = $category->where('parent_id', 0);
        }

        return $category->paginate(20);

        //$cats = Category::all();
        //return response()->json($cats);


        //$code = "S650000006";
        //$bdCategory = Category::where("code", $code)->first();

        //if ($bdCategory == null) {

        //} else {

        //}
        //return response()->json($bdCategory);

        //return response()->json(["data" => $cats, "status" => 1]);

        //$category = Category::latest()->paginate();
        //return $category;    
    }

    public function indexAll()
    {
        //$request->user()->authorizeRoles('AdminApi');

        header('Access-Control-Allow-Origin: *');

        $category = Category::all();

        return $category;
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

        $category = Category::updateOrCreate([ "code" => $newCategory["code"]], $newCategory );

        /*
        $category = Category::where("code", $newCategory["code"])->first();
        if ($category == null) {
            $category = Category::create($newCategory);
        } else {
            //$category = Category::findOrFail($category->id);
            //$category->update($newCategory);

            $category->update($newCategory);
        }
        */

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
