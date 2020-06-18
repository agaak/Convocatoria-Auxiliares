<?php

use App\Merito;
use Illuminate\Database\Seeder;

class MeritoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Merito::create([
            'id_convocatoria' => 1,
            'id_submerito' => null,
            'descripcion_merito' => 'Primer Merito de la convocatoira',
            'porcentaje' => 50,
        ]);
        Merito::create([
            'id_convocatoria' => 1,
            'id_submerito' => 1,
            'descripcion_merito' => 'Primer subMerito de la convocatoira',
            'porcentaje' => 50,
        ]);
        Merito::create([
            'id_convocatoria' => 1,
            'id_submerito' => null,
            'descripcion_merito' => 'Segundo Merito de la convocatoira',
            'porcentaje' => 50,
        ]);
        Merito::create([
            'id_convocatoria' => 1,
            'id_submerito' => 3,
            'descripcion_merito' => 'SegundoPrimer subMerito de la convocatoira',
            'porcentaje' => 25,
        ]);
        Merito::create([
            'id_convocatoria' => 1,
            'id_submerito' => 3,
            'descripcion_merito' => 'SegundoSegundo subMerito de la convocatoira',
            'porcentaje' => 25,
        ]);
    }
}
