<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Order\Order;
use App\Models\Order\OrderLine;
use App\Models\Order\OrderMarkLine;
use App\Models\Order\OrderPackLine;
use App\Models\Order\OrderErrorLine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$order = Order::find(1);
        //$order->orderlines;
        //$order->ordermarklines;

        //$order = Order::with('orderlines', 'ordermarklines', 'orderpacklines', 'ordererrorlines')


        //$order = Order::with('orderlines', 'ordererrorlines')
        //    ->orderBy("number", 'desc')
        //    ->take(50)
        //    ->get();
        //
        //return response()->json($order);


        $order = Order::with('orderLines', 'orderErrorLines')
            ->orderBy('number', 'desc')
            ->paginate(50);

        return $order;

    }

    public function indexErrorLine(Request $request)
    {
        $order = OrderErrorLine::orderBy('id', 'desc')->paginate(50);

        return $order;
    }

    public function indexMarkLine()
    {
        $order = OrderMarkLine::where('savedin1c', '=', false)->orderBy('order_id')
            ->take(100)->get();

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

        //$category = Category::updateOrCreate([ "code" => $newCategory["code"] ]);
        //$order = Order::where('number', $newOrder['number'])->first();
        $order = Order::where('doc_id', $newOrder['doc_id'])->first();
        if ($order == null) {
            $order = Order::add($newOrder);
            $order->save();

        } else {
            $order->edit($newOrder);
            $order->save();
        }

        if (array_key_exists('lines', $newOrder))
        {
            //$order->deleteLines();
            //$newInvoicesLines = $newInvoice['lines'];
            //foreach ($newInvoicesLines as $line) {
            //    $invoice->addLines($line);
            //}
        }



        //Обнуляем количество, загружаем повторно
        OrderLine::where('order_id', '=', $order->id)->update(['quantity' => 0]);

        $oldOrderLines = $order->orderLines;

        $quantity_sum = 0;

        //Добавляем новые записи, изменяем существующее количество
        $orderlines = $newOrder['lines'];
        foreach ($orderlines as $line){
            $oldOrderLine = $oldOrderLines->firstWhere('f2reg_id', $line['f2reg_id']);

            if ($oldOrderLine == null) {
                //add
                $newOrderLine = new OrderLine();
                $newOrderLine->line_id        = $line['line_id'];
                $newOrderLine->product_descr  = $line['product_descr'];
                $newOrderLine->product_code   = $line['product_code'];
                $newOrderLine->f2reg_id       = $line['f2reg_id'];
                $newOrderLine->quantity       = $line['quantity'];
                $newOrderLine->order_id       = $order->id;
                $newOrderLine->show_first     = 0;
                $newOrderLine->Save();
            } else {
                //update
                if ($oldOrderLine->quantity != $line['quantity']) {
                    $oldOrderLine->quantity  = $line['quantity'];
                    $oldOrderLine->Save();
                }
            }

            $quantity_sum = $quantity_sum + $line['quantity'];
        }

        if ($order->quantity != $quantity_sum)
        {
            $order->quantity = $quantity_sum;
            $order->save();
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
        $order->orderMarkLines;
        $order->orderPackLines;
        $order->orderErrorLines;

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

    public function indexMarkLine1c()
    {
        $orderMarkLine = OrderMarkLine::where('savedin1c', '=', false)->orderBy('order_id')->get();

        return $orderMarkLine;
    }

    public function indexPackLine1c()
    {
        $orderPackLine = OrderPackLine::where('savedin1c', '=', false)->orderBy('order_id')->get();

        return $orderPackLine;
    }

    public function indexErrorLine1c()
    {
        $orderErrorLine = OrderErrorLine::where('savedin1c', '=', false)->orderBy('order_id')->get();

        return $orderErrorLine;
    }

    public function updateMarkLine1c(Request $request, $id)
    {
        $orderMarkLine = OrderMarkLine::findOrFail($id);
        $orderMarkLine->savedin1c = true;
        $orderMarkLine->save();

        return $orderMarkLine;
    }

    public function updatePackLine1c(Request $request, $id)
    {
        $orderPackLine = OrderPackLine::findOrFail($id);
        $orderPackLine->savedin1c = true;
        $orderPackLine->save();

        return $orderPackLine;
    }

    public function updateErrorLine1c(Request $request, $id)
    {
        $orderErrorLine = OrderErrorLine::findOrFail($id);
        $orderErrorLine->savedin1c = true;
        $orderErrorLine->save();

        return $orderErrorLine;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($request->has('f2reg_id')) {
            $f2RegId = $request->get('f2reg_id');

            $order->removeLineF2RegId($f2RegId);
        }

        $order->orderMarkLines;

        return $order;
    }
}
