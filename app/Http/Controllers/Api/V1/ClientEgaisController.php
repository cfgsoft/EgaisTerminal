<?php

namespace App\Http\Controllers\api\v1;

use App\Models\RefEgais\ClientEgais;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientEgaisController extends Controller
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
    public function store(Request $request)
    {
        $newClient = $request->all();

        $client = ClientEgais::updateOrCreate(['code' => $newClient["code"]], $newClient);

        return $client;
    }

    public function storeBatch(Request $request)
    {
        $result = [];
        $newClients = $request->all();

        foreach($newClients['items'] as $newClient) {
            $result[] = ClientEgais::updateOrCreate(['code' => $newClient["code"]], $newClient);
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RefEgais\ClientEgais  $clientEgais
     * @return \Illuminate\Http\Response
     */
    public function show(ClientEgais $clientEgais)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RefEgais\ClientEgais  $clientEgais
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientEgais $clientEgais)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RefEgais\ClientEgais  $clientEgais
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientEgais $clientEgais)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RefEgais\ClientEgais  $clientEgais
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientEgais $clientEgais)
    {
        //
    }
}
