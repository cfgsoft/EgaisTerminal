<?php

namespace App\Http\Controllers\api\v1;

use App\Order;
use App\OrderLine;
use App\OrderMarkLine;
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

        //$order = Order::with('orderlines', 'ordermarklines', 'orderpacklines', 'ordererrorlines')
        $order = Order::with('orderlines', 'ordererrorlines')
            ->orderBy("number", 'desc')
            ->take(50)
            ->get();

        return response()->json($order);
    }

    public function indexMarkLine()
    {
        $order = OrderMarkLine::where('savedin1c', '=', false)->orderBy('order_id')->get();

        //$order = Order::has('ordermarklines','>',0, function($query) {
        //    $query->where('savedin1c', '=', 1);
        //})->with('ordermarklines')->get();

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

        //$order = Order::where('number', $newOrder['number'])->first();
        $order = Order::where('DocId', $newOrder['DocId'])->first();
        if ($order == null) {
            $order = Order::create($newOrder);
        } else {
            //$order->update($newOrder);

            $order->barcode = $newOrder['barcode'];
            $order->DocType = $newOrder['DocType'];
            $order->DocId   = $newOrder['DocId'];
            $order->Save();
        }

        //Обнуляем количество, загружаем повторно
        OrderLine::where('order_id', '=', $order->id)->update(['quantity' => 0]);

        $oldOrderLines = $order->orderlines;

        //Добавляем новые записи, изменяем существующее количество
        $orderlines = $newOrder['orderlines'];
        foreach ($orderlines as $line){
            $oldOrderLine = $oldOrderLines->firstWhere('f2regid', $line['F2RegId']);

            if (!isset($oldOrderLine)) {
                //add
                $newOrderLine = new OrderLine();
                $newOrderLine->orderlineid   = $line['OrderLineId'];
                $newOrderLine->productdescr  = $line['ProductDescr'];
                $newOrderLine->productcode   = $line['ProductCode'];
                $newOrderLine->f2regid       = $line['F2RegId'];
                $newOrderLine->quantity      = $line['Quantity'];
                $newOrderLine->order_id      = $order->id;
                $newOrderLine->showfirst     = 0;
                $newOrderLine->Save();
            } else {
                //update
                if ($oldOrderLine->quantity != $line['Quantity']) {
                    $oldOrderLine->quantity  = $line['Quantity'];
                    $oldOrderLine->Save();
                }
            }
        }

        return $order;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$order = Order::with('orderlines', 'ordermarklines', 'orderpacklines', 'ordererrorlines')
        $order = Order::find($id);
        $order->ordermarklines;
        $order->orderpacklines;
        $order->ordererrorlines;

        return response()->json($order);
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

    public function updateMarkLine(Request $request, $id)
    {
        $orderMarkLine = OrderMarkLine::findOrFail($id);
        $orderMarkLine->savedin1c = true;
        $orderMarkLine->save();

        return $orderMarkLine;
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
