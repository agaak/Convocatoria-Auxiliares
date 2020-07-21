<?php

use App\Models\EventoImportante;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventoImportante::create([
            'id_convocatoria' => 1,
            'titulo_evento' => 'Presentación de Documentos',
            'lugar_evento' => '------------------------------------------',
            'fecha_inicio' => '2020-06-07',
            'fecha_final' => '2020-07-06'
        ]);
        EventoImportante::create([
            'id_convocatoria' => 1,
            'titulo_evento' => 'Revision de Rotulo',
            'lugar_evento' => 'Secretaría Informatica y Sistemas',
            'fecha_inicio' => '2020-06-22',
            'fecha_final' => '2020-07-01'
        ]);

        EventoImportante::create([
            'id_convocatoria' => 2,
            'titulo_evento' => 'Presentación de Documentos',
            'lugar_evento' => '------------------------------------------',
            'fecha_inicio' => '2020-11-11',
            'fecha_final' => '2020-12-12'
        ]);
        EventoImportante::create([
            'id_convocatoria' => 2,
            'titulo_evento' => 'Revision del rotulo del estudiante',
            'lugar_evento' => 'Secretaría Informatica y Sistemas',
            'fecha_inicio' => '2020-12-12',
            'fecha_final' => '2021-01-01'
        ]);
    }
}
