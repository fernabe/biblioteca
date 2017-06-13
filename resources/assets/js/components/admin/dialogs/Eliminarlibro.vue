<template>

<div class="modal fade text-center">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h2 class="modal-title">Confirmar reserva</h2>
		      </div>
		      <div class="modal-body">
		      	<p>¿Esta seguro que desea eliminar el libro {{libro.titulo}}?</p>
		      	<div class="form-group">

	        			<button id="cancelar" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	                    <button type="button" class="btn btn-success" @click="confirmar">Confirmar</button>
	            </div>
		      </div>
		     
		    </div>
  		</div>
  </div>
</template>

<script>

	export default {

		props : {	
			libro: { required:true, type: Object },
			actualizarTabla: { required: true, type: Function },
			devolverMensaje: { required: true, type: Function},
		},
		methods: {

			confirmar(){
				axios.delete('/libros/'+this.libro.id)
					.then( response => this.cerrarModal(response.data) )
					.catch( error => console.log(error))
			},

			cerrarModal(respuesta){
				$('#eliminar-libro').modal('hide');
				this.actualizarTabla(1);
				this.establecerMensaje(respuesta);
			},

			establecerMensaje(respuesta){
				this.devolverMensaje(respuesta);
			}

		}
	}

</script>