<?php

namespace App\Models\Inventory;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\ExciseStamp\ExciseStamp;
use App\Models\ExciseStamp\ExciseStampBox;
use App\Models\ExciseStamp\ExciseStampPallet;

use App\Models\Order\OrderMarkLine;

class Inventory extends Model
{
    protected $table = 'doc_inventory';

    protected $fillable = ['date', 'number', 'department_id'];

    public function inventoryLines(){
        return $this->hasMany("App\Models\Inventory\InventoryLine");
    }

    public function invoiceMarkLines(){
        return $this->hasMany("App\Models\Inventory\InventoryMarkLine");
    }

    public function invoicePackLines(){
        return $this->hasMany("App\Models\Inventory\InventoryPackLine");
    }

    public function invoicePalletLines(){
        return $this->hasMany("App\Models\Inventory\InventoryPalletLine");
    }

    public function invoiceErrorLines(){
        return $this->hasMany("App\Models\Inventory\InventoryErrorLine");
    }

    public static function add($fields)
    {
        $inventory = new static;
        $inventory->fill($fields);
        $inventory->date = Carbon::now();
        $inventory->number = '1';
        $inventory->department_id = 1;
        $inventory->save();

        return $inventory;
    }

    public function addBarCode($barcode, $department_id = 1)
    {
        //СКАНИРОВАНИЕ АКЦИЗНОЙ МАРКИ, ЯЩИКА, ПАЛЛЕТА
        if (strlen($barcode) != 150 and strlen($barcode) != 68 and strlen($barcode) != 26 and strlen($barcode) != 18)
        {
            $errorMessage = "Не опознан ШК " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
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

    private function addErrorLine($barcode, $errorMessage)
    {
        $inventoryErrorLine = new InventoryErrorLine;
        $inventoryErrorLine->inventory_id = $this->id;
        $inventoryErrorLine->mark_code    = $barcode;
        $inventoryErrorLine->message      = $errorMessage;
        $inventoryErrorLine->savedin1c    = 0;
        $inventoryErrorLine->save();

        return $inventoryErrorLine;
    }

    private function addExciseStamp($barcode, $department_id = 1)
    {
        $errorBarCode = false;
        $errorMessage = "";

        $exciseStamp = ExciseStamp::where([ ["barcode","=",$barcode],["department_id","=",$department_id] ])->first();
        if ($exciseStamp == null)
        {
            $errorMessage = "Не найдена марка в БД " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //2. Ищем штрих код в уже набранных товарах, если находим ошибка.
        $inventoryMarkLine = InventoryMarkLine::where( [['inventory_id', '=', $this->id],['mark_code', '=', $barcode]] )->first();
        if ($inventoryMarkLine != null)
        {
            $errorMessage = "Товар уже сканировался " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //3. Ищем товар в строке
        $inventoryLine = InventoryLine::where([
            ["inventory_id", "=", $this->id],
            ["f2reg_id",     "=", $exciseStamp->f2regid]
        ])->first();

        //4. Ищем товар в уже проданных заказах
        $order_id = null;
        $orderMarkLine = OrderMarkLine::where([['markcode',   '=', $barcode],
                                               ['quantity',   '=', '1'],
                                               ['f2reg_id',   '=', $exciseStamp->f2regid]
        ])->first();
        if ($orderMarkLine != null)
        {
            $order_id = $orderMarkLine->order_id;
        }


        DB::beginTransaction();

        try{
            $inventoryMarkLine = new InventoryMarkLine;
            $inventoryMarkLine->inventory_id  = $this->id;
            $inventoryMarkLine->product_code  = $exciseStamp->productcode;
            $inventoryMarkLine->f2reg_id      = $exciseStamp->f2regid;
            $inventoryMarkLine->mark_code     = $barcode;
            $inventoryMarkLine->quantity      = 1;
            $inventoryMarkLine->savedin1c     = false;
            if ($order_id != null) {
                $inventoryMarkLine->order_id  = $order_id;
            }
            $inventoryMarkLine->save();

            if ($inventoryLine == null)
            {
                $maxLine = InventoryLine::where('inventory_id', $this->id)->max('line_id');
                $maxLine++;

                $inventoryLine = new InventoryLine;
                $inventoryLine->inventory_id  = $this->id;
                $inventoryLine->line_id       = $maxLine;
                //$inventoryLine->product_id    = 0;
                $inventoryLine->product_descr = $exciseStamp->f2regid;
                $inventoryLine->product_code  = $exciseStamp->productcode;
                $inventoryLine->f2reg_id      = $exciseStamp->f2regid;
                $inventoryLine->quantity      = 1;
            } else {
                $inventoryLine->increment('quantity');
            }

            $inventoryLine->show_first = true;
            $inventoryLine->save();

            DB::commit();

        } catch(\Exception $exception){
            $errorBarCode = true;
            $errorMessage = "Ошибка при записи " . $barcode;

            DB::rollback();
        }

        if ($errorBarCode && strlen($barcode) > 0) {
            $this->addErrorLine($barcode, $errorMessage);

            return ['error' => $errorBarCode, 'errorMessage' => $errorMessage ];
        }

        return ['error' => false, 'errorMessage' => ''];
    }

    private function addPackExciseStamp($barcode, $department_id = 1)
    {

        return ['error' => false, 'errorMessage' => ''];
    }

    private function addPalletExciseStamp($exciseStampPallet)
    {

        return ['error' => false, 'errorMessage' => ''];
    }
}
