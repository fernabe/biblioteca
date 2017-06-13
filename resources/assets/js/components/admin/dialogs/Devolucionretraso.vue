<template>

	<div class="modal fade text-center">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h2 class="modal-title">Devolución libro</h2>
		      </div>
		      <div class="modal-body">
		      	<p>¿Quiere devolver el libro {{retraso.titulo}}?</p>
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
			retraso: { required: true, type: Object},
			actualizarTabla: { required: true, type: Function },
			devolverMensaje: { required: true, type: Function},
		},

		methods: {

			confirmar(){

				axios.delete('/retrasos/'+this.retraso.id)
					.then( response => this.cerrarModal(response.data) )
					.catch( error => console.log(error))

			},

			cerrarModal(respuesta){
				
				$('#devolucion-retraso').modal('hide');
				this.actualizarTabla(5);
				this.establecerMensaje(respuesta)
			},
			establecerMensaje(respuesta){
				this.devolverMensaje(respuesta);
			}
		}

	}

</script>
