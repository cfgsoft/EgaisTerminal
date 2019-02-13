<?php

use Illuminate\Database\Seeder;

use App\ExciseStampBox;
use App\ExciseStampBoxLine;

class ExciseStampTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('excise_stamp_box_lines')->delete();
        DB::table('excise_stamp_boxes')->delete();
        DB::table('excise_stamps')->delete();

        DB::table('excise_stamps')->insert(['id' => '101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237']);

        DB::table('excise_stamps')->insert(['id' => '111100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0123130000002476970', 'f1regid' => 'FA-000000039565812', 'f2regid' => 'FB-000001309598232']);

        DB::table('excise_stamps')->insert(['id' => '121100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0123130000002476973', 'f1regid' => 'FA-000000039565813', 'f2regid' => 'FB-000001309598228']);

        DB::table('excise_stamps')->insert(['id' => '131100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0123130000002476973', 'f1regid' => 'FA-000000039565813', 'f2regid' => 'FB-000001309598228']);

        DB::table('excise_stamps')->insert(['id' => '201100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237']);

        DB::table('excise_stamps')->insert(['id' => '301100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237']);

        DB::table('excise_stamps')->insert(['id' => '401100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237']);

        DB::table('excise_stamps')->insert(['id' => '501100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237']);

        DB::table('excise_stamps')->insert(['id' => '601100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237']);

        DB::table('excise_stamps')->insert(['id' => '701100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237']);

        DB::table('excise_stamps')->insert(['id' => '801100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237']);

        DB::table('excise_stamps')->insert(['id' => '901100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'productcode' => '0037150000001399460', 'f1regid' => 'FA-000000039597226', 'f2regid' => 'FB-000001309598237']);


        $boxs = [
            [
                'barcode' => '02000000029510118000087245',
                'productcode' => '0037150000001399460',
                'f1regid' => 'FA-000000039597226',
                'f2regid' => 'FB-000001309598237',
                'lines' => [
                    '1' => [
                        'markcode' => '401100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI'
                    ],
                    '2' => [
                        'markcode' => '501100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI'
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
            $exciseStampBox->save();

            foreach($b["lines"] as $l) {
                $exciseStampBoxLine = new ExciseStampBoxLine;
                $exciseStampBoxLine->excise_stamp_box_id = $exciseStampBox->id;
                $exciseStampBoxLine->markcode            = $l["markcode"];
                $exciseStampBoxLine->save();
            }
        }

    }
}
