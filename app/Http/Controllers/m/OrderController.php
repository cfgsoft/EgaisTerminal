<?php

namespace App\Http\Controllers\m;

use App\Order;
use App\OrderLine;
use App\OrderMarkLine;
use App\OrderPackLine;
use App\OrderErrorLine;
use App\ExciseStamp;
use App\ExciseStampBox;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $order = Order::orderBy("number", 'desc')
                 ->take(10)->get();

        $barcode = '';
        if ($request->has('barcode')) {
            $barcode = $request->get('barcode');
        }
        //$request->input('barcode');

        return view('m/order/index', ['order' => $order, 'barcode' => $barcode]);
    }

    public function edit(Request $request)
    {
        $order = Order::find($request->get('id'));
        $order->orderlines;
        $order->orderlines = $order->orderlines->sortBy('orderlineid')->sortByDesc('showfirst');



        //$order->orderlines->sortBy('orderlineid');
        //$order->orderlines->sortByDesc('orderlineid');

        //$orderlines = $orderlines->sortByDesc('orderlineid');
        //$order->orderlines = $orderlines;

        //$sorted->values()->all();
        //
        //return var_dump($sorted->values()->all());

        $errorMessage = '';
        if ($request->has('errorMessage')) {
            $errorMessage = $request->get('errorMessage');
        }

        return view('m/order/edit', ['order' => $order, 'errorMessage' => $errorMessage]);
    }

    public function submitbarcode(Request $request)
    {
        $barcode = $request->input('BarCode', '');

        //$barcode = '';
        //if ($request->has('BarCode')) {
        //    $barcode = $request->get('BarCode');
        //}

        if ($barcode == '0') {
            return redirect()->action('m\HomeController@index');
        }

        if (strlen($barcode) > 8 and strlen($barcode) < 13) {
            $barcode = str_replace("*", "", $barcode);
            //$barcode = str_replace("C", "С", $barcode);
            //$barcode = substr($barcode, 0, 4) . '_' . substr($barcode, 4);
            //$order = Order::where('number', '=', $barcode)->first();

            $order = Order::where('barcode', '=', $barcode)->first();

            if (isset($order)) {
                return redirect()->action('m\OrderController@edit', ['id' => $order->id]);
            }
        }

        $barcode = 'Не найден заказ №' . $barcode;

        return redirect()->action('m\OrderController@index', ['barcode' => $barcode]);
    }

    public function submiteditbarcode(Request $request)
    {
        $barcode  = $request->input('BarCode', '');
        $order_id = $request->input('order_id', '');

        if ($barcode == '0') {
            return redirect()->action('m\OrderController@index');
        }

        //Переход на другой заказ
        if (strlen($barcode) > 8 and strlen($barcode) < 13) {
            $barcode = str_replace("*", "", $barcode);
            //$barcode = str_replace("C", "С", $barcode);
            //$barcode = substr($barcode, 0, 4) . '_' . substr($barcode, 4);
            //$order = Order::where('number', '=', $barcode)->first();

            $order = Order::where('barcode', '=', $barcode)->first();

            if (isset($order)) {
                return redirect()->action('m\OrderController@edit', ['id' => $order->id]);
            }
        }

        if (strlen($barcode) == 26) {
            $result = $this->addPackExciseStamp($barcode, $order_id);
        } else {
            $result = $this->addExciseStamp($barcode, $order_id);
        }

        $errorBarCode = $result['error'];
        $errorMessage = $result['errorMessage'];

        if ($errorBarCode) {
            return redirect()->action('m\OrderController@edit', ['id' => $order_id, 'errorMessage' => $errorMessage ]);
        }

        return redirect()->action('m\OrderController@edit', ['id' => $order_id]);

    }

    private function addExciseStamp($barcode, $order_id)
    {
        $errorBarCode = true;
        $errorMessage = "Не опознан ШК " . $barcode;

        //СКАНИРОВАНИЕ АКЦИЗНОЙ МАРКИ
        //101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI
        if (strlen($barcode) == 150 or strlen($barcode) == 68) {
            $exciseStamp = ExciseStamp::find($barcode);
            if (isset($exciseStamp)) {
                $errorBarCode = false;

                $order = Order::find($order_id);
                $order->orderlines;

                //1. Ищем штрих код в уже набранных товарах, если находим ошибка.
                $orderMarkLine = OrderMarkLine::where([['markcode', '=', $barcode],['quantity', '=', '1']])->first();
                if (isset($orderMarkLine)) {
                    $errorBarCode = true;
                    $errorMessage = "Товар уже сканировался " . $barcode;
                }

                if (!$errorBarCode) {
                    //2. Ищем товар в строке заказов
                    $orderLine = OrderLine::where([["order_id",   "=", $order_id],
                        ["productcode","=", $exciseStamp->productcode],
                        ["f2regid",    "=", $exciseStamp->f2regid]
                    ])->first();

                    if (isset($orderLine)) {

                        if ($orderLine->quantity > $orderLine->quantitymarks ) {

                            //Обнуление showFirst  у заказа
                            $order->orderlines->each(function ($item, $key) {
                                if ($item->showfirst) {
                                    $item->showfirst = false;
                                    $item->save();
                                }
                            });

                            DB::beginTransaction();

                            try{
                                $orderMarkLine = new OrderMarkLine;
                                $orderMarkLine->order_id    = $order_id;
                                $orderMarkLine->orderlineid = $orderLine->orderlineid;
                                $orderMarkLine->productcode = $exciseStamp->productcode;
                                $orderMarkLine->f2regid     = $exciseStamp->f2regid;
                                $orderMarkLine->markcode    = $barcode;
                                $orderMarkLine->quantity    = 1;
                                $orderMarkLine->savedin1c   = false;
                                $orderMarkLine->save();

                                $orderLine->quantitymarks = $orderLine->quantitymarks + 1;
                                $orderLine->showfirst = true;
                                $orderLine->save();

                                DB::commit();

                            } catch(\Exception $exception){
                                $errorBarCode = true;
                                $errorMessage = "Ошибка при записи " . $barcode;

                                DB::rollback();
                            }

                        } else {
                            $errorBarCode = true;
                            $errorMessage = "Превышено количество в наборе " . $barcode;
                        }

                    } else {
                        $errorBarCode = true;
                        $errorMessage = "Товар не зайден в заказе " . $barcode;
                    }
                }

            } else {
                $errorBarCode = true;
                $errorMessage = "Не найдена марка в БД " . $barcode;
            }
        }

        if ($errorBarCode && strlen($barcode) > 0) {
            $orderErrorLine = new OrderErrorLine;
            $orderErrorLine->order_id = $order_id;
            $orderErrorLine->markcode = $barcode;
            $orderErrorLine->message = $errorMessage;
            $orderErrorLine->save();

            return ['error' => $errorBarCode, 'errorMessage' => $errorMessage ];
        }

        return ['error' => false, 'errorMessage' => ''];
    }

    private function addPackExciseStamp($barcode, $order_id)
    {
        $errorBarCode = true;
        $errorMessage = "Не опознан ШК ящика " . $barcode;

        //СКАНИРОВАНИЕ ЯЩИКА
        if (strlen($barcode) == 26) {
            $exciseStampBox = ExciseStampBox::where('barcode', '=', $barcode)->first();
            if (isset($exciseStampBox)) {
                $errorBarCode = false;

                //Ищем штрих код ящика в уже набранных ящиках, если находим ошибка.
                $orderPackLine = OrderPackLine::where('markcode', '=', $barcode)->first();
                if (isset($orderPackLine)) {
                    $errorBarCode = true;
                    $errorMessage = "Ящик уже сканировался " . $barcode;
                }

                if (!$errorBarCode) {

                    DB::beginTransaction();

                    $order = Order::find($order_id);
                    $order->orderlines;
                    $order->ordermarklines;

                    $lines = $exciseStampBox->excisestampboxlines;
                    foreach ($lines as $line){

                        //1. Ищем штрих код в уже набранных товарах, если находим ошибка.
                        $orderMarkLine = OrderMarkLine::where([['markcode', '=', $line->markcode],['quantity', '=', '1']])->first();
                        if (isset($orderMarkLine)) {
                            $errorBarCode = true;
                            $errorMessage = "Товар уже сканировался " . $line->markcode;
                            break;
                        }

                        $exciseStamp = ExciseStamp::find($line->markcode);

                        //2. Ищем товар в строке заказов
                        $orderLine = null;
                        foreach ($order->orderlines as $item){
                            if ($item->productcode == $exciseStamp->productcode and $item->f2regid == $exciseStamp->f2regid){
                                $orderLine = $item;
                                break;
                            }
                        }

                        //3. Превышенние количества в заказе
                        if (isset($orderLine)) {
                            if ($orderLine->quantity > $orderLine->quantitymarks ) {

                                $orderMarkLine = new OrderMarkLine;
                                $orderMarkLine->order_id    = $order_id;
                                $orderMarkLine->orderlineid = $orderLine->orderlineid;
                                $orderMarkLine->productcode = $exciseStamp->productcode;
                                $orderMarkLine->f2regid     = $exciseStamp->f2regid;
                                $orderMarkLine->markcode    = $line->markcode;
                                $orderMarkLine->boxnumber   = $barcode;
                                $orderMarkLine->quantity    = 1;
                                $orderMarkLine->savedin1c   = false;
                                $orderMarkLine->save();

                                $orderLine->quantitymarks = $orderLine->quantitymarks + 1;
                                $orderLine->showfirst = true;
                                $orderLine->save();

                            } else {
                                $errorBarCode = true;
                                $errorMessage = "Сканирование ящика. Превышено количество в наборе " . $line->markcode;

                                break;
                            }
                        } else {
                            $errorBarCode = true;
                            $errorMessage = "Сканирование ящика. Товар не зайден в заказе " . $line->markcode;

                            break;
                        }

                    }

                    //Запись ящика
                    if (!$errorBarCode) {
                        $orderPackLine = new OrderPackLine;
                        $orderPackLine->order_id    = $order_id;
                        $orderPackLine->orderlineid = 1;
                        $orderPackLine->productcode = $exciseStampBox->productcode;
                        $orderPackLine->f2regid     = $exciseStampBox->f2regid;
                        $orderPackLine->markcode    = $barcode;
                        $orderPackLine->quantity    = 1;
                        $orderPackLine->savedin1c   = false;
                        $orderPackLine->save();

                        DB::commit();
                    }

                    DB::rollBack();

                }
            }


            if ($errorBarCode && strlen($barcode) > 0) {
                $orderErrorLine = new OrderErrorLine;
                $orderErrorLine->order_id = $order_id;
                $orderErrorLine->markcode = $barcode;
                $orderErrorLine->message = $errorMessage;
                $orderErrorLine->save();

                return ['error' => $errorBarCode, 'errorMessage' => $errorMessage];
            }

            return ['error' => false, 'errorMessage' => ''];
        }
    }
}
