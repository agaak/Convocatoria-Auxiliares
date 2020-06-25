<?php
use App\Models\Tipo;
use Illuminate\Database\Seeder;

class TipoConvocatoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Tipo::create([
            'nombret_tipo' => 'Conv. Laboratorio'
        ]);
        
        Tipo::create([
            'nombret_tipo' => 'Conv. Docencia'
        ]);
    }
}
