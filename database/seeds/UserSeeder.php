<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EvaluadorConocimientos;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $eva = EvaluadorConocimientos::create([
            'ci' => '654321',
            'nombre' => 'Alan',
            'apellido' => 'Aguilar',
            'correo' => 'publica@gmail.com',
        ]);
        User::create([
            'name' => 'Jimmy Villarroel',
            'password' => bcrypt('admin123'),
            'email' => 'admin@gmail.com',
            'userToken' => '123456',
            'unidad_academica_id' => 1
        ]);

       
        User::create([
            'name' => 'Andrea M.',
            'password' => bcrypt('publica123'),
            'email' => 'sistema@gmail.com',
            'userToken' => '123123',
            'unidad_academica_id' => 1
        ]);

        User::create([
            'name' => 'Alan Aguilar',
            'password' => bcrypt('publica123'),
            'email' => 'publica@gmail.com',
            'userToken' => '654321',
            'unidad_academica_id' => 1
        ]);

        User::create([
            'name' => 'Jose Villarroel',
            'password' => bcrypt('admin123'),
            'email' => 'admin1234@gmail.com',
            'userToken' => '1234567',
            'unidad_academica_id' => 2
        ]);

       
        User::create([
            'name' => 'Mria Andrea',
            'password' => bcrypt('publica123'),
            'email' => 'sistema1234@gmail.com',
            'userToken' => '123123123',
            'unidad_academica_id' => 2
        ]);

        User::create([
            'name' => 'Alex Aguilar',
            'password' => bcrypt('publica123'),
            'email' => 'publica1234@gmail.com',
            'userToken' => '7654321',
            'unidad_academica_id' => 2
        ]);

    } 
}
