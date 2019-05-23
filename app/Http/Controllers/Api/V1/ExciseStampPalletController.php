<?php

namespace App\Http\Controllers\api\v1;

use App\Models\ExciseStamp\ExciseStampPallet;
use App\Models\ExciseStamp\ExciseStampPalletLine;
use App\Models\ExciseStamp\ExciseStampBox;
use App\Department;

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
        $this->validate($request, [
            'barcode'	  =>	'required',
            'productcode' =>	'required',
            'f1regid'     =>	'required',
            'f2regid'     =>	'required',
            'department_code' => 'required',
            'department_id'   => 'filled'
        ]);

        $newExciseStampPallet = $request->all();

        $department_id =  null;
        if ($request->has('department_id')) {
            $department_id = $newExciseStampPallet["department_id"];
        } else {
            $department_code = $newExciseStampPallet["department_code"];
            $department = Department::where('code','=',$department_code)->first();

            if ($department != null){
                $department_id = $department->id;
                $newExciseStampPallet['department_id'] = $department_id;
            }
        }

        if ($department_id == null) {
            return response()->json(['message' =>'The given department was invalid.'], 422);
        }

        $exciseStampPallet = ExciseStampPallet::where([
            ['barcode',      '=', $newExciseStampPallet['barcode']],
            ['department_id','=', $newExciseStampPallet['department_id']]
        ])->first();

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
