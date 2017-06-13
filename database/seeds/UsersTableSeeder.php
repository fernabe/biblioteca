<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'nombre' => 'Usuario',
            'apellido1' => 'usuario1',
            'apellido2' => 'usuario2',
            'dni' => '14685744Z',
            'email' => 'usuario@gmail.com',
            'telefono' => 655211223,
            'direccion' => 'Calle del parque nº2',
            'poblacion' => 'Huesca',
            'password' => bcrypt('usuario'),
        ]);
    }
}
