<?php

use Illuminate\Database\Seeder;
use App\Models\Tematica;

class TematicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Tematica::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '2',
            'nombre' => 'Introduccion a la Progra'
        ]);
        Tematica::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '2',
            'nombre' => 'Elementos y estructuras de datos'
        ]);
        Tematica::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '2',
            'nombre' => 'Computacion'
        ]);
        Tematica::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '2',
            'nombre' => 'Teoria de grafos'
        ]);
        Tematica::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '1',
            'nombre' => 'Linux Avanzado'
        ]);
        Tematica::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '1',
            'nombre' => 'Redes de Compuatadora'
        ]);
        Tematica::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '1',
            'nombre' => 'Base de datos'
        ]);
        Tematica::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '1',
            'nombre' => 'Mantenimiento de hardware'
        ]);

    }
}
