<?php

namespace App\Http\Controllers\api\v1;

use App\Models\RefEgais\TransportModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransportModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        header('Access-Control-Allow-Origin: *');

        $transportModules = TransportModule::orderBy("descr");

        return response()->json($transportModules->paginate(50));
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
        $newModule = $request->all();

        $transportModule = TransportModule::updateOrCreate(['code' => $newModule["code"]], $newModule);

        return $transportModule;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RefEgais\TransportModule  $transportModule
     * @return \Illuminate\Http\Response
     */
    public function show(TransportModule $transportModule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RefEgais\TransportModule  $transportModule
     * @return \Illuminate\Http\Response
     */
    public function edit(TransportModule $transportModule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RefEgais\TransportModule  $transportModule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransportModule $transportModule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RefEgais\TransportModule  $transportModule
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransportModule $transportModule)
    {
        //
    }
}
