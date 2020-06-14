<?php

use Illuminate\Database\Seeder;
use App\Role;
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
            'name' => 'evaluador',
            'description' => 'Evaluador de convocatoria'
        ]);
    }
}
