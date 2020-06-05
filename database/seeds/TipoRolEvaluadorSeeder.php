<?php

use App\Tipo_rol_evaluador;
use Illuminate\Database\Seeder;

class TipoRolEvaluadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipo_rol_evaluador::create([
            'nombre' => 'Meritos'
        ]);
        
        Tipo_rol_evaluador::create([
            'nombre' => 'Conocimientos'
        ]);
    }
}
