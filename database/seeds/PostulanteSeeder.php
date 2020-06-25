<?php

use App\Http\Controllers\Utils\ConvocatoriaComp;
use App\Models\Postulante;
use App\Models\Postulante_auxiliatura;
use App\Models\Postulante_req_aux;
use App\Models\Postulante_conovocatoria;
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

        // $postAux1 = Postulante_auxiliatura::create([
        //     'id_postulante' => $postulante1->id,
        //     'id_auxiliatura' => 5
        // ]);
        // $postAux2 = Postulante_auxiliatura::create([
        //     'id_postulante' => $postulante1->id,
        //     'id_auxiliatura' => 6
        // ]);
        // $postAux3 = Postulante_auxiliatura::create([
        //     'id_postulante' => $postulante1->id,
        //     'id_auxiliatura' => 7
        // ]);

        Postulante_conovocatoria::create([
            'id_postulante' => $postulante1->id,
            'id_convocatoria' => 1
        ]);
        
    }
}

