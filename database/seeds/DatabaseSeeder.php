<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables(['unidad_academica','tipo_convocatoria','auxiliatura',
        'tematica','area_calificacion','convocatoria','tipo_rol_evaluador','tipo_nota','roles','users',
        'user_rol', 'evento', 'merito', 'pre_postulante', 'pre_postulante_auxiliatura',
        'calificacion_final','postulante','postulante_auxiliatura','postulante_conovocatoria'
        ]);
        // $this->call(UsersTableSeeder::class);
        $this->call(UnidadAcademicaSeeder::class);
        $this->call(TipoConvocatoriaSeeder::class);
        $this->call(AuxiliaturaSeeder::class);
        $this->call(TematicaSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(ConvocatoriaSeeder::class);
        $this->call(TipoRolEvaluadorSeeder::class);
        $this->call(TipoNotaSeeder::class);
        $this->call(RolesSeed::class);
        $this->call(UserSeeder::class);
        $this->call(UserRolSeeder::class);
        $this->call(EventoSeeder::class);
        $this->call(MeritoSeeder::class);
        $this->call(PrePostulanteSeeder::class);
        
    }

    protected function truncateTables(array $tables){
        foreach($tables as $table){
            DB::table($table);
        }
    }
}
