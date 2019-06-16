<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SoftwareUpdateController extends Controller
{
    public function GetFile($fileName)
    {
        $fileNameLocal = 'software/' . $fileName;

        if(!Storage::exists($fileNameLocal)) {

            Return response()->json([
                'message' => 'File not found',
            ], 404);

        }

        $contents = Storage::get($fileNameLocal);
        $response = response($contents);

        $fileExtension = substr("$fileName", -3);
        switch ($fileExtension) {
            case "xml":
                $response->header('Content-Type', 'text/xml');
                break;
            case "exe":
                $response->header('Content-Type', 'multipart/form-data');
                break;
        }

        return $response;
    }
}
