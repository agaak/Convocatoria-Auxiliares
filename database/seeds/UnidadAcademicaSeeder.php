<?php
use App\Unidad_Academica;
use Illuminate\Database\Seeder;

class UnidadAcademicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Unidad_Academica::create([
            'departament_conv' => 'Informática-Sistemas'
        ]);
        
        Unidad_Academica::create([
            'departament_conv' => 'Matemáticas '
        ]);
        
        Unidad_Academica::create([
            'departament_conv' => 'Química '
        ]);
        
        Unidad_Academica::create([
            'departament_conv' => 'Física'
        ]);
    }
}
