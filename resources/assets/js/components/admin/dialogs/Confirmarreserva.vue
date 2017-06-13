<template>

	<div class="modal fade text-center">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      	<div class="modal-header">
		        	<h2 class="modal-title">Confirmar reserva</h2>
		      	</div>
		      	<div class="modal-body">
		      		<p>¿Realizar el prestamo del libro {{reserva.titulo}} a {{reserva.nombre}} {{reserva.apellido1}} ?</p>
		      	<div class="form-group">
		      	</div>
		      	<div class="modal-footer">
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
			reserva: { required: true, type: Object},
			actualizarTabla: { required: true, type: Function },
			devolverMensaje: { required: true, type: Function},
		},

		methods: {

			confirmar(){

				axios.post('/prestamos',{
					id_usuario: this.reserva.id_usuario,
					id_libro: this.reserva.id_libro,
					reserva: true
				})
					.then( response => this.cerrarModal(response.data) )
					.catch( error => console.log(error))

				axios.delete('/reservas/'+this.reserva.id)
					.then( response => console.log('reserva eliminada') )
					.catch( error => console.log(error))

			},

			cerrarModal(respuesta){

				$('#confirmar-reserva').modal('hide');
				this.actualizarTabla(3);
				this.establecerMensaje(respuesta);
			},

			establecerMensaje(respuesta){
				this.devolverMensaje(respuesta);
			}
		}

	}
	
</script>