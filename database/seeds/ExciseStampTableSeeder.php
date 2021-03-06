<?php

use Illuminate\Database\Seeder;

use App\Models\ExciseStamp\ExciseStampBox;
use App\Models\ExciseStamp\ExciseStampBoxLine;
use App\Models\ExciseStamp\ExciseStampPallet;
use App\Models\ExciseStamp\ExciseStampPalletLine;

class ExciseStampTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('excise_stamp_pallet_line')->delete();
        DB::table('excise_stamp_pallet')->delete();
        DB::table('excise_stamp_box_lines')->delete();
        DB::table('excise_stamp_boxes')->delete();
        DB::table('excise_stamps')->delete();
        DB::table('excise_stamp')->delete();

        DB::table('excise_stamp')->insert([
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237', 'department_id' => 1,
            'barcode' => '101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);

        DB::table('excise_stamp')->insert([
            'productcode' => '0123130000002476970', 'f1regid' => 'FA-000000039565812', 'f2regid' => 'FB-000001309598232', 'department_id' => 1,
            'barcode' => '111100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);

        DB::table('excise_stamp')->insert([
            'productcode' => '0123130000002476973', 'f1regid' => 'FA-000000039565813', 'f2regid' => 'FB-000001309598228', 'department_id' => 1,
            'barcode' => '121100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);

        DB::table('excise_stamp')->insert([
            'productcode' => '0123130000002476973', 'f1regid' => 'FA-000000039565813', 'f2regid' => 'FB-000001309598228', 'department_id' => 1,
            'barcode' => '131100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);

        DB::table('excise_stamp')->insert([
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237', 'department_id' => 1,
            'barcode' => '201100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);

        DB::table('excise_stamp')->insert([
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237', 'department_id' => 1,
            'barcode' => '301100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);

        DB::table('excise_stamp')->insert([
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237', 'department_id' => 1,
            'barcode' => '401100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);

        DB::table('excise_stamp')->insert([
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237', 'department_id' => 1,
            'barcode' => '501100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);

        DB::table('excise_stamp')->insert([
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237', 'department_id' => 1,
            'barcode' => '601100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);

        DB::table('excise_stamp')->insert([
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237', 'department_id' => 1,
            'barcode' => '701100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);

        DB::table('excise_stamp')->insert([
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237', 'department_id' => 1,
            'barcode' => '801100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);

        DB::table('excise_stamp')->insert([
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237', 'department_id' => 1,
            'barcode' => '901100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI']);


        $boxs = [
            [
                'barcode' => '02000000029510118000087245',
                'productcode' => '0037150000001399460',
                'f1regid' => 'FA-000000039597226',
                'f2regid' => 'FB-000001309598237',
                'department_id' => 1,
                'lines' => [
                    '1' => [
                        'markcode' => '401100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI'
                    ],
                    '2' => [
                        'markcode' => '501100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI'
                    ]
                ]
            ],
            [
                'barcode' => '01000000054710219024019879',
                'productcode' => '0037150000001399460',
                'f1regid' => 'FA-000000039597226',
                'f2regid' => 'FB-000001309598237',
                'department_id' => 1,
                'lines' => [
                    '1' => [
                        'markcode' => '601100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI'
                    ],
                    '2' => [
                        'markcode' => '701100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI'
                    ]
                ]
            ],
            [
                'barcode' => '04000000054710219024019879',
                'productcode' => '0037150000001399460',
                'f1regid' => 'FA-000000039597226',
                'f2regid' => 'FB-000001309598237',
                'department_id' => 1,
                'lines' => [
                    '1' => [
                        'markcode' => '801100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI'
                    ]
                ]
            ]
        ];

        $pallets = [
            [
                'barcode' => '03000000029510118000087245',
                'productcode' => '0037150000001399460',
                'f1regid' => 'FA-000000039597226',
                'f2regid' => 'FB-000001309598237',
                'department_id' => 1,
                'lines' => [
                    '1' => [
                        'markcode' => '01000000054710219024019879'
                    ],
                    '2' => [
                        'markcode' => '04000000054710219024019879'
                    ]
                ]
            ],
            [
                'barcode' => '05000000029510118000087245',
                'productcode' => '0037150000001399460',
                'f1regid' => 'FA-000000039597226',
                'f2regid' => 'FB-000001309598237',
                'department_id' => 1,
                'lines' => [
                    '1' => [
                        'markcode' => '02000000029510118000087245'
                    ]
                ]
            ]
        ];

        foreach($boxs as $b)
        {
            $exciseStampBox = new ExciseStampBox;
            $exciseStampBox->barcode = $b["barcode"];
            $exciseStampBox->productcode = $b["productcode"];
            $exciseStampBox->f1regid = $b["f1regid"];
            $exciseStampBox->f2regid = $b["f2regid"];
            $exciseStampBox->department_id = $b["department_id"];
            $exciseStampBox->save();

            foreach($b["lines"] as $l) {
                $exciseStampBoxLine = new ExciseStampBoxLine;
                $exciseStampBoxLine->excise_stamp_box_id = $exciseStampBox->id;
                $exciseStampBoxLine->markcode            = $l["markcode"];
                $exciseStampBoxLine->save();
            }
        }


        foreach($pallets as $p)
        {
            $exciseStampPallet = new ExciseStampPallet;
            $exciseStampPallet->barcode     = $p["barcode"];
            $exciseStampPallet->productcode = $p["productcode"];
            $exciseStampPallet->f1regid     = $p["f1regid"];
            $exciseStampPallet->f2regid     = $p["f2regid"];
            $exciseStampPallet->department_id = $p["department_id"];
            $exciseStampPallet->save();

            foreach($p["lines"] as $l) {
                $exciseStampBox = ExciseStampBox::where('barcode', '=', $l["markcode"])->first();

                $exciseStampPalletLine = new ExciseStampPalletLine;
                $exciseStampPalletLine->pallet_id = $exciseStampPallet->id;
                $exciseStampPalletLine->box_id = $exciseStampBox->id;
                $exciseStampPalletLine->save();
            }
        }

    }
}
