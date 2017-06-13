<template>

	<div class="modal fade text-center">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">

		        <h2 class="modal-title">Nuevo Usuario</h2>

		      </div>
		      <div class="modal-body">
		        <form class="form-horizontal" role="form" method="POST" @submit.prevent=onSubmit @keydown="errors.clear($event.target.name)">

		        	<div class="form-group" :class="{'has-error': errors.get('nombre') }">
		        		<div class="form-group">
		        			<input type="text" name="nombre" placeholder="Nombre" v-model="nombre">
		        			<span class="help-block" v-if="errors.get('nombre')"><strong>{{ errors.get('nombre') }}</strong></span>
		        		</div>
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('apellido1') }">
		        		<div class="form-group">
		        			<input type="text" name="apellido1" placeholder="Apellido1" v-model="apellido1">
		        			<span class="help-block" v-if="errors.get('apellido1')"><strong>{{ errors.get('apellido1') }}</strong></span>
		        		</div>	
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('apellido2') }">
		        		<div class="form-group">
		        			<input type="text" name="apellido2" placeholder="Apellido2" v-model="apellido2">
		        			<span class="help-block" v-if="errors.get('apellido2')"><strong>{{ errors.get('apellido2') }}</strong></span>
		        		</div>
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('dni') }">
		        		<div class="form-group">
		        			<input type="text" name="dni" placeholder="Dni o Nie" v-model="dni">
		        			<span class="help-block" v-if="errors.get('dni')"><strong>{{ errors.get('dni') }}</strong></span>
		        		</div>	
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('email') }">
		        		<div class="form-group">
		        			<input type="text" name="email" placeholder="Email" v-model="email">
		        			<span class="help-block" v-if="errors.get('email')"><strong>{{ errors.get('email') }}</strong></span>
		        		</div>
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('telefono') }">
		        		<div class="form-group">
		        			<input type="text" name="telefono" placeholder="Nº de teléfono" v-model="telefono">
		        			<span class="help-block" v-if="errors.get('telefono')"><strong>{{ errors.get('telefono') }}</strong></span>
		        		</div>
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('direccion') }">
		        		<div class="form-group">
		        			<input type="text" name="direccion" placeholder="Dirección" v-model="direccion">
		        			<span class="help-block" v-if="errors.get('direccion')"><strong>{{ errors.get('direccion') }}</strong></span>
		        		</div>
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('poblacion') }">
		        		<div class="form-group">
		        			<input type="text" name="poblacion" placeholder="Población" v-model="poblacion">
		        			<span class="help-block" v-if="errors.get('poblacion')"><strong>{{ errors.get('poblacion') }}</strong></span>
		        		</div>
	        		</div>

	        		<div class="form-group">
	        			<button id="cancelar" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	                    <button type="submit" class="btn btn-primary">Guardar</button>
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

	
	export default {

		props: {
			devolverMensaje: { required: true, type: Function},
			actualizarTabla: { required: true, type: Function }
		},

		mounted(){

			$('#add-usuario').on('hidden.bs.modal',function(){
				this.limpiarDatos();
			}.bind(this));

		},

		data() {

			return {

				nombre :'',
				apellido1: '',
				apellido2: '',
				dni: '',
				email: '',
				telefono: '',
				direccion: '',
				poblacion: '',
				//password: '',
				errors: new Errors()
			}
		},

		methods: {

			onSubmit(){

				axios.post('/usuarios', this.$data)
					.then( response => this.cerrarModal(response.data)  )
					.catch( error => this.errors.record(error.response.data) )

			},

			cerrarModal(respuesta){
				$('#add-usuario').modal('hide');	
				this.actualizarTabla(2);
				this.establecerMensaje(respuesta);
				this.enviarMail(respuesta.password);
			},

			limpiarDatos(){
				this.errors = new Errors();
				this.nombre = '';
				this.apellido1 = '';
				this.apellido2 = '';
				this.dni = '';
				this.email = '';
				this.telefono = '';	
				this.direccion = '';	
				this.poblacion = '';			
			},
			establecerMensaje(respuesta){
				this.devolverMensaje(respuesta);
			},

			enviarMail(password){

        		axios.post('/envio',
        		{
        			nombre: this.nombre,
        			apellido1: this.apellido1,
        			email: this.email,
        			password: password
        		})
  					.then( response => console.log('Mail Enviado'))
  					.catch( error => console.log(error) );

        	},
		}
	}

</script>