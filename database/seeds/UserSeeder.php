<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'password' => bcrypt('admin123'),
            'email' => 'admin@gmail.com',
            'userToken' => '123456'
        ]);

        User::create([
            'name' => 'publica',
            'password' => bcrypt('publica123'),
            'email' => 'publica@gmail.com',
            'userToken' => '654321'
        ]);
    }

    /**
     *  INSERT INTO public.postulante(nombre, apellido, carrera, correo, ci)
	   * VALUES ('juan','tellez rojas','ing Sistemas', 'juante@outlook.com', 2647975);
       * 
        *INSERT INTO public.postulante(nombre, apellido, carrera, correo, ci)
	   * VALUES ('piter','anguila electirca','ing Sistemas', 'piter_la_anguila@gmail.com', 8703684);
       * 
        *INSERT INTO public.postulante(nombre, apellido, carrera, correo, ci)
       * VALUES ('carla','codina gomez','ing informatica', 'carcodi@gmial.com', 9743680);
       * 
        *INSERT INTO public.postulante(nombre, apellido, carrera, correo, ci)
       * VALUES ('silvia','cañas picon','ing Sistemas', 'silvicañas@outlook.com', 9800225);
       * 
        *INSERT INTO public.postulante(nombre, apellido, carrera, correo, ci)
       * VALUES ('juana','ordoñez picon','ing Sistemas', 'juanaordoñez@outlook.com', 9502887);
       * 
       * INSERT INTO public.calf_final_postulante_merito(
	    *id_convocatoria, id_postulante, nota_final_merito)
	    *VALUES (1, 1, 0);
        *INSERT INTO public.calf_final_postulante_merito(
	    *id_convocatoria, id_postulante, nota_final_merito)
	    *VALUES (1, 2, 0);	
        *INSERT INTO public.calf_final_postulante_merito(
	    *id_convocatoria, id_postulante, nota_final_merito)
	    *VALUES (1, 3, 0);
        *INSERT INTO public.calf_final_postulante_merito(
	    *id_convocatoria, id_postulante, nota_final_merito)
	    *VALUES (1, 4, 0);
        *INSERT INTO public.calf_final_postulante_merito(
	    *id_convocatoria, id_postulante, nota_final_merito)
	    *VALUES (1, 5, 0);
     */    
}
