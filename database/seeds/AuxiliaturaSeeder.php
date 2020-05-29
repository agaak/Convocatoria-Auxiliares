<?php

use Illuminate\Database\Seeder;
use App\Auxiliatura;
class AuxiliaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auxiliatura::create([
            'id_unidad_academica' => '1',
            'nombre_aux' => 'Introduccion a la Progra',
            'cod_aux' => 'INTRO'
        ]);
    }
}
