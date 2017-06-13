<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        Validator::extend('is_valid_dni', function($attribute, $value, $parameters, $validator) {
            
            $dni = strtoupper($value);
 
            $letra = substr($dni, -1, 1);
            $numero = substr($dni, 0, 8);
         
            // Si es un NIE hay que cambiar la primera letra por 0, 1 ó 2 dependiendo de si es X, Y o Z.
            $numero = str_replace(array('X', 'Y', 'Z'), array(0, 1, 2), $numero);   
         
            $modulo = $numero % 23;
            $letras_validas = "TRWAGMYFPDXBNJZSQVHLCKE";
            $letra_correcta = substr($letras_validas, $modulo, 1);
         
            if($letra_correcta!=$letra) {
                return false;
            }
            else {
                return true;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
