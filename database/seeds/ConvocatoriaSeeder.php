<?php

use App\Models\Convocatoria;
use App\Models\EventoImportante;
use App\Models\Porcentaje;
use App\Models\Documento;
use App\Models\Requerimiento;
use App\Models\Requisito;
use Illuminate\Database\Seeder;

class ConvocatoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Convocatoria::create([
            'id_unidad_academica' => 1,              
            'id_tipo_convocatoria'=> 1,
            'titulo'=> 'Convocatoria de Laboratorios de INF-SIS',
            'descripcion_convocatoria'=> 'El Departamento de Informática y Sistemas junto a las Carreras de Ing. Informática e Ing.
            De Sistemas de la Facultad de Ciencias y Tecnología, convoca al concurso de méritos y
            examen de competencia para la provisión de Auxiliares del Departamento, tomando como
            base los requerimientos que se tienen programados para la gestión 2020. ',
            'gestion'=> 2020,
            'publicado'=> false,
            'finalizado' => false,
            'creado'=> false,
            'fecha_inicio'=> '7/7/2020',
            'fecha_final'=> '8/8/2020'
        ]);

        Requerimiento::create([
            'id_convocatoria' =>  1,
            'id_auxiliatura' => 5,
            'horas_mes' => 80,
            'cant_aux' => 2
        ]);
        Requerimiento::create([
            'id_convocatoria' =>  1,
            'id_auxiliatura' => 6,
            'horas_mes' => 60,
            'cant_aux' => 1
        ]);
        Requerimiento::create([
            'id_convocatoria' =>  1,
            'id_auxiliatura' => 7,
            'horas_mes' => 70,
            'cant_aux' => 3
        ]);
        
        Requisito::create([
            'id_convocatoria' =>  1,
            'descripcion' => "Ser estudiante regular y con rendimiento de las carreras de Licenciatura en Ingeniería
            Informática o Licenciatura en Ingeniería de Sistemas y/o afín, que cursa regularmente en la
            universidad. Para administrador de Laboratorio de Mantenimiento de Hardware podrán
            presentarse además estudiantes de Ing. Electrónica. Estudiante regular es aquel que está
            inscrito en la gestión académica vigente y cumple los requisitos exigidos para seguir una
            carrera universitaria y el rendimiento académico, haber aprobado más de la mitad de las
            materias curriculares que corresponde al semestre anterior, certificado por el
            departamento de Registros e Inscripciones. "
        ]);
        
        Requisito::create([
            'id_convocatoria' =>  1,
            'descripcion' => "Para administrador de Laboratorio de Mantenimiento de Hardware podrán
            presentarse además estudiantes de Ing. Electrónica. Estudiante regular es aquel que está
            inscrito en la gestión académica vigente y cumple los requisitos exigidos para seguir una
            carrera universitaria y el rendimiento académico, haber aprobado más de la mitad de las
            materias curriculares que corresponde al semestre anterior, certificado por el
            departamento de Registros e Inscripciones. "
        ]);

        Requisito::create([
            'id_convocatoria' =>  1,
            'descripcion' => "La Universidad Mayor de San Simon o de cualquier otra del Sistema de la Universidad Boliviana
            (RCU No. 63/2018). Aún en caso de encontrarse cursando otra carrera con
            admisión especial."
        ]);

        Documento::create([
            'id_convocatoria' =>  1,
            'descripcion' => "Presentar solicitud escrita dirigida a la Jefatura de Departamento de Informática y Sistemas
            especificando claramente la(s) auxiliatura(s) a la(s) que se postula:
            - Código de auxiliatura
            - Nombre de la auxiliatura. "
        ]);
        


        Porcentaje::create([
            'id_requerimiento' => 1,
            'id_auxiliatura' => 5,
            'id_tematica' => 3, 
            'id_area' => 1, 
            'porcentaje' => 90
        ]);

        Porcentaje::create([
            'id_requerimiento' => 2,
            'id_auxiliatura' => 6,
            'id_tematica' => 3, 
            'id_area' => 1, 
            'porcentaje' => 90
        ]);

        Porcentaje::create([
            'id_requerimiento' => 3,
            'id_auxiliatura' => 7,
            'id_tematica' => 3,
            'id_area' => 1,  
            'porcentaje' => 90
        ]);
        
        Porcentaje::create([
            'id_requerimiento' => 1,
            'id_auxiliatura' => 5,
            'id_tematica' => 4,
            'id_area' => 1,  
            'porcentaje' => 10
        ]);

        Porcentaje::create([
            'id_requerimiento' => 2,
            'id_auxiliatura' => 6,
            'id_tematica' => 4,
            'id_area' => 1,  
            'porcentaje' => 10
        ]);

        Porcentaje::create([
            'id_requerimiento' => 3,
            'id_auxiliatura' => 7,
            'id_tematica' => 4,
            'id_area' => 1,  
            'porcentaje' => 10
        ]);

        Convocatoria::create([
            'id_unidad_academica' => 1,              
            'id_tipo_convocatoria'=> 2,
            'titulo'=> 'Convocatoria para optar a Auxiliatura de Docencia',
            'descripcion_convocatoria'=> 'Se precisa auxiliatura de docencia para la Carreras de Ing. Informática e Ing.
            De Sistemas de la Facultad de Ciencias y Tecnología, convoca al concurso de méritos y
            examen de competencia para la provisión de Auxiliares de Docencia, tomando como
            base los requerimientos que se tienen programados para la gestión 2021.',
            'gestion'=> 2021,
            'publicado'=> false,
            'finalizado' => false,
            'creado'=> false,
            'fecha_inicio'=> '06/06/2020',
            'fecha_final'=> '08/08/2021'
        ]);

        $idReq1 = Requerimiento::create([
            'id_convocatoria' =>  2,
            'id_auxiliatura' => 1,
            'horas_mes' => 80,
            'cant_aux' => 4
        ]);
        $idReq2 = Requerimiento::create([
            'id_convocatoria' =>  2,
            'id_auxiliatura' => 2,
            'horas_mes' => 70,
            'cant_aux' => 3
        ]);
        $idReq3 = Requerimiento::create([
            'id_convocatoria' =>  2,
            'id_auxiliatura' => 3,
            'horas_mes' => 50,
            'cant_aux' => 1
        ]);
        $idReq4 = Requerimiento::create([
            'id_convocatoria' =>  2,
            'id_auxiliatura' => 4,
            'horas_mes' => 40,
            'cant_aux' => 1
        ]);

        Requisito::create([
            'id_convocatoria' =>  2,
            'descripcion' => "Queda expresamente prohibido la participación de estudiantes que hubiesen
            obtenido ya un título profesional en alguna de las carreras de la Universidad
            Mayor de San Simon o de cualquier otra del Sistema de la Universidad Boliviana
            (RCU No. 63/2018). Aún en caso de encontrarse cursando otra carrera con
            admisión especial. (Certificación emitida por el Departamento de Registros e
            Inscripciones)."
        ]);

        Requisito::create([
            'id_convocatoria' =>  2,
            'descripcion' => "Prohibido la participación de estudiantes que hubiesen
            obtenido ya un título profesional en alguna de las carreras de la Universidad
            Mayor de San Simon o de cualquier otra del Sistema de la Universidad Boliviana
            (RCU No. 63/2018). Aún en caso de encontrarse cursando otra carrera con
            admisión especial."
        ]);

        Requisito::create([
            'id_convocatoria' =>  2,
            'descripcion' => "La Universidad Mayor de San Simon o de cualquier otra del Sistema de la Universidad Boliviana
            (RCU No. 63/2018). Aún en caso de encontrarse cursando otra carrera con
            admisión especial."
        ]);

        
        Documento::create([
            'id_convocatoria' =>  2,
            'descripcion' => "Kardex actualizado a la gestión 1/2019 (periodos cumplidos a la fecha), expedido
            por Oficina de Kardex de la Facultad de Ciencias y Tecnología."
        ]);

        Porcentaje::create([
            'id_requerimiento' => $idReq1->id,
            'id_auxiliatura' => 1,
            'id_tematica' => 1,
            'id_area' => 3,  
            'porcentaje' => 60
        ]);
        Porcentaje::create([
            'id_requerimiento' => $idReq1->id,
            'id_auxiliatura' => 1,
            'id_tematica' => 2,
            'id_area' => 3,  
            'porcentaje' => 40
        ]);

        Porcentaje::create([
            'id_requerimiento' => $idReq2->id,
            'id_auxiliatura' => 2,
            'id_tematica' => 1,
            'id_area' => 3,  
            'porcentaje' => 20
        ]);
        Porcentaje::create([
            'id_requerimiento' => $idReq2->id,
            'id_auxiliatura' => 2,
            'id_tematica' => 2,
            'id_area' => 3,  
            'porcentaje' => 80
        ]);

        Porcentaje::create([
            'id_requerimiento' => $idReq3->id,
            'id_auxiliatura' => 3,
            'id_tematica' => 1,
            'id_area' => 3,  
            'porcentaje' => 50
        ]);
        Porcentaje::create([
            'id_requerimiento' => $idReq3->id,
            'id_auxiliatura' => 3,
            'id_tematica' => 2,
            'id_area' => 3,  
            'porcentaje' => 50
        ]);

        Porcentaje::create([
            'id_requerimiento' => $idReq4->id,
            'id_auxiliatura' => 4,
            'id_tematica' => 1,
            'id_area' => 3,  
            'porcentaje' => 70
        ]);
        Porcentaje::create([
            'id_requerimiento' => $idReq4->id,
            'id_auxiliatura' => 4,
            'id_tematica' => 2,
            'id_area' => 3,  
            'porcentaje' => 30
        ]);
    }
}
