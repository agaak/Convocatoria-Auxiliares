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
            'name' => 'admin',
            'password' => bcrypt('admin123'),
            'email' => 'admin@gmail.com',
            'userToken' => '123456',
            'unidad_academica_id' => 1
        ]);

       
        User::create([
            'name' => 'La Secre',
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

    } 
}
