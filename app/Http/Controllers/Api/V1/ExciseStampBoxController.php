<?php

namespace App\Http\Controllers\api\v1;

use App\ExciseStampBox;
use App\ExciseStampBoxLine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExciseStampBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        header('Access-Control-Allow-Origin: *');

        $exciseStampBox = ExciseStampBox::orderBy("id");

        return $exciseStampBox->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return 'OK';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newExciseStampBox = $request->all();

        $exciseStampBox = ExciseStampBox::where('barcode', $newExciseStampBox['barcode'])->first();
        if ($exciseStampBox == null) {
            $exciseStampBox = ExciseStampBox::create($newExciseStampBox);
        } else {
            //$exciseStampBox->update($newExciseStampBox);
        }

        ExciseStampBoxLine::where('excise_stamp_box_id', '=', $exciseStampBox->id)->delete();

        $lines = $newExciseStampBox['lines'];
        foreach ($lines as $line){
            $newLine = new ExciseStampBoxLine();
            $newLine->excise_stamp_box_id = $exciseStampBox->id;
            $newLine->markcode = $line['markcode'];
            $newLine->Save();
        }

        return $exciseStampBox;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExciseStampBox  $exciseStampBox
     * @return \Illuminate\Http\Response
     */
    public function show(ExciseStampBox $exciseStampBox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExciseStampBox  $exciseStampBox
     * @return \Illuminate\Http\Response
     */
    public function edit(ExciseStampBox $exciseStampBox)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExciseStampBox  $exciseStampBox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExciseStampBox $exciseStampBox)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExciseStampBox  $exciseStampBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExciseStampBox $exciseStampBox)
    {
        //
    }
}
