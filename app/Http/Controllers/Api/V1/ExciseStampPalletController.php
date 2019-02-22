<?php

namespace App\Http\Controllers\api\v1;

use App\Models\ExciseStamp\ExciseStampPallet;
use App\Models\ExciseStamp\ExciseStampPalletLine;
use App\ExciseStampBox;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ExciseStampPalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        header('Access-Control-Allow-Origin: *');

        $exciseStampPallet = ExciseStampPallet::orderBy("id");

        return $exciseStampPallet->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $newExciseStampPallet = $request->all();

        $exciseStampPallet = ExciseStampPallet::where('barcode', $newExciseStampPallet['barcode'])->first();
        if ($exciseStampPallet == null) {
            $exciseStampPallet = ExciseStampPallet::create($newExciseStampPallet);
        } else {

        }

        DB::beginTransaction();

        try{

            ExciseStampPalletLine::where('pallet_id', '=', $exciseStampPallet->id)->delete();

            $lines = $newExciseStampPallet['lines'];
            foreach ($lines as $line){

                $exciseStampBox = ExciseStampBox::where('barcode', $line['markcode'])->first();
                //if ($exciseStampBox != null)
                //{
                    $newLine = new ExciseStampPalletLine();
                    $newLine->pallet_id = $exciseStampPallet->id;
                    $newLine->box_id =  $exciseStampBox->id;
                    $newLine->Save();
                //}
            }

            DB::commit();

        } catch(\Exception $exception){

            DB::rollback();
        }

        return $exciseStampPallet;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExciseStamp\ExciseStampPallet  $exciseStampPallet
     * @return \Illuminate\Http\Response
     */
    public function show(ExciseStampPallet $exciseStampPallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExciseStamp\ExciseStampPallet  $exciseStampPallet
     * @return \Illuminate\Http\Response
     */
    public function edit(ExciseStampPallet $exciseStampPallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExciseStamp\ExciseStampPallet  $exciseStampPallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExciseStampPallet $exciseStampPallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExciseStamp\ExciseStampPallet  $exciseStampPallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExciseStampPallet $exciseStampPallet)
    {
        //
    }
}
