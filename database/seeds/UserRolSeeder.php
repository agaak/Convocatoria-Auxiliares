<?php

use Illuminate\Database\Seeder;
use App\Models\UserRol;

class UserRolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRol::create([
            'user_id' => 1,
            'role_id' => 1
        ]);
        
        UserRol::create([
            'user_id' => 2,
            'role_id' => 2
        ]);

        UserRol::create([
            'user_id' => 3,
            'role_id' => 3
        ]);
        //////////////////
        UserRol::create([
            'user_id' => 4,
            'role_id' => 1
        ]);
        
        UserRol::create([
            'user_id' => 5,
            'role_id' => 2
        ]);

        UserRol::create([
            'user_id' => 6,
            'role_id' => 3
        ]);
    }
}
