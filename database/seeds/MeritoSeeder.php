<?php

use App\Models\Calificacion_final;
use App\Models\Merito;
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
        Calificacion_final::create([
            'id_convocatoria' => 1,
            'porcentaje_merito' => 45,
            'porcentaje_conocimiento' => 55
        ]);

        Merito::create([
            'id_convocatoria' => 2,
            'id_submerito' => null,
            'descripcion_merito' => 'Primer Merito de la convocatoira de docencia',
            'porcentaje' => 50
        ]);
        Merito::create([
            'id_convocatoria' => 2,
            'id_submerito' => 6,
            'descripcion_merito' => 'Primer subMerito de la convocatoira de docencia',
            'porcentaje' => 25
        ]);
        Merito::create([
            'id_convocatoria' => 2,
            'id_submerito' => 6,
            'descripcion_merito' => 'PrimerSegundo subMerito de la convocatoira de docencia',
            'porcentaje' => 25
        ]);
        Merito::create([
            'id_convocatoria' => 2,
            'id_submerito' => null,
            'descripcion_merito' => 'Segundo Merito de la convocatoira de docencia',
            'porcentaje' => 50
        ]);
        Merito::create([
            'id_convocatoria' => 2,
            'id_submerito' => 9,
            'descripcion_merito' => 'SegundoPrimer subMerito de la convocatoira de docencia',
            'porcentaje' => 50
        ]);
        Calificacion_final::create([
            'id_convocatoria' => 2,
            'porcentaje_merito' => 30,
            'porcentaje_conocimiento' => 70
        ]);
    }
}
