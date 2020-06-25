<?php

use App\Models\PrePostulante;
use App\Models\PrePostulanteAuxiliatura;
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

        $prePos1 = PrePostulante::create([
            'rotulo' => 12312310,
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
            'rotulo' => 12312311,
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
            'rotulo' => 12312312,
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
            'rotulo' =>12312313,
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
            'rotulo' =>12312314,
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
            'rotulo' => 12312315,
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
            'rotulo' => 12312316,
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
            'rotulo' => 12312317,
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
            'rotulo' =>12312318,
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
            'rotulo' => 12312319,
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

        $prePos11 = PrePostulante::create([
            'rotulo' => 12312320,
            'id_convocatoria' => 2,
            'nombre' => 'Antonio',
            'apellido' => 'Calderon Agreda',
            'direccion' => 'Cochabamba - Cercado',
            'correo' => 'antonio@gmail.com',
            'cod_sis' => '200009959',
            'telefono' => 76533859,
            'ci' => 1696326
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos11->id,
            'id_auxiliatura' => 1
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos11->id,
            'id_auxiliatura' => 2
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos11->id,
            'id_auxiliatura' => 3
        ]);

        $prePos12 = PrePostulante::create([
            'rotulo' => 12312321,
            'id_convocatoria' => 2,
            'nombre' => 'Miguel',
            'apellido' => 'Mamani Lopez',
            'direccion' => 'Tampoco see - Cochabamba',
            'correo' => 'miguel@gmail.com',
            'cod_sis' => '200909699',
            'telefono' => 77533859,
            'ci' => 4665926
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos12->id,
            'id_auxiliatura' => 3
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos12->id,
            'id_auxiliatura' => 4
        ]);

        $prePos13 = PrePostulante::create([
            'rotulo' => 12312322,
            'id_convocatoria' => 2,
            'nombre' => 'Rafael',
            'apellido' => 'Colque Canchari',
            'direccion' => 'Cochabamba - Ciudad',
            'correo' => 'rafael@gmail.com',
            'cod_sis' => '200803359',
            'telefono' => 79562509,
            'ci' => 4691326
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos13->id,
            'id_auxiliatura' => 1
        ]);

        $prePos14 = PrePostulante::create([
            'rotulo' => 12312323,
            'id_convocatoria' => 2,
            'nombre' => 'Antonia',
            'apellido' => 'Zanahoria Tomate',
            'direccion' => 'Cochabamba - Colcapirua',
            'correo' => 'antonia@gmail.com',
            'cod_sis' => '20163559',
            'telefono' => 77773859,
            'ci' => 9696326
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos14->id,
            'id_auxiliatura' => 2
        ]);

        $prePos15 = PrePostulante::create([
            'rotulo' => 12312324,
            'id_convocatoria' => 2,
            'nombre' => 'Sara',
            'apellido' => 'Laura Flores',
            'direccion' => 'Sipe Sipe',
            'correo' => 'sara@gmail.com',
            'cod_sis' => '201503955',
            'telefono' => 66663859,
            'ci' => 4615326
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos15->id,
            'id_auxiliatura' => 2
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos15->id,
            'id_auxiliatura' => 4
        ]);

        $prePos16 = PrePostulante::create([
            'rotulo' => 12312325,
            'id_convocatoria' => 2,
            'nombre' => 'Lucia',
            'apellido' => 'Torrico Lupe',
            'direccion' => 'Cercado',
            'correo' => 'lucia@gmail.com',
            'cod_sis' => '201609326',
            'telefono' => 66779859,
            'ci' => 4295391
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos16->id,
            'id_auxiliatura' => 1
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos16->id,
            'id_auxiliatura' => 3
        ]);

        $prePos17 = PrePostulante::create([
            'rotulo' => 12312326,
            'id_convocatoria' => 2,
            'nombre' => 'Dolores',
            'apellido' => 'Nuñez del Prado',
            'direccion' => 'Cercado - Aeropuerto',
            'correo' => 'dolores@gmail.com',
            'cod_sis' => '200405559',
            'telefono' => 76673859,
            'ci' => 4346123
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos17->id,
            'id_auxiliatura' => 3
        ]);

        $prePos18 = PrePostulante::create([
            'rotulo' => 12312327,
            'id_convocatoria' => 2,
            'nombre' => 'Paula',
            'apellido' => 'Colque Mamani',
            'direccion' => 'Zona Sur - Cercado',
            'correo' => 'paula@gmail.com',
            'cod_sis' => '201169959',
            'telefono' => 70003859,
            'ci' => 9292041
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos18->id,
            'id_auxiliatura' => 2
        ]);

        $prePos19 = PrePostulante::create([
            'rotulo' => 12312328,
            'id_convocatoria' => 2,
            'nombre' => 'Manuela',
            'apellido' => 'Alfonso Lopez',
            'direccion' => 'Vinto - Alto Milador',
            'correo' => 'manuela@gmail.com',
            'cod_sis' => '201862269',
            'telefono' => 70667859,
            'ci' => 6915326
        ]);

        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos19->id,
            'id_auxiliatura' => 1
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos19->id,
            'id_auxiliatura' => 3
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos19->id,
            'id_auxiliatura' => 4
        ]);

        $prePos20 = PrePostulante::create([
            'rotulo' => 12312329,
            'id_convocatoria' => 2,
            'nombre' => 'Jesus',
            'apellido' => 'Onofre Arrazola',
            'direccion' => 'Quillacollo - Vinto',
            'correo' => 'jesus@gmail.com',
            'cod_sis' => '201369459',
            'telefono' => 70066779,
            'ci' => 3659226
        ]);
        
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos20->id,
            'id_auxiliatura' => 2
        ]);
        PrePostulanteAuxiliatura::create([
            'id_pre_postulante' => $prePos20->id,
            'id_auxiliatura' => 3
        ]);
    }
}
