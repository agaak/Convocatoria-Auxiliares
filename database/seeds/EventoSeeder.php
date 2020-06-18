<?php

use App\EventoImportante;
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
            'titulo_evento' => 'Entrega de documentos',
            'lugar_evento' => 'Laboratorio Informatica y Sistemas',
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
    }
}
