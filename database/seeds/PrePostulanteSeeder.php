<?php

use App\Http\Controllers\Utils\ConvocatoriaComp;
use App\PrePostulante;
use App\PrePostulanteAuxiliatura;
use Illuminate\Database\Seeder;

class PrePostulanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $codigo = new ConvocatoriaComp();

        $prePos1 = PrePostulante::create([
            'rotulo' => $codigo->uniqidReal(),
            'id_convocatoria' => 1,
            'nombre' => 'Alejando',
            'apellido' => 'Calderon Agreda',
            'direccion' => 'Cochabamba - Cercado',
            'correo' => 'alejando@gmail.com',
            'cod_sis' => '201609959',
            'telefono' => 68533859,
            'ci' => 4695326
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos1->id,
            'id_auxiliatura' => 5
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos1->id,
            'id_auxiliatura' => 6
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos1->id,
            'id_auxiliatura' => 7
        ]);

        $prePos2 = PrePostulante::create([
            'rotulo' => $codigo->uniqidReal(),
            'id_convocatoria' => 1,
            'nombre' => 'Karen',
            'apellido' => 'Mamani Lopez',
            'direccion' => 'Tampoco see - Cochabamba',
            'correo' => 'kare@gmail.com',
            'cod_sis' => '201209959',
            'telefono' => 78533859,
            'ci' => 4695926
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos2->id,
            'id_auxiliatura' => 6
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos2->id,
            'id_auxiliatura' => 7
        ]);

        $prePos3 = PrePostulante::create([
            'rotulo' => $codigo->uniqidReal(),
            'id_convocatoria' => 1,
            'nombre' => 'Alejandro',
            'apellido' => 'Colque Canchari',
            'direccion' => 'Cochabamba - Ciudad',
            'correo' => 'alejandro.otro@gmail.com',
            'cod_sis' => '201009959',
            'telefono' => 72533859,
            'ci' => 4695329
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos3->id,
            'id_auxiliatura' => 5
        ]);

        $prePos4 = PrePostulante::create([
            'rotulo' => $codigo->uniqidReal(),
            'id_convocatoria' => 1,
            'nombre' => 'Gustavo',
            'apellido' => 'Zanahoria Tomate',
            'direccion' => 'Cochabamba - Colcapirua',
            'correo' => 'gustavo@gmail.com',
            'cod_sis' => '201209959',
            'telefono' => 67533859,
            'ci' => 9695326
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos4->id,
            'id_auxiliatura' => 7
        ]);

        $prePos5 = PrePostulante::create([
            'rotulo' => $codigo->uniqidReal(),
            'id_convocatoria' => 1,
            'nombre' => 'Elias',
            'apellido' => 'Laura Flores',
            'direccion' => 'Sipe Sipe',
            'correo' => 'elias@gmail.com',
            'cod_sis' => '201609955',
            'telefono' => 73533859,
            'ci' => 4695366
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos5->id,
            'id_auxiliatura' => 5
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos5->id,
            'id_auxiliatura' => 6
        ]);

        $prePos6 = PrePostulante::create([
            'rotulo' => $codigo->uniqidReal(),
            'id_convocatoria' => 1,
            'nombre' => 'Carlos',
            'apellido' => 'Torrico Lupe',
            'direccion' => 'Cercado',
            'correo' => 'carlos@gmail.com',
            'cod_sis' => '201609326',
            'telefono' => 65539859,
            'ci' => 4695399
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos6->id,
            'id_auxiliatura' => 6
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos6->id,
            'id_auxiliatura' => 7
        ]);

        $prePos7 = PrePostulante::create([
            'rotulo' => $codigo->uniqidReal(),
            'id_convocatoria' => 1,
            'nombre' => 'Erwin',
            'apellido' => 'Nuñez del Prado',
            'direccion' => 'Cercado - Aeropuerto',
            'correo' => 'erwin@gmail.com',
            'cod_sis' => '201909959',
            'telefono' => 79533859,
            'ci' => 4695333
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos7->id,
            'id_auxiliatura' => 6
        ]);

        $prePos8 = PrePostulante::create([
            'rotulo' => $codigo->uniqidReal(),
            'id_convocatoria' => 1,
            'nombre' => 'Diego',
            'apellido' => 'Colque Mamani',
            'direccion' => 'Zona Sur - Cercado',
            'correo' => 'diego@gmail.com',
            'cod_sis' => '201809959',
            'telefono' => 70533859,
            'ci' => 9895326
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos8->id,
            'id_auxiliatura' => 6
        ]);

        $prePos9 = PrePostulante::create([
            'rotulo' => $codigo->uniqidReal(),
            'id_convocatoria' => 1,
            'nombre' => 'Jaime',
            'apellido' => 'Alfonso Lopez',
            'direccion' => 'Vinto - Alto Milador',
            'correo' => 'jaime@gmail.com',
            'cod_sis' => '201509269',
            'telefono' => 71533859,
            'ci' => 5695326
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos9->id,
            'id_auxiliatura' => 5
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos9->id,
            'id_auxiliatura' => 6
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos9->id,
            'id_auxiliatura' => 7
        ]);

        $prePos10 = PrePostulante::create([
            'rotulo' => $codigo->uniqidReal(),
            'id_convocatoria' => 1,
            'nombre' => 'Francisco',
            'apellido' => 'Onofre Arrazola',
            'direccion' => 'Quillacollo - Vinto',
            'correo' => 'francisco@gmail.com',
            'cod_sis' => '201009959',
            'telefono' => 73533859,
            'ci' => 3695326
        ]);
        
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos10->id,
            'id_auxiliatura' => 6
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos10->id,
            'id_auxiliatura' => 7
        ]);
    }
}
