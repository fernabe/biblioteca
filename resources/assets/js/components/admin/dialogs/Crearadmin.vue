<template>
<div class="modal fade text-center">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
		    	<h2 class="modal-title">Crear Administrador</h2>
		    </div>
		    <div class="modal-body">
		      	<form class="form-horizontal" role="form" @submit.prevent=onSubmit @keydown="errors.clear($event.target.name)">

                        <div class="form-group" :class="{'has-error': errors.get('nombre') }">
		                    <label for="titulo" class="col-sm-4 control-label">Nombre:</label>
		                    <div class="col-sm-6">
		                       <input type="text" class="form-control" name="nombre" v-model="nombre">
		                       <span class="help-block" v-if="errors.get('nombre')"><strong>{{ errors.get('nombre') }}</strong></span>
		                    </div>
	                	</div>

	                	<div class="form-group" :class="{'has-error': errors.get('email') }">
		                    <label for="titulo" class="col-sm-4 control-label">Correo Electrónico:</label>
		                    <div class="col-sm-6">
		                       <input type="text" class="form-control" name="email" v-model="email">
		                       <span class="help-block" v-if="errors.get('email')"><strong>{{ errors.get('email') }}</strong></span>
		                    </div>
	                	</div>

	                	<div class="form-group" :class="{'has-error': errors.get('password') }">
		                    <label for="titulo" class="col-sm-4 control-label">Contraseña:</label>
		                    <div class="col-sm-6">
		                       <input type="password" class="form-control" name="password" v-model="password">
		                       <span class="help-block" v-if="errors.get('password')"><strong>{{ errors.get('password') }}</strong></span>
		                    </div>
	                	</div>

                        <div class="form-group">
	                    	<label for="password-confirmation" class="col-sm-4 control-label">Confirmar Contraseña:</label>
	                    	<div class="col-sm-6">
	                        	<input type="password" class="form-control" name="password_confirmation" v-model="password_confirmation">
	                        	<span class="help-block"><strong></strong></span>     
	                    	</div>
	                	</div>

                            <input type="hidden" name="tipo" value="admin">
                            
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                           		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Crear</button>
                            </div>
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

		mounted(){

			$('#crear-admin').on('hidden.bs.modal',function(){	

				this.errors = new Errors();
				this.nombre ='';
				this.email = '';
				this.password = '';
				this.password_confirmation ='';

			}.bind(this));

		},
		data(){
			return{
					nombre: '',
					email: '',
					password: '',
					password_confirmation: '',
					errors : new Errors()		
			}
		},

		methods :{

			onSubmit(){
				axios.post('/admin_register/', this.$data)
					.then( response => this.cerrarModal() )
					.catch( error => this.errors.record(error.response.data))

			},
			
			cerrarModal(){
				$('#crear-admin').modal('hide');
				$('#admin-creado').show('slow').delay(5000).hide('slow');
				this.actualizarLibros();
			}
		}
	}

</script>