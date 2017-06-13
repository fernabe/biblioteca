@extends('user.layouts.app')

@section('content')

	<div>
		<!--Ventana modal con el fomulario para actualizar el perfil de usuario-->
		<verperfil id="ver-perfil" tabindex="-1" role="dialog" aria-labelledby="ver-perfil" aria-hidden="true" :usuario="{{ Auth::user() }}"></verperfil>
		<!--Div oculto que se muestra cuando actualizamos el perfil-->
	    <div id="perfil-actualizado" hidden class="alert alert-success">
	        <p><strong>Tus datos de usuario se han actualizado.</strong></p>
	    </div>
	    <!--Componente de vue que recibe un objeto con los datos del usuario y maneja sus avisos cuando tiene retrasos, reservas o prestamos caducados-->
	    <mensajes :usuario="{{ Auth::user() }}"></mensajes>
	</div>

	<!--Componente de vue que recibe al usuario y maneja el funcionamiento de la pagina principal-->
	<iniciousuario :usuario="{{ Auth::user() }}"></iniciousuario>

@endsection