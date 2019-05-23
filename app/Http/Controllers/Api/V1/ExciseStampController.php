<?php

namespace App\Http\Controllers\api\v1;

use App\Models\ExciseStamp\ExciseStamp;
use App\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExciseStampController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        header('Access-Control-Allow-Origin: *');

        $exciseStamp = ExciseStamp::orderBy("id");

        return $exciseStamp->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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

        $newExciseStamp = $request->all();

        $department_id =  null;
        if ($request->has('department_id')) {
            $department_id = $newExciseStamp["department_id"];
        } else {
            $department_code = $newExciseStamp["department_code"];
            $department = Department::where('code','=',$department_code)->first();

            if ($department != null){
                $department_id = $department->id;
                $newExciseStamp['department_id'] = $department_id;
            }
        }

        if ($department_id == null) {
            return response()->json(['message' =>'The given department was invalid.'], 422);
        }

        $exciseStamp = ExciseStamp::where([
            ['barcode',      '=',$newExciseStamp['barcode']],
            ['department_id','=',$newExciseStamp['department_id']]
        ])->first();

        if ($exciseStamp == null) {
            $exciseStamp = ExciseStamp::create($newExciseStamp);
        } else {
            $exciseStamp->update($newExciseStamp);
        }

        return $exciseStamp;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExciseStamp  $exciseStamp
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ExciseStamp::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExciseStamp  $exciseStamp
     * @return \Illuminate\Http\Response
     */
    public function edit(ExciseStamp $exciseStamp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExciseStamp  $exciseStamp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exciseStamp = ExciseStamp::findOrFail($id);
        $exciseStamp->update($request->all());

        return $exciseStamp;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExciseStamp  $exciseStamp
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exciseStamp = ExciseStamp::findOrFail($id);
        $exciseStamp->delete();
        return 'OK';
    }
}
