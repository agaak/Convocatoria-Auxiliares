<?php

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
            'id_unidad_academica' => '1',
            'id_tipo_convocatoria' => '2',
            'nombre' => 'Examen escrito'
        ]);
    }
}
