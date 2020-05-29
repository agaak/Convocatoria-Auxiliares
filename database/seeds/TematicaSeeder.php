<?php

use Illuminate\Database\Seeder;
use App\Tematica;

class TematicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tematica::create([
            'nombre' => 'Examen escrito'
        ]);
        Tematica::create([
            'nombre' => 'Examen oral'
        ]);
        Tematica::create([
            'nombre' => 'Linux Avanzado'
        ]);
        Tematica::create([
            'nombre' => 'Redes de Compuatadora'
        ]);
        Tematica::create([
            'nombre' => 'Base de datos'
        ]);
        Tematica::create([
            'nombre' => 'Mantenimiento de hardware'
        ]);

    }
}
