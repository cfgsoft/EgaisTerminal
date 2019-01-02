<?php

namespace App\Http\Controllers\api\v1;

use App\Incoming;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incoming = Incoming::with('incominglines')
            ->orderBy('number', 'desc')
            ->paginate(50);

        return $incoming;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function show(Incoming $incoming)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function edit(Incoming $incoming)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incoming $incoming)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incoming $incoming)
    {
        //
    }
}
