<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newItem = DB::table('categories')->insert(['id' => 1, 'descr' => 'Beer', 'code' => '0000001', 'version' => '1', 'isMark' => '0', 'parent_id' => 0, 'parent_code' => '']);
        DB::table('categories')->insert(['descr' => 'Baltika', 'code' => '0000004', 'version' => '1', 'ismark' => '0', 'parent_id' => 0, 'parent_code' => '0000001']);
        DB::table('categories')->insert(['descr' => 'SunInbev', 'code' => '0000005', 'version' => '1', 'ismark' => '0', 'parent_id' => 0, 'parent_code' => '0000001']);

        DB::table('categories')->insert(['descr' => 'Vodka', 'code' => '0000002', 'version' => '1', 'isMark' => '0', 'parent_id' => 0, 'parent_code' => '']);
        DB::table('categories')->insert(['descr' => 'Belenkay', 'code' => '0000006', 'version' => '1', 'isMark' => '0', 'parent_id' => 0, 'parent_code' => '0000002']);
        DB::table('categories')->insert(['descr' => 'Rosspiptprom', 'code' => '0000007', 'isMark' => '0', 'parent_id' => 0, 'parent_code' => '0000002']);

        DB::table('categories')->insert(['descr' => 'Juice', 'code' => '0000003', 'version' => '1', 'isMark' => '0', 'parent_id' => 0, 'parent_code' => '']);
        DB::table('categories')->insert(['descr' => 'WBD', 'code' => '0000008', 'version' => '1', 'isMark' => '0', 'parent_id' => 0, 'parent_code' => '0000003']);
        DB::table('categories')->insert(['descr' => 'My family', 'code' => '0000008', 'version' => '1', 'isMark' => '0', 'parent_id' => 0, 'parent_code' => '0000003']);


        //        $categories = [
//            [
//                "parent_id" => 0,
//                "code" => "mebfc",
//                "position" => 1,
//                "image" => "",
//                "color" => "#73492a",
//                "translate" => [
//                    "dk" => [
//                        "name" => "MIX EN BOKS FYLDTE CHOKOLADER",
//                        "sub_description" => "Med 12 fyldte chokolader & flГёdekarameller VГ¦lg 12 lГ¦kre stykker for 155 kr.",
//                        "short_description" => " Hold musen over stykket for mere info!"
//                    ],
//                    "en" => [
//                        "name" => "MIX A BOX FILLED CHOCOLADER",
//                        "sub_description" => "With 12 stuffed chocolates & cream karamels Choose 12 delicious pieces for 155 kr.",
//                        "short_description" => " Hold your mouse over the piece for more info!"
//                    ]
//                ]
//            ],
//            [
//                "parent_id" => 0,
//                "code" => "mebfc2",
//                "position" => 2,
//                "image" => "",
//                "color" => "#fef7ed",
//                "translate" => [
//                    "dk" => [
//                        "name" => "MIX EN BOKS FYLDTE CHOKOLADER",
//                        "sub_description" => "Med 6 fyldte chokolader & flГёdekarameller VГ¦lg 6 lГ¦kre stykker for 65 kr.",
//                        "short_description" => " Hold musen over stykket for mere info!"
//                    ],
//                    "en" => [
//                        "name" => "MIX A BOX FILLED CHOCOLADER",
//                        "sub_description" => "With 6 stuffed chocolates & cream karamels Choose 6 delicious pieces for 65 kr.",
//                        "short_description" => " Hold your mouse over the piece for more info!"
//                    ]
//                ]
//            ],
//            [
//                "parent_id" => 0,
//                "code" => "vc",
//                "position" => 3,
//                "image" => "public/image/pic.png",
//                "color" => "#422918",
//                "translate" => [
//                    "dk" => [
//                        "name" => "VARM CHOKOLADE",
//                        "sub_description" => "",
//                        "short_description" => "6 stk. varmechokolade stГ¦nger"
//                    ],
//                    "en" => [
//                        "name" => "HOT CHOCOLATE",
//                        "sub_description" => "",
//                        "short_description" => "6 pieces. hot chocolate bars"
//                    ]
//                ]
//            ],
//            [
//                "parent_id" => 0,
//                "code" => "ob",
//                "position" => 3,
//                "image" => "",
//                "color" => "#fd1f8c",
//                "translate" => [
//                    "dk" => [
//                        "name" => "ORIGINAL BEANS",
//                        "sub_description" => "",
//                        "short_description" => "59 kr. stk.- 3 stk. 155 kr."
//                    ],
//                    "en" => [
//                        "name" => "ORIGINAL BEANS",
//                        "sub_description" => "",
//                        "short_description" => "59 kr. pcs. 155 kr."
//                    ]
//                ]
//            ],
//            [
//                "parent_id" => 4,
//                "code" => "70g",
//                "position" => 3,
//                "image" => "",
//                "color" => "#fd1f8c",
//                "translate" => [
//                    "dk" => [
//                        "name" => "70 g. barer ",
//                        "sub_description" => "",
//                        "short_description" => "59 kr. stk.- 3 stk. 155 kr."
//                    ],
//                    "en" => [
//                        "name" => "70 g. Bars",
//                        "sub_description" => "",
//                        "short_description" => "59 kr. stk.- 3 stk. 155 kr."
//                    ]
//                ]
//            ],
//            [
//                "parent_id" => 4,
//                "code" => "12g",
//                "position" => 3,
//                "image" => "",
//                "translate" => [
//                    "dk" => [
//                        "name" => "12 g. barer",
//                        "sub_description" => "",
//                        "short_description" => "15 kr. stk. - 3 stk. 40 kr."
//                    ],
//                    "en" => [
//                        "name" => "12 g. Bars",
//                        "sub_description" => "",
//                        "short_description" => "15 kr. pcs. - 3 pcs. 40 kr."
//                    ]
//                ]
//            ],
//            [
//                "parent_id" => 4,
//                "code" => "200g",
//                "position" => 3,
//                "image" => "public/image/border.png",
//                "translate" => [
//                    "dk" => [
//                        "name" => "2000g. poser",
//                        "sub_description" => "",
//                        "short_description" => "110 kr. stk."
//                    ],
//                    "en" => [
//                        "name" => "2000g. to pose",
//                        "sub_description" => "",
//                        "short_description" => "110 kr. pcs."
//                    ]
//                ]
//            ],
//            [
//                "parent_id" => 4,
//                "code" => "2000g",
//                "position" => 3,
//                "image" => "",
//                "translate" => [
//                    "dk" => [
//                        "name" => "2000g. poser",
//                        "sub_description" => "",
//                        "short_description" => "500 - 626 kr"
//                    ],
//                    "en" => [
//                        "name" => "2000g. pose",
//                        "sub_description" => "",
//                        "short_description" => "500 - 626 kr "
//                    ]
//                ]
//            ]
//        ];
//
//        Category::truncate();
//        Translate::truncate();
//        $langs = Lang::get()->keyBy('code');
//
//        foreach($categories as $c) {
//            $category = new Category;
//            $category->parent_id = $c["parent_id"];
//            $category->name = "";
//            $category->code = $c["code"];
//            $category->position = $c["position"];
//            $category->image = $c["image"];
//            $category->color = ! empty($c["color"]) ? $c["color"] : "#ffffff";
//            $category->short_description = "";
//            $category->sub_description = "";
//            $category->save();
//
//            foreach($c["translate"] as $code => $lng) {
//                Translate::create([
//                    'table' => 'categories',
//                    'table_id' => $category->id,
//                    'langs_id' => $langs[$code]->id,
//                    'transalte' => json_encode($lng)
//                ]);
//            }
//        }

    }
}
