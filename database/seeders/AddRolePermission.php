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
        //Creacion de roles Admin, Client y User
       $rolAdmin = Role::create(['name'=>'Admin']);
       $rolClient = Role::create(['name'=>'Client']);
       $rolUser = Role::create(['name'=>'User']);

        //Creacion de permisos
       Permission::create(['name'=>'user.index']);
       Permission::create(['name'=>'user.edit']);
       Permission::create(['name'=>'user.show']);
       Permission::create(['name'=>'user.create']);
       Permission::create(['name'=>'user.destroy']);
       Permission::create(['name'=>'user.destroy']);

       //Asignacion de permisos a los roles
       $rolAdmin->givePermissionTo([
            'user.index',
            'user.edit',
            'user.show',
            'user.create',
            'user.destroy',
       ]);

       $rolCliente->givePermissionTo([
        'user.index',
        'user.edit',
        'user.show',
        'user.create',
        'user.destroy',
   ]);

   $rolUser->givePermissionTo([
    'user.index',
    'user.edit',
    'user.show',
    'user.create',
    'user.destroy',
]);
    //Creacion de usuarios 
    $userAdmin = User::create([
        'name'   => 'Admin1',
        'username'   => 'admin1',
        'email'   => 'admin1@gmail.com',
        'password'   => bcrypt('12345678')
    ]);

    $userCliente = User::create([
        'name'   => 'Cliente1',
        'username'   => 'cliente1',
        'email'   => 'cliente1@gmail.com',
        'password'   => bcrypt('12345678')
    ]);

    $user = User::create([
        'name'   => 'Visitante1',
        'username'   => 'visitante1',
        'email'   => 'visitante1@gmail.com',
        'password'   => bcrypt('12345678')
    ]);

    //Asignacion de roles a los usuarios
    $userAdmin->assignRole('Admin');
    $userCliente->assignRole('Client');
    $user->assignRole('User');

    }

}
