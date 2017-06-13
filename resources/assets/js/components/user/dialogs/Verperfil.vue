<template>

<div class="modal fade text-center">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
		    	<h2 class="modal-title">Perfil usuario</h2>
		    </div>
		    <div class="modal-body">
			    <form v-if="verPerfil" class="form-horizontal">
			    	
			    	<div class="form-group">
	                    <label for="nombre" class="col-sm-4 control-label">Nombre:</label>
	                    <div class="col-sm-6">
	                       <input type="text" class="form-control" name="nombre" :value="usuario.nombre" style="border:none" readonly>
	                    </div>
	                </div>

	               <div class="form-group">
	                    <label for="apellido1" class="col-sm-4 control-label">Apellido1:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="apellido1" :value="usuario.apellido1" style="border:none" readonly>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="apellido2" class="col-sm-4 control-label">Apellido2:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="apellido2" :value="usuario.apellido2" style="border:none" readonly>  
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="dni" class="col-sm-4 control-label">Dni:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="dni" :value="usuario.dni" style="border:none" readonly>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="email" class="col-sm-4 control-label">Email:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="text" :value="usuario.email" style="border:none" readonly>    
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="telefono" class="col-sm-4 control-label">Teléfono:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="telefono" :value="usuario.telefono" style="border:none" readonly>    
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="direccion" class="col-sm-4 control-label">Dirección:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="direccion" :value="usuario.direccion" style="border:none" readonly>  
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="poblacion" class="col-sm-4 control-label">Población:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="poblacion" :value="usuario.poblacion" style="border:none" readonly>     
	                    </div>
	                </div>

	                <div class="form-group">
			   			<button id="cancelar" type="button" class="btn btn-danger" data-dismiss="modal">Volver</button>
		    			<button type="button" class="btn btn-success" @click="mostrarEditar">Editar Perfil</button>
		    		</div>  
			    </form>

			    <form v-else class="form-horizontal" role="form" method="POST" @submit.prevent=onSubmit @keydown="errors.clear($event.target.name)">
			    	
			    	<div class="form-group" :class="{'has-error': errors.get('nombre') }">
	                    <label for="nombre" class="col-sm-4 control-label">Nombre:</label>
	                    <div class="col-sm-6">
	                        <input id="input-nombre" type="text" class="form-control" name="nombre" v-model="datosUsuario.nombre">
	                        <span class="help-block" v-if="errors.get('nombre')"><strong>{{ errors.get('nombre') }}</strong></span>    
	                    </div>
	                </div>

	               <div class="form-group" :class="{'has-error': errors.get('apellido1') }">
	                    <label for="nombre" class="col-sm-4 control-label">Apellido1:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="apellido1" v-model="datosUsuario.apellido1">
	                        <span class="help-block" v-if="errors.get('apellido1')"><strong>{{ errors.get('apellido1') }}</strong></span>    
	                    </div>
	                </div>

	                <div class="form-group" :class="{'has-error': errors.get('apellido2') }">
	                    <label for="nombre" class="col-sm-4 control-label">Apellido2:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="apellido2" v-model="datosUsuario.apellido2">
	                        <span class="help-block" v-if="errors.get('apellido2')"><strong>{{ errors.get('apellido2') }}</strong></span>    
	                    </div>
	                </div>

	                <div class="form-group" :class="{'has-error': errors.get('dni') }">
	                    <label for="nombre" class="col-sm-4 control-label">Dni:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="dni" v-model="datosUsuario.dni">
	                        <span class="help-block" v-if="errors.get('dni')"><strong>{{ errors.get('dni') }}</strong></span>    
	                    </div>
	                </div>

	                <div class="form-group" :class="{'has-error': errors.get('email') }">
	                    <label for="nombre" class="col-sm-4 control-label">Email:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="text" v-model="datosUsuario.email">
	                        <span class="help-block" v-if="errors.get('email')"><strong>{{ errors.get('email') }}</strong></span>     
	                    </div>
	                </div>

	                <div class="form-group" :class="{'has-error': errors.get('telefono') }">
	                    <label for="nombre" class="col-sm-4 control-label">Teléfono:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="telefono" v-model="datosUsuario.telefono">
	                        <span class="help-block" v-if="errors.get('telefono')"><strong>{{ errors.get('telefono') }}</strong></span> 
	                    </div>
	                </div>

	                <div class="form-group" :class="{'has-error': errors.get('direccion') }">
	                    <label for="nombre" class="col-sm-4 control-label">Dirección:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="direccion" v-model="datosUsuario.direccion">
	                        <span class="help-block" v-if="errors.get('direccion')"><strong>{{ errors.get('direccion') }}</strong></span>    
	                    </div>
	                </div>

	                <div class="form-group" :class="{'has-error': errors.get('poblacion') }">
	                    <label for="nombre" class="col-sm-4 control-label">Población:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="poblacion" v-model="datosUsuario.poblacion">
	                        <span class="help-block" v-if="errors.get('poblacion')"><strong>{{ errors.get('poblacion') }}</strong></span>     
	                    </div>
	                </div>

	                <div class="form-group" :class="{'has-error': errors.get('password') }">
		                <div class="alert alert-info container" style="width:70%">
	  						<strong>Info!</strong> Si no desea cambiar la contraseña déjalo vacío.
						</div>
	                    <label for="password" class="col-sm-4 control-label">Contraseña:</label>
	                    <div class="col-sm-6">
	                        <input type="password" class="form-control" name="password" v-model="datosUsuario.password">
	                        <span class="help-block" v-if="errors.get('password')"><strong>{{ errors.get('password') }}</strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="password-confirmation" class="col-sm-4 control-label">Confirmar Contraseña:</label>
	                    <div class="col-sm-6">
	                        <input type="password" class="form-control" name="password_confirmation" v-model="datosUsuario.password_confirmation" :disabled="datosUsuario.password.length > 0 ? false : true">
	                        <span class="help-block"></span>     
	                    </div>
	                </div>

	                <div class="form-group">
			   			<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		    			<button type="submit" class="btn btn-success">Guardar cambios</button>
		    		</div>  	
			    </form>

		    </div>

  		</div>
 	</div>
