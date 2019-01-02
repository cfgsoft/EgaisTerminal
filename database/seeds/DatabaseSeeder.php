<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ReadBarCodeTableSeeder::class);
        $this->call(OrderTableSeeder::class);

        factory(App\Order::class,100)->create();
        factory(App\OrderErrorLine::class,100)->create();

        //$this->call(CategoryTableSeeder::class);

        //$this->call([
        //    UsersTableSeeder::class,
        //    PostsTableSeeder::class,
        //    CommentsTableSeeder::class,
        //]);
    }
}
