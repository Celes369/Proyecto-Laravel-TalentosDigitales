<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class AddRolePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $rolAdmin = Role::create(['name'=>'Admin']);

       Permission::create(['name'=>'user.index']);
       Permission::create(['name'=>'user.edit']);
       Permission::create(['name'=>'user.show']);
       Permission::create(['name'=>'user.create']);
       Permission::create(['name'=>'user.destroy']);

       $rolAdmin->givePermissionTo([
            'user.index',
            'user.edit',
            'user.show',
            'user.create',
            'user.destroy',
       ]);

       $user = User::create([
        'name'   => 'newUser',
        'username'   => 'newUser',
        'email'   => 'newUser@gmail.com',
        'password'   => bcrypt('12345678')
    ]);

    $user->assignRole('Admin');

    }

}
