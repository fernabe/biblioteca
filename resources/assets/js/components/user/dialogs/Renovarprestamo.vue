<template>
<div class="modal fade text-center">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			   	<h2 class="modal-title">Renovar Préstamo</h2>
			</div>
			<div class="modal-body">
			    <p>Aumentar el plazo de devolución del libro {{prestamo.titulo}} 10 días.</p>
			    <div class="form-group">
		        	<button id="cancelar" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		            <button type="button" class="btn btn-success" @click="confirmar">Renovar</button>
		        </div>
			</div>   
		</div>
  	</div>
 </div>
</template>

<script>

	export default {

		props : {	
			prestamo: { required: true, type: Object},
			actualizarTabla: { required: true, type: Function },
			devolverMensaje: { required: true, type: Function},
		},

		mounted(){
		},

		methods: {
			confirmar(){
				axios.put('/prestamos/'+this.prestamo.id)
					.then( response => this.cerrarModal(response.data))
					.catch( error => console.log(error));
			},

			cerrarModal(respuesta){
				$('#renovar-prestamo').modal('hide')
				this.actualizarTabla(4);
				this.establecerMensaje(respuesta)
			},
			establecerMensaje(respuesta){
				this.devolverMensaje(respuesta);
			}
		}
	}
</script>
