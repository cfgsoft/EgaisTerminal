<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Models\ExciseStamp\ExciseStamp;
use App\Models\ExciseStamp\ExciseStampBox;
use App\Models\ExciseStamp\ExciseStampPallet;

class Order extends Model
{
    protected $table = 'doc_order';

    protected $fillable = ['date', 'number', 'barcode', 'status',
        'quantity', 'quantity_mark', 'doc_type', 'doc_id'];

    public function orderLines(){
        return $this->hasMany("App\Models\Order\OrderLine");
    }

    public function orderMarkLines(){
        return $this->hasMany("App\Models\Order\OrderMarkLine");
    }

    public function orderPackLines(){
        return $this->hasMany("App\Models\Order\OrderPackLine");
    }

    public function orderPalletLines(){
        return $this->hasMany("App\Models\Order\OrderPalletLine");
    }

    public function orderErrorLines(){
        return $this->hasMany("App\Models\Order\OrderErrorLine");
    }


    public static function add($fields)
    {
        $order = new static;
        $order->fill($fields);
        $order->doc_type      = $fields['doc_type'];
        $order->doc_id        = $fields['doc_id'];

        return $order;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->doc_type = $fields['doc_type'];
        $this->doc_id   = $fields['doc_id'];

        return $this;
    }

    public function addLines($fields)
    {
        $line = new OrderLine();
        $line->fill($fields);
        $line->order_id = $this->id;
        $line->save();

        return $line;
    }


    public function findLineF2RegId($f2reg_id)
    {
        if($f2reg_id == null) { return; }

        $orderLine = OrderLine::where([ ['order_id','=',$this->id], ['f2reg_id','=',$f2reg_id] ])->first();

        return $orderLine;
    }

