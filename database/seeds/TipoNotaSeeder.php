<?php

use App\Models\TipoNota;
use Illuminate\Database\Seeder;

class TipoNotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoNota::create([
            'nombre_tipo' => 'requisitos'
        ]);
        
        TipoNota::create([
            'nombre_tipo' => 'documentos'
        ]);
    }
}
