<?php

namespace App\Http\Controllers\api\v1;

use App\Order;
use App\OrderLine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$order = Order::find(1);
        //$order->orderlines;
        //$order->ordermarklines;

        $order = Order::with('orderlines', 'ordermarklines')->get();

        return response()->json($order);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newOrder = $request->all();

        $order = Order::where('number', $newOrder['number'])->first();
        if ($order == null) {
            $order = Order::create($newOrder);
        } else {
            //$order->update($newOrder);
        }

        OrderLine::where('order_id', '=', $order->id)->delete();

        $orderlines = $newOrder['orderlines'];
        foreach ($orderlines as $line){
            $newOrderLine = new OrderLine();
            $newOrderLine->orderlineid   = $line['OrderLineId'];
            $newOrderLine->productdescr  = $line['ProductDescr'];
            $newOrderLine->productcode   = $line['ProductCode'];
            $newOrderLine->quantity      = $line['Quantity'];
            $newOrderLine->order_id      = $order->id;
            $newOrderLine->showfirst     = 0;
            $newOrderLine->Save();
        }

        return $order;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
