<template>

<div class="modal fade text-center">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal">&times;</button>
		       	<h2 class="modal-title">Prestar libro</h2>
		    </div>
		    <div class="modal-body">
		   		<div class="row">
	            	<div class="center-block buscar">
	                	<div class="input-group">
      						<input id="dni-usuario" type="text" class="form-control" placeholder="Dni usuario" @keydown="pulsado_y_no_existe=false" v-model="dni">
      							<span class="input-group-btn">
        							<button class="btn btn-primary" type="button" @click="obtenerUsuarios">Buscar</button>
     							</span>
    					</div>
	            	</div>
        		</div>
        		<div v-if="existeUsuario">
  					<p>¿Prestar el libro {{libro.titulo}} a {{usuario.nombre}} {{usuario.apellido1}}?</p>
					<div class="form-group">
		        			<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		                    <button type="button" class="btn btn-success" @click="confirmar">Confirmar</button>
		            </div>
		        </div>
		        <div v-if="pulsado_y_no_existe">
    				<div class="alert alert-danger">
        				<strong>No existe ningun usuario con ese dni.</strong> 
    				</div> 
		        </div>
		    </div>
		</div>
  	</div>
</div>
</template>

<script>

	

	export default {

		props : {	
			libro: { required: true, type: Object},
			devolverMensaje: { required: true, type: Function},
		},
		mounted(){
			$('#prestar-libro').on('hidden.bs.modal',function(){
				this.limpiarModal();
			}.bind(this));
		},
		data(){
			return{
				existeUsuario: false,
				pulsado_y_no_existe: false,
				usuario: {},
				dni: ''
			}	
		},

		methods: {

			obtenerUsuarios(){
				axios.get('/usuarios')
					.then( response=> this.obtenerUsuario(response.data))
					.catch( error => console.log(error))

			},
			obtenerUsuario(usuarios){
				this.usuario = {};
				var dni = this.dni.toLowerCase();
				var a = 0;
				for(var i in usuarios){
					if(usuarios[i].dni.toLowerCase() == dni){
						this.usuario = usuarios[i];
						a++;
					}
				}
				if(a!=0){
					this.existeUsuario = true;
				}else{
					this.pulsado_y_no_existe = true;	
				}
				
			},
			confirmar(){
				axios.post('/prestamos',{
					id_usuario: this.usuario.id,
					id_libro: this.libro.id,
					reserva: false
				})
					.then( response => this.cerrarModal(response.data) )
					.catch( error => console.log(error))
			},

			cerrarModal(respuesta){
				$('#prestar-libro').modal('hide');
				this.establecerMensaje(respuesta);
			},

			limpiarModal(){
				this.dni = '';
				this.existeUsuario = false;
				this.usuario = {};
				this.pulsado_y_no_existe = false;
			},

			establecerMensaje(respuesta){
				this.devolverMensaje(respuesta);
			}
		}

	}

</script>

<style type="text/css">

.buscar{
	width: 60%;
	margin-bottom: 20px;
}
</style>