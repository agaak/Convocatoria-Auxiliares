<?php

use App\Http\Controllers\Utils\ConvocatoriaComp;
use App\Postulante;
use App\Postulante_auxiliatura;
use App\Postulante_conovocatoria;
use Illuminate\Database\Seeder;

class PostulanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $postulante1 = Postulante::create([
            'nombre' => 'Alejando',
            'apellido' => 'Calderon Agreda',
            'direccion' => 'Cochabamba - Cercado',
            'correo' => 'alejando@gmail.com',
            'cod_sis' => '201609959',
            'telefono' => 68533859,
            'ci' => 4695326
        ]);

        Postulante_auxiliatura::create([
            'id_postulante' => $postulante1->id,
            'id_auxiliatura' => 5
        ]);
        Postulante_auxiliatura::create([
            'id_postulante' => $postulante1->id,
            'id_auxiliatura' => 6
        ]);
        Postulante_auxiliatura::create([
            'id_postulante' => $postulante1->id,
            'id_auxiliatura' => 7
        ]);

        Postulante_conovocatoria::create([
            'id_postulante' => $postulante1->id,
            'id_convocatoria' => 1
        ]);
    }
}

