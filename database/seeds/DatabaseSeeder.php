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
        $this->truncateTables(['unidad_academica','tipo_convocatoria','auxiliatura']);
        // $this->call(UsersTableSeeder::class);
        $this->call(UnidadAcademicaSeeder::class);
        $this->call(TipoConvocatoriaSeeder::class);
        $this->call(AuxiliaturaSeeder::class);
    }

    protected function truncateTables(array $tables){
        
        // DB::statement('SET FOREIGN_KEY_CHECKS =0;');
        // DB::statement('TRUNCATE users CASCAD E');
        foreach($tables as $table){
            DB::table($table);
        }

        // DB::statement('SET FOREIGN_KEY_CHECKS =1;');
    }
}
