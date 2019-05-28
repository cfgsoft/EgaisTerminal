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
        $appDebug = config('app.debug');

        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);

        if ($appDebug) {
            $this->call(ProductEgaisTableSeeder::class);
            $this->call(ExciseStampTableSeeder::class);
            $this->call(ReadBarCodeTableSeeder::class);
            //$this->call(CategoryTableSeeder::class);

            $this->call(OrderTableSeeder::class);
            $this->call(InvoiceTableSeeder::class);
            $this->call(ReturnedInvoiceTableSeeder::class);

            $this->call(InventorySeeder::class);
            $this->call(DepartmentTableSeeder::class); //Depends on inventory

            factory(App\Models\Order\Order::class,3)->create();
            //factory(App\Models\Order\OrderErrorLine::class,100)->create();
            //factory(App\Models\Invoice\Invoice::class,10)->create();

            factory(App\Models\Inventory\Inventory::class,1)->create();

            //$this->call([
            //    UsersTableSeeder::class,
            //    PostsTableSeeder::class,
            //    CommentsTableSeeder::class,
            //]);
        }
    }
}
