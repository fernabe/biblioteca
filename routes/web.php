<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

        //Rutas usuario
            Route::get('/', function () {
                return redirect('/login');
            });

            Auth::routes();

            Route::get('/home', 'User\HomeController@index');


        //Rutas administrador
        
            Route::get('/admin', function () {
                return redirect('admin_login');
            });

            Route::get('/admin_home','Admin\HomeController@index');

            //Registration routes
            //Route::get('/admin_register','Admin\Auth\RegisterController@showRegistrationForm');
            Route::post('/admin_register','Admin\Auth\RegisterController@register')->name('admin_register');

            //Authentication routes
            Route::get('/admin_login', 'Admin\Auth\LoginController@showLoginForm')->name('admin_login');
            Route::post('/admin_login', 'Admin\Auth\LoginController@login');
            Route::post('/admin_logout', 'Admin\Auth\LoginController@logout')->name('admin_logout');

            // Admin Password Reset Routes...
            Route::get('/admin/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
            Route::post('/admin/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
            Route::get('/admin/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
            Route::post('/admin/password/reset', 'Admin\Auth\ResetPasswordController@reset');

        //Routes objetos

            Route::resource('/usuarios', 'Objetos\UsuarioController');
            Route::resource('/libros', 'Objetos\LibroController');
            Route::resource('/reservas', 'Objetos\ReservaController');
            Route::resource('/prestamos', 'Objetos\PrestamoController');
            Route::resource('/retrasos', 'Objetos\RetrasoController');

        //Rutas mensajes usuario

            Route::get('/reservas_fin/{id}', 'Objetos\MensajeController@showMensajesReservasFin');
            Route::get('/prestamos_fin/{id}', 'Objetos\MensajeController@showMensajesPrestamosFin');
            Route::get('/reservas_caducadas/{id}','Objetos\MensajeController@showReservasCaducadas');
            Route::put('/actualizar_avisos/{id}','Objetos\MensajeController@actualizarAvisos');

        //Rutas envio emails

            Route::post('envio','Mail\EnvioPassController@ship');