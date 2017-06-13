<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
</head>
<body>

<div></div>
<h2>LaBiblioteca</h2>
<p>Bienvenido a LaBiblioteca</p>
<p>Nombre: {{$nombre}}</p>
<p>Apellido: {{$apellido1}}</p>
<p>Correo Electrónico: {{$email}}</p>
<p>Contraseña: {{$password}}</p>
<p>Puedes acceder con tu email y contraseña desde <a href="{{ url('/login') }}">aquí</a>

</body>
</html>
