<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UtmEgaisController extends Controller
{
    public function index()
    {
        //$posts = Post::where('visible', 1)->orderBy('updated_at', 'DESC')->get();
        //return response()->view('pages.sitemap', compact('posts'))->header('Content-Type', 'text/xml');

        //$xml = '<A>1</A>';

        //$xml = new DOMDocument('1.0');
        //$xml->Load('book.xml');
        //
        //return $xml;

        //File::put('path/to/file', 'file contents');
        //File::put('file1111111111', 'file contents');

        //$fileContents = '2142342152352352352345';
        //Storage::put('avatars/1', $fileContents);

        $contents = Storage::get('utmegais/InfoVersionTTN.xml');

        return response($contents)
               ->header('Content-Type', 'text/xml');
    }

    public function opt_in()
    {
        $contents = Storage::get('utmegais/opt_in.xml');
        return response($contents)
            ->header('Content-Type', 'text/xml');
    }

    public function opt_out()
    {
        $contents = Storage::get('utmegais/opt_out.xml');
        return response($contents)
            ->header('Content-Type', 'text/xml');
    }

    public function waybill_v3($id = 0)
    {
        //return $id;
        if ($id == 2) {
            $contents = Storage::get('utmegais/TTN3_WayBill_v3-030x1F5DD4A3-9BF3-4DFC-8640-25BD2778C2E5.xml');
        } elseif ($id == 3){
            $contents = Storage::get('utmegais/TTN3_WayBill_v3-030x5F16C118-196E-430C-88F5-D34849080964.xml');
        } elseif ($id == 6){
            $contents = Storage::get('utmegais/TTN3_WayBill_WayBill_v3-030x1CA06645-442E-4743-9CB1-382FDE867E24.xml');
        } else {
            $contents = Storage::get('utmegais/TTN3.xml');
        }
        return response($contents)
            ->header('Content-Type', 'text/xml');
    }

    public function form2RegInfo($id = 0)
    {
        if ($id == 4) {
            $contents = Storage::get('utmegais/TTNInformF2Reg_FORM2REGINFO-030x898D3DF4-9BBC-45B8-A63A-4961A6865AF7.xml');
        } elseif ($id == 5){
            $contents = Storage::get('utmegais/TTNInformF2Reg_FORM2REGINFO-030xAD494300-35A2-43F8-8EF7-207DFCC356EB.xml');
        } elseif ($id == 7){
            $contents = Storage::get('utmegais/TTNInformF2Reg_FORM2REGINFO-030x5A7C71DD-5472-40AB-B5F3-69C4B4A95236.xml');
        } else {
            $contents = Storage::get('utmegais/TTNInformF2Reg_FORM2REGINFO-030x898D3DF4-9BBC-45B8-A63A-4961A6865AF7.xml');
        }

        return response($contents)->header('Content-Type', 'text/xml');
    }

    public function wayBillAct_v3($id = 0)
    {
        if ($id == 8) {
            $contents = Storage::get('utmegais/WayBillAct_v3.xml');
        }

        return response($contents)->header('Content-Type', 'text/xml');
    }

    public function rsa(Request $request)
    {
        $contents = Storage::get('utmegais/user.crt');
        return response($contents)->header('Content-Type', 'text/xml');
    }

}
