<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
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

    public function about(Request $request)
    {
        return view('about');
    }
	
	public function contact(Request $request)
    {
        //return var_dump($_COOKIE);

        return response()->json(['name' => 'Abigail','state' => 'CA']);
		
		//JSONP современные браузы. поддерживают CORS
		//return response()->json(['name' => 'Abigail', 'state' => 'CA'])
		//				 ->withCallback($request->input('callback'));
		
    }

    public function test()
    {
        $order = Order::find('10');
        $lines = $order->orderlines;
        $lines2 = $order->orderlines;

        $result = $lines->firstWhere('productcode', '0123130000002476973');
        return var_dump($result);

        //foreach ($lines as $key => $value){
        //    //echo $key;
        //    //echo $value;
        //    $lines2->forget($key);
        //}

        //$lines->forget(0);

        //return var_dump($lines2);

        //$collection = collect([
        //    ['name' => 'Regena', 'age' => 12],
        //    ['name' => 'Linda', 'age' => 14],
        //    ['name' => 'Diego', 'age' => 23],
        //    ['name' => 'Linda', 'age' => 84],
        //]);

        //$result = $collection->firstWhere('name', 'Linda');

        //$collection->forget(0);


        //$collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
        //$collection->forget('name');
        //$collection->all();


        return var_dump($collection);

        return view('test');
    }
}