</div>
</template>

<script>

	class Errors{

		constructor(){
			this.errors = {};
		}

		get(field){
			if(this.errors[field]){
				return this.errors[field][0];
			}
		}

		clear(field){
			delete this.errors[field];
		}

		record(errors){
			this.errors = errors;
		}
	}

	
	export default{

		props:{
			usuario: { required: true, type : Object}
		},
		data(){
			return{

				verPerfil: true,
				datosUsuario:{
					nombre: this.usuario.nombre,
					apellido1: this.usuario.apellido1,
					apellido2: this.usuario.apellido2,
					dni: this.usuario.dni,
					email: this.usuario.email,
					telefono: this.usuario.telefono,
					direccion: this.usuario.direccion,
					poblacion: this.usuario.poblacion,
					password: '',
					password_confirmation: ''
				},
				errors: new Errors()
			}
		},
		methods:{
			mostrarEditar(){
				this.verPerfil = false;
			},
			onSubmit(){

				axios.put('/usuarios/'+this.usuario.id,{
					nombre: this.$data.datosUsuario.nombre,
					apellido1: this.$data.datosUsuario.apellido1,
					apellido2: this.$data.datosUsuario.apellido2,
					dni: this.$data.datosUsuario.dni,
					email: this.$data.datosUsuario.email,
					telefono: this.$data.datosUsuario.telefono,
					direccion: this.$data.datosUsuario.direccion,
					poblacion: this.$data.datosUsuario.poblacion,
					password: this.$data.datosUsuario.password,
					password_confirmation: this.$data.datosUsuario.password_confirmation
				})
					.then( response => this.cerrarModal())
					.catch( error => this.errors.record(error.response.data))
			},
			cerrarModal(){
				$('#ver-perfil').modal('hide');
				$('#perfil-actualizado').show('slow').delay(4000).hide('slow');
				setTimeout(function(){
   					 location.reload();
				},5000);
			}
		}
	}
</script>