<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
class RolesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'administrador',
            'description' => 'Administrador del sistema de convocatorias'
        ]);

        Role::create([
            'name' => 'receptor documentos',
            'description' => 'Receptor de documentos de postulantes'
        ]);

        Role::create([
            'name' => 'evaluador',
            'description' => 'Evaluador de convocatoria'
        ]);
    }
}
