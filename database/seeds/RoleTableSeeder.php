<?php

use Illuminate\Database\Seeder;

use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::where('name', 'Admin')->first();
        if ($roleAdmin == null)
        {
            $roleAdmin = new Role();
            $roleAdmin->name = 'Admin';
            $roleAdmin->descr = 'A Admin User';
            $roleAdmin->save();
        }

        $roleAdminApi = Role::where('name', 'AdminAPI')->first();
        if ($roleAdminApi == null)
        {
            $roleAdminApi = new Role();
            $roleAdminApi->name = 'AdminAPI';
            $roleAdminApi->descr = 'A Admin API User';
            $roleAdminApi->save();
        }

    }
}
