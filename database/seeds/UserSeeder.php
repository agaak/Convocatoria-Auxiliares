<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'password' => bcrypt('admin123'),
            'email' => 'admin@gmail.com',
            'userToken' => '123456',
            'unidad_academica_id' => 1
        ]);

        User::create([
            'name' => 'Manuel Aguilar',
            'password' => bcrypt('publica123'),
            'email' => 'publica@gmail.com',
            'userToken' => '654321',
            'unidad_academica_id' => 1
        ]);
    } 
}
