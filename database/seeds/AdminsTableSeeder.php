<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'nombre' => 'Super Administrador',
            'email' => 'superadmin@labiblioteca.com',
            'tipo' => 'super',
            'password' => bcrypt('superadmin'),
        ]);
    }
}
