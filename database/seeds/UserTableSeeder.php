<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdminApi = Role::where('name', 'AdminAPI')->first();

        $adminApi = User::firstOrNew(['email' => 'AdminApi@example.com']);
        if (!$adminApi->exists) {
            $adminApi->name = 'Admin Api';
            $adminApi->email = 'AdminApi@example.com';
            $adminApi->password = bcrypt('secret');
            $adminApi->save();
            $adminApi->roles()->attach($roleAdminApi);
        }

        //$adminApi = new User();
        //$adminApi->name = 'Admin Api';
        //$adminApi->email = 'AdminApi@example.com';
        //$adminApi->password = bcrypt('secret');
        //$adminApi->save();
        //$adminApi->roles()->attach($roleAdminApi);
    }
}
