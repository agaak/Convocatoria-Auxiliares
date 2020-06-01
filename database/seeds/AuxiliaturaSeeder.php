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
            'id_tipo_convocatoria' => '2',
            'nombre_aux' => 'Introduccion a la Progra',
            'cod_aux' => 'INTRO'
        ]);

        Auxiliatura::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '2',
            'nombre_aux' => 'Elementos y estructuras de datos ',
            'cod_aux' => 'ELEM'
        ]);

        Auxiliatura::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '2',
            'nombre_aux' => 'Teoria de grafos',
            'cod_aux' => 'GRAF'
        ]);

        Auxiliatura::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '2',
            'nombre_aux' => 'Computacion',
            'cod_aux' => 'COMP'
        ]);

        Auxiliatura::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '1',
            'nombre_aux' => 'Administrador de Computo',
            'cod_aux' => 'ADM-ACO'
        ]);

        Auxiliatura::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '1',
            'nombre_aux' => 'Auxiliar de laboratorio de Computo',
            'cod_aux' => 'AUX-ACO'
        ]);

        Auxiliatura::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '1',
            'nombre_aux' => 'Auxiliar de Mantenimiento',
            'cod_aux' => 'AUX-MAN'
        ]);
        Auxiliatura::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '1',
            'nombre_aux' => 'Auxiliar de Redes',
            'cod_aux' => 'AUX-RED'
        ]);
    }
}