    public function addBarCode($barcode, $department_id = 1)
    {
        //СКАНИРОВАНИЕ АКЦИЗНОЙ МАРКИ, ЯЩИКА, ПАЛЛЕТА
        if (strlen($barcode) != 150 and strlen($barcode) != 68 and strlen($barcode) != 26 and strlen($barcode) != 18)
        {
            $errorMessage = "Не опознан ШК " . $barcode;

            $this->addErrorLine($barcode, '', '', $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }


        if (strlen($barcode) == 26 or strlen($barcode) == 18) {
            $exciseStampPallet = ExciseStampPallet::where([['barcode', '=', $barcode], ['department_id','=',$department_id] ])->first();
            if ($exciseStampPallet == null) {
                $result = $this->addPackExciseStamp($barcode);
            } else {
                $result = $this->addPalletExciseStamp($exciseStampPallet);
            }
        } else {
            $result = $this->addExciseStamp($barcode);
        }

        return $result;
    }

    private function addErrorLine($barcode, $product_code, $f2reg_id, $errorMessage)
    {
        $orderErrorLine = new OrderErrorLine;
        $orderErrorLine->order_id     = $this->id;
        $orderErrorLine->markcode     = $barcode;
        $orderErrorLine->message      = $errorMessage;
        $orderErrorLine->product_code = $product_code;
        $orderErrorLine->f2reg_id     = $f2reg_id;
        $orderErrorLine->savedin1c    = 0;
        $orderErrorLine->save();

        return $orderErrorLine;
    }

    private function addExciseStamp($barcode, $department_id = 1)
    {
        $errorBarCode = false;
        $errorMessage = "";

        //СКАНИРОВАНИЕ АКЦИЗНОЙ МАРКИ
        //101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI
        if (strlen($barcode) != 150 and strlen($barcode) != 68)
        {
            $errorMessage = "Не опознан ШК " . $barcode;

            $this->addErrorLine($barcode, '', '', $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //1. Ищем марку в классификаторе акцизных марок
        //$exciseStamp = ExciseStamp::find($barcode);
        $exciseStamp = ExciseStamp::where([ ['barcode','=',$barcode],['department_id','=',$department_id] ])->first();
        if ($exciseStamp == null)
        {
            $errorMessage = "Не найдена марка в БД " . $barcode;

            $this->addErrorLine($barcode, '','', $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //2. Ищем штрих код в уже набранных товарах в заказе, если находим ошибка.
        $orderMarkLine = OrderMarkLine::where( [['order_id', '=', $this->id],['markcode', '=', $barcode]] )->first();
        if ($orderMarkLine != null)
        {
            $errorMessage = "Товар уже сканировался " . $barcode;

            $this->addErrorLine($barcode, $orderMarkLine->product_code, $orderMarkLine->f2reg_id, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //3. Ищем марку в уже сканированных заказах, за 3 дня
        //$created_at = Carbon::now()->subDays(3);
        //["created_at", ">", $created_at]

        $orderMarkLine = OrderMarkLine::where([['markcode',   '=', $barcode],
                                               ['quantity',   '=', '1'],
                                               ['f2reg_id',   '=', $exciseStamp->f2regid]
        ])->first();
        if ($orderMarkLine != null)
        {
            $errorMessage = "Товар уже сканировался " . $barcode;

            $this->addErrorLine($barcode, $orderMarkLine->product_code, $orderMarkLine->f2reg_id, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }


        //4. Ищем строку в заказе которая соответствует этой марке
        $orderLine = OrderLine::where([['order_id',    '=', $this->id],
                                       ['product_code','=', $exciseStamp->productcode],
                                       ['f2reg_id',    '=', $exciseStamp->f2regid]
        ])->first();
        if ($orderLine == null)
        {
            $errorMessage = "Раздел Б " . $exciseStamp->f2regid . " не найден в заказе " . $barcode;

            $this->addErrorLine($barcode, $exciseStamp->productcode, $exciseStamp->f2regid, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //6. Количество отсканированных марок превышено
        if ($orderLine->quantity <= $orderLine->quantity_mark ) {
            $errorMessage = "Превышено количество в наборе " . $barcode;

            $this->addErrorLine($barcode, $exciseStamp->productcode, $exciseStamp->f2regid, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //7. Обнуление showFirst  у заказа
        $this->orderlines->each(function ($item, $key) {
            if ($item->show_first) {
                $item->show_first = false;
                $item->save();
            }
        });

        DB::beginTransaction();

        try{
            $orderMarkLine = new OrderMarkLine;
            $orderMarkLine->order_id     = $this->id;
            $orderMarkLine->line_id      = $orderLine->line_id;
            $orderMarkLine->product_code = $exciseStamp->productcode;
            $orderMarkLine->f2reg_id     = $exciseStamp->f2regid;
            $orderMarkLine->markcode     = $barcode;
            //$orderMarkLine->pack_number  = "000000000000000000000";
            $orderMarkLine->quantity     = 1;
            $orderMarkLine->savedin1c    = false;
            $orderMarkLine->save();

            $orderLine->quantity_mark = $orderLine->quantity_mark + 1;
            $orderLine->show_first = true;
            $orderLine->save();

            $this->increment('quantity_mark');
            $this->save();

            DB::commit();

        } catch(\Exception $exception){
            $errorBarCode = true;
            $errorMessage = "Ошибка при записи " . $barcode;

            DB::rollback();
        }


        if ($errorBarCode && strlen($barcode) > 0) {
            $this->addErrorLine($barcode,'', '', $errorMessage);

            return ['error' => $errorBarCode, 'errorMessage' => $errorMessage ];
        }

        return ['error' => false, 'errorMessage' => ''];
    }

    private function addPackExciseStamp($barcode, $department_id = 1)
    {
        $errorBarCode = false;
        $errorMessage = "";

        //СКАНИРОВАНИЕ ЯЩИКА
        if (strlen($barcode) != 26) {
            $errorMessage = "Не опознан ШК ящика " . $barcode;

            $this->addErrorLine($barcode, '', '', $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //1.
        //$exciseStampBox = ExciseStampBox::where('barcode', '=', $barcode)->first();
        $exciseStampBox = ExciseStampBox::where([['barcode','=',$barcode],['department_id','=',$department_id]])->first();
        if ($exciseStampBox == null) {
            $errorMessage = "Не опознан ШК ящика " . $barcode;

            $this->addErrorLine($barcode, '', '', $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //2. Ищем штрих код ящика в уже набранных ящиках, если находим ошибка.
        //$created_at = Carbon::now()->subDays(3);
        //Уникальный индекс
        //$orderPackLine = OrderPackLine::where([['markcode', '=', $barcode],
        //                                       ["created_at", ">", $created_at]

        $orderPackLine = OrderPackLine::where('pack_number', '=', $barcode)->first();
        if ($orderPackLine != null) {
            $errorMessage = "Ящик уже сканировался " . $barcode;

            $this->addErrorLine($barcode, $orderPackLine->product_code, $orderPackLine->f2reg_id, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }


        DB::beginTransaction();

        $order = Order::find($this->id);
        $order->orderLines;
        $order->orderMarkLines;

        $lines = $exciseStampBox->excisestampboxlines;
        foreach ($lines as $line){
            //$exciseStamp = ExciseStamp::find($line->markcode);
            $exciseStamp = ExciseStamp::where([ ['barcode','=',$line->markcode],['department_id','=',$department_id] ])->first();

            //1. Ищем штрих код в уже набранных товарах, если находим ошибка.
            // ошибки из-за пересортицы
            //$created_at = Carbon::now()->subDays(3);
            //["created_at", ">", $created_at]

            $orderMarkLine = OrderMarkLine::where([['markcode', '=', $line->markcode],
                                                   ['quantity', '=', '1'],
                                                   ['f2reg_id', '=', $exciseStamp->f2regid]
            ])->first();
            if ($orderMarkLine != null) {
                $errorBarCode = true;
                $errorMessage = "Товар уже сканировался " . $line->markcode;

                $this->addErrorLine($barcode, $orderMarkLine->product_code, $orderMarkLine->f2reg_id, $errorMessage);

                break;
            }

            //2. Ищем товар в строке заказов
            $orderLine = null;
            foreach ($order->orderLines as $item){
                if ($item->f2reg_id == $exciseStamp->f2regid){
                    $orderLine = $item;
                    break;
                }
            }

            if ($orderLine == null)
            {
                $errorBarCode = true;
                $errorMessage = "Разд Б " . $exciseStamp->f2regid . " не зайден в заказе " . $line->markcode;

                $this->addErrorLine($barcode, $exciseStamp->productcode, $exciseStamp->f2regid, $errorMessage);

                break;
            }

            if ($orderLine->quantity <= $orderLine->quantity_mark ) {
                $errorBarCode = true;
                $errorMessage = "Сканирование ящика. Превышено количество в наборе " . $line->markcode;

                $this->addErrorLine($barcode, $exciseStamp->productcode, $exciseStamp->f2regid, $errorMessage);

                break;
            }

            $orderMarkLine = new OrderMarkLine;
            $orderMarkLine->order_id     = $this->id;
            $orderMarkLine->line_id      = $orderLine->line_id;
            $orderMarkLine->product_code = $exciseStamp->productcode;
            $orderMarkLine->f2reg_id     = $exciseStamp->f2regid;
            $orderMarkLine->markcode     = $line->markcode;
            $orderMarkLine->pack_number  = $barcode;
            $orderMarkLine->quantity     = 1;
            $orderMarkLine->savedin1c    = false;
            $orderMarkLine->save();

            $orderLine->quantity_mark = $orderLine->quantity_mark + 1;
            $orderLine->show_first = true;
            $orderLine->save();

            $this->increment('quantity_mark');
            $this->save();
        }

        //Запись ящика
        if (!$errorBarCode)
        {
            $orderPackLine = new OrderPackLine;
            $orderPackLine->order_id     = $this->id;
            $orderPackLine->line_id      = 1;
            $orderPackLine->product_code = $exciseStampBox->productcode;
            $orderPackLine->f2reg_id     = $exciseStampBox->f2regid;
            $orderPackLine->pack_number  = $barcode;
            $orderPackLine->quantity     = 1;
            $orderPackLine->savedin1c    = false;
            $orderPackLine->save();

            DB::commit();
        }
        else
        {
            DB::rollBack();
        }




        if ($errorBarCode && strlen($barcode) > 0) {
            $this->addErrorLine($barcode,'', '', $errorMessage);

            return ['error' => $errorBarCode, 'errorMessage' => $errorMessage ];
        }

        return ['error' => false, 'errorMessage' => ''];
    }



    private function addExciseStamp_New($orderLine, $exciseStamp, $exciseStampBox)
    {
        if ($orderLine->quantity <= $orderLine->quantity_mark ) {
            $errorMessage = "Сканирование паллета. Превышено количество в наборе " . $exciseStamp->id;

            $this->addErrorLine($exciseStamp->id, $exciseStamp->productcode, $exciseStamp->f2regid, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        try{
            $orderMarkLine = new OrderMarkLine;
            $orderMarkLine->order_id     = $this->id;
            $orderMarkLine->line_id      = $orderLine->line_id;
            $orderMarkLine->product_code = $exciseStamp->productcode;
            $orderMarkLine->f2reg_id     = $exciseStamp->f2regid;
            $orderMarkLine->markcode     = $exciseStamp->barcode;
            $orderMarkLine->pack_number  = $exciseStampBox->barcode;
            $orderMarkLine->quantity    = 1;
            $orderMarkLine->savedin1c   = false;
            $orderMarkLine->save();

            $orderLine->increment('quantity_mark');  //$orderLine->quantitymarks = $orderLine->quantitymarks + 1;
            $orderLine->show_first = true;
            $orderLine->save();

            $this->increment('quantity_mark');
            $this->save();

        } catch(\Exception $exception){
            $errorMessage = "Ошибка при записи марки " . $exciseStamp->id;

            $this->addErrorLine($exciseStamp->id, $exciseStamp->productcode, $exciseStamp->f2regid, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        return ['error' => false, 'errorMessage' => ''];
    }

    private function addPackStamp_New($orderLine, $exciseStampBox, $pallet_number, $department_id = 1)
    {
        $linesBox = $exciseStampBox->excisestampboxlines;
        foreach ($linesBox as $line)
        {
            //$exciseStamp = ExciseStamp::find($line->markcode);
            $exciseStamp = ExciseStamp::where([ ['barcode','=',$line->markcode],['department_id','=',$department_id] ])->first();

            $result = $this->addExciseStamp_New($orderLine, $exciseStamp, $exciseStampBox);

            if ($result['error'])
            {
                return $result;
            }
        }

        //try{
            $orderPackLine = new OrderPackLine;
            $orderPackLine->order_id       = $this->id;
            $orderPackLine->line_id        = 1;
            $orderPackLine->product_code   = $exciseStampBox->productcode;
            $orderPackLine->f2reg_id       = $exciseStampBox->f2regid;
            $orderPackLine->pack_number    = $exciseStampBox->barcode;
            $orderPackLine->pallet_number  = $pallet_number;
            $orderPackLine->quantity       = 1;
            $orderPackLine->savedin1c      = false;
            $orderPackLine->save();
        //}
        //catch(\Exception $exception){
        //    $errorMessage = "Ошибка при записи " . $exciseStampBox->barcode;
        //
        //    return ['error' => true, 'errorMessage' => $errorMessage ];
        //}

        return ['error' => false, 'errorMessage' => ''];
    }

    private function addPalletExciseStamp_New($orderLine, $exciseStampPallet)
    {
        DB::beginTransaction();

        $linesPallet = $exciseStampPallet->exciseStampPalletLines;
        foreach ($linesPallet as $line)
        {
            $exciseStampBox = ExciseStampBox::find($line->box_id);

            $orderPackLine = OrderPackLine::where('pack_number', '=',  $exciseStampBox->barcode)->first();
            if ($orderPackLine != null) {
                $errorMessage = "Ящик в паллете уже сканировался " . $exciseStampBox->barcode;

                DB::rollBack();

                $this->addErrorLine($exciseStampBox->barcode, $orderPackLine->product_code, $orderPackLine->f2reg_id, $errorMessage);
                return ['error' => true, 'errorMessage' => $errorMessage ];
            }

            $result = $this->addPackStamp_New($orderLine, $exciseStampBox, $exciseStampPallet->barcode);

            if ($result['error'])
            {
                DB::rollBack();

                return $result;
            }
        }

        $orderPalletLine = new OrderPalletLine;
        $orderPalletLine->order_id      = $this->id;
        $orderPalletLine->f2reg_id      = $exciseStampPallet->f2regid;
        $orderPalletLine->pallet_number = $exciseStampPallet->barcode;
        $orderPalletLine->savedin1c     = false;
        $orderPalletLine->save();

        DB::commit();

        return ['error' => false, 'errorMessage' => ''];
    }

    private function addPalletExciseStamp($exciseStampPallet)
    {
        $orderPalletLine = OrderPalletLine::where('pallet_number', '=', $exciseStampPallet->barcode)->first();
        if ($orderPalletLine != null)
        {
            $errorMessage = "Паллет уже сканировался " . $exciseStampPallet->barcode;

            $this->addErrorLine($exciseStampPallet->barcode, '', $orderPalletLine->f2reg_id, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        $orderLine = $this->findLineF2RegId($exciseStampPallet->f2regid);
        if ($orderLine == null)
        {
            $errorMessage = "Разд Б " . $exciseStampPallet->f2regid . " не зайден в заказе";

            $this->addErrorLine($exciseStampPallet->barcode, '', $orderPalletLine->f2regid, $errorMessage);
        }

        $result = $this->addPalletExciseStamp_New($orderLine, $exciseStampPallet);

        return $result;

        //$collectionExciseStamp = $this->getCollectionExciseStamp($exciseStampPallet);
        //dd($collectionExciseStamp);
    }


    public function removeLineF2RegId($f2regid)
    {
        if($f2regid == null) { return; }

        OrderPalletLine::where([ ['order_id','=',$this->id], ['f2reg_id','=',$f2regid] ])->delete();
        OrderPackLine::where([ ['order_id','=',$this->id], ['f2reg_id','=',$f2regid] ])->delete();


        $updatedRows = OrderMarkLine::where([ ['order_id','=',$this->id], ['f2reg_id','=',$f2regid] ])
            ->update(['quantity' => 0, 'savedin1c'=> 0]);

        return $updatedRows;

        //$deletedRows = OrderMarkLine::where([ ['order_id','=',$this->id], ['f2reg_id','=',$f2regid] ])->delete();

        //return $deletedRows;
    }


    public function removeBarCode($barcode)
    {
        //СКАНИРОВАНИЕ АКЦИЗНОЙ МАРКИ, ЯЩИКА, ПАЛЛЕТА
        if (strlen($barcode) != 150 and strlen($barcode) != 68 and strlen($barcode) != 26 and strlen($barcode) != 18)
        {
            $errorMessage = "Не опознан ШК " . $barcode;

            $this->addErrorLine($barcode, '', '', $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }


        if (strlen($barcode) == 26 or strlen($barcode) == 18) {
            $errorMessage = "Удаление упаковок не реализовано " . $barcode;

            $this->addErrorLine($barcode, '', '', $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];

            //$exciseStampPallet = ExciseStampPallet::where('barcode', '=', $barcode)->first();
            //if ($exciseStampPallet == null) {
            //    $result = $this->addPackExciseStamp($barcode);
            //} else {
            //    $result = $this->addPalletExciseStamp($exciseStampPallet);
            //}
        } else {
            $result = $this->removeExciseStamp($barcode);
        }

        return $result;
    }

    private function removeExciseStamp($barcode)
    {
        //1. Ищем штрих код в уже набранных товарах в заказе, если находим ошибка.
        $orderMarkLine = OrderMarkLine::where( [['order_id', '=', $this->id],['markcode', '=', $barcode]] )->first();
        if ($orderMarkLine == null) {
            $errorMessage = "Марка не найдена в заказе " . $barcode;

            $this->addErrorLine($barcode, '', '', $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        /*

        DB::beginTransaction();

        try{
            $orderMarkLine = new OrderMarkLine;
            $orderMarkLine->order_id    = $this->id;
            $orderMarkLine->orderlineid = $orderLine->orderlineid;
            $orderMarkLine->productcode = $exciseStamp->productcode;
            $orderMarkLine->f2regid     = $exciseStamp->f2regid;
            $orderMarkLine->markcode    = $barcode;
            $orderMarkLine->boxnumber   = "000000000000000000000";
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

        */

        return ['error' => false, 'errorMessage' => ''];
    }


    private function getCollectionExciseStamp($exciseStampPallet)
    {
        $collectionExciseStamp = DB::table('excise_stamp_pallet')
            ->leftJoin('excise_stamp_pallet_line', 'excise_stamp_pallet.id', '=', 'excise_stamp_pallet_line.pallet_id')
            ->leftJoin('excise_stamp_boxes', 'excise_stamp_pallet_line.box_id', '=', 'excise_stamp_boxes.id')
            ->leftJoin('excise_stamp_box_lines', 'excise_stamp_boxes.id', '=', 'excise_stamp_box_lines.excise_stamp_box_id')
            ->leftJoin('excise_stamps', 'excise_stamp_box_lines.markcode', '=', 'excise_stamps.id')
            ->where('excise_stamp_pallet.id', '=', $exciseStampPallet->id )
            ->select('excise_stamp_pallet.id as pallet_ip',
                'excise_stamp_pallet.barcode as pallet_barcode',
                'excise_stamp_boxes.id as box_id',
                'excise_stamp_boxes.barcode as box_barcode',
                'excise_stamps.*')
            ->get();

        return $collectionExciseStamp;
    }

}
