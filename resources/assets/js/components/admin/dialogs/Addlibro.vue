<template>

	<div class="modal fade text-center">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">

		        <h2 class="modal-title">Nuevo Libro</h2>

		      </div>
		      <div class="modal-body">
		        <form class="form-horizontal" role="form" method="POST" @submit.prevent=onSubmit @keydown="errors.clear($event.target.name)">

		        	<div class="form-group" :class="{'has-error': errors.get('titulo') }">
		        		<div class="form-group">
		        			<input type="text" name="titulo" placeholder="Título" v-model="titulo">
		        			<span class="help-block" v-if="errors.get('titulo')"><strong>{{ errors.get('titulo') }}</strong></span>
		        		</div>
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('autor') }">
		        		<div class="form-group">
		        			<input type="text" name="autor" placeholder="Autor" v-model="autor">
		        			<span class="help-block" v-if="errors.get('autor')"><strong>{{ errors.get('autor') }}</strong></span>
		        		</div>	
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('editorial') }">
		        		<div class="form-group">
		        			<input type="text" name="editorial" placeholder="Editorial" v-model="editorial">
		        			<span class="help-block" v-if="errors.get('editorial')"><strong>{{ errors.get('editorial') }}</strong></span>
		        		</div>
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('isbn') }">
		        		<div class="form-group">
		        			<input type="text" name="isbn" placeholder="Isbn" v-model="isbn">
		        			<span class="help-block" v-if="errors.get('isbn')"><strong>{{ errors.get('isbn') }}</strong></span>
		        		</div>	
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('paginas') }">
		        		<div class="form-group">
		        			<input type="text" name="paginas" placeholder="Nº de páginas" v-model="paginas">
		        			<span class="help-block" v-if="errors.get('paginas')"><strong>{{ errors.get('paginas') }}</strong></span>
		        		</div>
	        		</div>

	        		<div class="form-group" :class="{'has-error': errors.get('ejemplares') }">
		        		<div class="form-group">
		        			<input type="text" name="ejemplares" placeholder="Nº de ejemplares" v-model="ejemplares">
		        			<span class="help-block" v-if="errors.get('ejemplares')"><strong>{{ errors.get('ejemplares') }}</strong></span>
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

				$('#add-libro').on('hidden.bs.modal',function(){
					this.limpiarDatos();
				}.bind(this));
		},

		data() {

			return {

				titulo :'',
				autor: '',
				editorial: '',
				isbn: '',
				paginas: '',
				ejemplares: '',
				errors: new Errors()
			}
		},

		methods: {

			onSubmit(){

				axios.post('/libros', this.$data)
					.then( response => this.cerrarModal(response.data) )
					.catch( error => this.errors.record(error.response.data) )

			},

			cerrarModal(respuesta){
				$('#add-libro').modal('hide');	
				this.actualizarTabla(1);
				this.establecerMensaje(respuesta);
			},

			limpiarDatos(){
				this.errors = new Errors();
				this.titulo = '';
				this.autor = '';
				this.editorial = '';
				this.isbn = '';
				this.paginas = '';
				this.ejemplares = '';			
			},
			establecerMensaje(respuesta){
				this.devolverMensaje(respuesta);
			}
		}
	}

</script>