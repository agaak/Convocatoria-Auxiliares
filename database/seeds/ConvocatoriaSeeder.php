<?php

use App\Convocatoria;
use App\EventoImportante;
use App\Porcentaje;
use App\Documento;
use App\Requerimiento;
use App\Requisito;
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
            'creado'=> false,
            'fecha_inicio'=> '6/6/2020',
            'fecha_final'=> '7/7/2020'
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
            'porcentaje' => 90
        ]);

        Porcentaje::create([
            'id_requerimiento' => 2,
            'id_auxiliatura' => 6,
            'id_tematica' => 3, 
            'porcentaje' => 90
        ]);

        Porcentaje::create([
            'id_requerimiento' => 3,
            'id_auxiliatura' => 7,
            'id_tematica' => 3, 
            'porcentaje' => 90
        ]);
        
        Porcentaje::create([
            'id_requerimiento' => 1,
            'id_auxiliatura' => 5,
            'id_tematica' => 4, 
            'porcentaje' => 10
        ]);

        Porcentaje::create([
            'id_requerimiento' => 2,
            'id_auxiliatura' => 6,
            'id_tematica' => 4, 
            'porcentaje' => 10
        ]);

        Porcentaje::create([
            'id_requerimiento' => 3,
            'id_auxiliatura' => 7,
            'id_tematica' => 4, 
            'porcentaje' => 10
        ]);
    }
}
