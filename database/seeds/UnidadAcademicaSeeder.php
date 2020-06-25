<?php
use App\Models\UnidadAcademica;
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
        UnidadAcademica::create([
            'nombre' => 'Informática-Sistemas'
        ]);
        
        UnidadAcademica::create([
            'nombre' => 'Matemáticas '
        ]);
        
        UnidadAcademica::create([
            'nombre' => 'Química '
        ]);
        
        UnidadAcademica::create([
            'nombre' => 'Física'
        ]);
    }
}
