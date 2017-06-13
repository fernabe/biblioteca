<template>
<div class="modal fade text-center">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
		    	<h2 class="modal-title">Información libro</h2>
		    </div>
		    <div class="modal-body">

		      	<form class="form-horizontal" role="form" method="POST" @submit.prevent=onSubmit @keydown="errors.clear($event.target.name)">
			    	
			    	<div class="form-group" :class="{'has-error': errors.get('titulo') }">
	                    <label for="titulo" class="col-sm-4 control-label">Título:</label>
	                    <div class="col-sm-6">
	                       <input type="text" class="form-control" name="titulo" v-model="datosLibro.titulo">
	                       <span class="help-block" v-if="errors.get('titulo')"><strong>{{ errors.get('titulo') }}</strong></span>
	                    </div>
	                </div>

	               <div class="form-group" :class="{'has-error': errors.get('autor') }">
	                    <label for="autor" class="col-sm-4 control-label">Autor:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="autor" v-model="datosLibro.autor">
	                         <span class="help-block" v-if="errors.get('autor')"><strong>{{ errors.get('autor') }}</strong></span>     
	                    </div>
	                </div>

	                <div class="form-group" :class="{'has-error': errors.get('editorial') }">
	                    <label for="editorial" class="col-sm-4 control-label">Editorial:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="editorial" v-model="datosLibro.editorial">
	                        <span class="help-block" v-if="errors.get('editorial')"><strong>{{ errors.get('editorial') }}</strong></span>     
	                    </div>
	                </div>

	                <div class="form-group" :class="{'has-error': errors.get('isbn') }">
	                    <label for="Isbn" class="col-sm-4 control-label">Isbn:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="isbn" v-model="datosLibro.isbn">
	                         <span class="help-block" v-if="errors.get('isbn')"><strong>{{ errors.get('isbn') }}</strong></span>     
	                    </div>
	                </div>

	                <div class="form-group" :class="{'has-error': errors.get('paginas') }">
	                    <label for="paginas" class="col-sm-4 control-label">Número de páginas:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="paginas" v-model="datosLibro.paginas">
	                        <span class="help-block" v-if="errors.get('paginas')"><strong>{{ errors.get('paginas') }}</strong></span> 
	                    </div>
	                </div>

	                <div class="form-group" :class="{'has-error': errors.get('ejemplares') }">
	                    <label for="ejemplares" class="col-sm-4 control-label">Número de ejemplares:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="ejemplares" v-model="datosLibro.ejemplares">
	                        <span class="help-block" v-if="errors.get('ejemplares')"><strong>{{ errors.get('ejemplares') }}</strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
			   			<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			   			<button type="submit" class="btn btn-success">Guardar Cambios</button>
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

		props : {
			libro: { required:true, type: Object },
			actualizarTabla: { required: true, type: Function },
			devolverMensaje: { required: true, type: Function},
		},
		mounted(){
			$('#editar-libro').on('hidden.bs.modal',function(){	
				this.limpiarDatos();
			}.bind(this));

		},
		data(){
			return{

				datosLibro: {
					titulo: '',
					autor: '',
					editorial: '',
					paginas: '',
					isbn: '',
					ejemplares: ''
				},
				errors : new Errors()		
			}
		},
		watch: {

			libro(){
				this.datosLibro.titulo = this.libro.titulo;
				this.datosLibro.autor = this.libro.autor;
				this.datosLibro.editorial = this.libro.editorial;
				this.datosLibro.isbn = this.libro.isbn;
				this.datosLibro.paginas = this.libro.paginas;
				this.datosLibro.ejemplares = this.libro.ejemplares
			}
		},
		methods :{

			onSubmit(){
				
				axios.put('/libros/'+this.libro.id,{
					titulo: this.datosLibro.titulo,
					autor: this.datosLibro.autor,
					editorial: this.datosLibro.editorial,
					isbn: this.datosLibro.isbn,
					paginas: this.datosLibro.paginas,
					ejemplares: this.datosLibro.ejemplares
				})
					.then( response =>this.cerrarModal(response.data) )
					.catch( error => this.errors.record(error.response.data))

			},
			cerrarModal(respuesta){
				$('#editar-libro').modal('hide');
				this.actualizarTabla(1);
				this.establecerMensaje(respuesta);
			},
			limpiarDatos(){
				this.errors = new Errors();
			},
			establecerMensaje(respuesta){
				this.devolverMensaje(respuesta);
			}
		}
	}

</script>