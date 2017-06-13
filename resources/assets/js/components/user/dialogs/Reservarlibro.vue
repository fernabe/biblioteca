<template>

<div class="modal fade text-center">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
		    	<h2 class="modal-title">Reservar Libro</h2>
		    </div>
		    <div class="modal-body">
		    	<p>¿Quiere reservar el libro {{libro.titulo}}?</p>
			    <div class="form-group">
		        	<button id="cancelar" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		            <button type="button" class="btn btn-success" @click="confirmar">Reservar</button>
		        </div>
			</div>     
		</div>
  	</div>
 </div>
</template>

<script>


	export default {

		props : {	
			libro: { required:true, type: Object},
			usuario: { required:true, type: Object},
			devolverMensaje: { required: true, type: Function},
		},

		mounted(){
		},

		methods: {

			confirmar(){
				
				axios.post('/reservas',{
					id_usuario: this.usuario.id,
					id_libro: this.libro.id
				})
					.then( response => this.cerrarModal(response.data) )
					.catch( error => console.log(error) )
			},

			cerrarModal(respuesta){
				$('#reservar-libro').modal('hide');
				this.establecerMensaje(respuesta);
			},

			establecerMensaje(respuesta){
				this.devolverMensaje(respuesta);
			}
		}

	}

</script>