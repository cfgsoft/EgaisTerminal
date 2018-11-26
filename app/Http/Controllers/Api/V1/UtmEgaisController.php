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

        $contents = Storage::get('utmegais/TTN3.xml');
        return response($contents)
            ->header('Content-Type', 'text/xml');
    }

}
