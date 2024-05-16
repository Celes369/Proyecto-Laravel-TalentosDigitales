<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'CeSeeder',
            'username' => 'CeSeeder',
            'email' => 'cseeder@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
