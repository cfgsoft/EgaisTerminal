<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }
	
	public function contact(Request $request)
    {
        return response()->json(['name' => 'Abigail','state' => 'CA']);
		
		//JSONP современные браузы. поддерживают CORS
		//return response()->json(['name' => 'Abigail', 'state' => 'CA'])
		//				 ->withCallback($request->input('callback'));
		
    }
}
