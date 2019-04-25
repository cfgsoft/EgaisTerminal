<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models\ExciseStamp\ExciseStamp;
use App\Models\ExciseStamp\ExciseStampBox;

class ReadBarCode extends Model
{
    protected $fillable = ['barcode', 'productcode', 'f1regid', 'f2regid'];

    public static function add($barcode)
    {
        $newbarcode = new static;
        $newbarcode->barcode = $barcode;

        //СКАНИРОВАНИЕ АКЦИЗНОЙ МАРКИ
        //101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI
        if (strlen($barcode) == 150 or strlen($barcode) == 68)
        {
            $exciseStamp = ExciseStamp::find($barcode);
            if ($exciseStamp != null) {
                $newbarcode->productcode = $exciseStamp->productcode;
                $newbarcode->f1regid     = $exciseStamp->f1regid;
                $newbarcode->f2regid     = $exciseStamp->f2regid;
            }
        }

        //СКАНИРОВАНИЕ ЯЩИКА
        if (strlen($barcode) == 26)
        {
            $exciseStampBox = ExciseStampBox::where('barcode', '=', $barcode)->first();
            if ($exciseStampBox != null)
            {
                $newbarcode->productcode = $exciseStampBox->productcode;
                $newbarcode->f1regid     = $exciseStampBox->f1regid;
                $newbarcode->f2regid     = $exciseStampBox->f2regid;
            }
        }

        $newbarcode->save();

        return $newbarcode;
    }

}
