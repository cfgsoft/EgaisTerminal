<?php

namespace App\Http\Controllers\api\v1;

use App\Models\ExciseStamp\ExciseStampBox;
use App\Models\ExciseStamp\ExciseStampBoxLine;
use App\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        $this->validate($request, [
            'barcode'	  =>	'required',
            'productcode' =>	'required',
            'f1regid'     =>	'required',
            'f2regid'     =>	'required',
            'department_code' => 'required',
            'department_id'   => 'filled'
        ]);

        $newExciseStampBox = $request->all();

        $department_id =  null;
        if ($request->has('department_id')) {
            $department_id = $newExciseStampBox["department_id"];
        } else {
            $department_code = $newExciseStampBox["department_code"];
            $department = Department::where('code','=',$department_code)->first();

            if ($department != null){
                $department_id = $department->id;
                $newExciseStampBox['department_id'] = $department_id;
            }
        }

        if ($department_id == null) {
            return response()->json(['message' =>'The given department was invalid.'], 422);
        }

        $exciseStampBox = ExciseStampBox::where([
            ['barcode',      '=', $newExciseStampBox['barcode']],
            ['department_id','=', $newExciseStampBox['department_id']]
        ])->first();

        if ($exciseStampBox == null) {
            $exciseStampBox = ExciseStampBox::create($newExciseStampBox);
        } else {
            //$exciseStampBox->update($newExciseStampBox);
        }

        DB::beginTransaction();

        try{

            ExciseStampBoxLine::where('excise_stamp_box_id', '=', $exciseStampBox->id)->delete();

            $lines = $newExciseStampBox['lines'];
            foreach ($lines as $line){
                $newLine = new ExciseStampBoxLine();
                $newLine->excise_stamp_box_id = $exciseStampBox->id;
                $newLine->markcode = $line['markcode'];
                $newLine->Save();
            }

            DB::commit();

        } catch(\Exception $exception){

            DB::rollback();
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
