<template>

<div id="mensajes">

	<div id="reserva-finalizada" v-for="reserva in reservas_fin" class="alert alert-warning alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	 	<p>La reserva del libro <strong>{{reserva.titulo}}</strong> finaliza hoy.</p>
	</div>

	<div id="reserva-caducada" v-for="reserva in reservas_caducadas" class="alert alert-danger alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	 	<p>La reserva del libro <strong>{{reserva.titulo}}</strong> ha caducado y ha sido eliminada.</p>
	</div>

	<div v-if="mensaje_reservas_retrasos.length > 0" id="reserva-caducada-retrasos" class="alert alert-danger alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	 	<p><strong>{{mensaje_reservas_retrasos}}</strong></p>
	</div>

	<div id="prestamo-finalizado" v-for="prestamo in prestamos_fin" class="alert alert-warning alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	 	<p>El préstamo del libro <strong>{{prestamo.titulo}}</strong> finaliza hoy.</p>
	</div>

	<div id="retraso" v-for="retraso in mensajes_retrasos" class="alert alert-danger alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	 	<p>El préstamo del libro <strong>{{retraso.titulo}}</strong> no ha sido devuelto a tiempo y se ha añadido a tus retrasos.<br>Devuélvelo cuanto antes, por favor.</p>
	</div>

</div>

</template>

<script>

export default{

	props:{
		usuario: { required: true, type: Object}
	},

	mounted(){

		this.obtenerDatos();
		
	},
	data() {

		return {
			reservas_fin: {},
			prestamos_fin: {},
			mensajes_retrasos: {},
			reservas_caducadas: {},
			mensaje_reservas_retrasos :'',
		}
	},

	methods:{

		/**Obtiene los datos del controlador mensajescontroller, para ver si hay algun mensaje que mostrar**/
		obtenerDatos(){
			axios.get('reservas_fin/'+this.usuario.id)
				.then( response => this.setReservasFin(response.data))
				.catch( error => console.log(error))

			axios.get('prestamos_fin/'+this.usuario.id)
				.then( response => this.setPrestamosFin(response.data))
				.catch( error => console.log(error))

			axios.get('/retrasos/'+this.usuario.id)
				.then( response => this.setDiasRetraso(response.data))
				.catch( error => console.log(error))

			axios.get('/reservas_caducadas/'+this.usuario.id)
				.then( response => this.setReservasCaducadas(response.data))
				.catch( error => console.log(error) )

		},

		setDiasRetraso(retrasos){
			var fechaHoy = new Date();
            var dia = fechaHoy.getDate();
            var mes = fechaHoy.getMonth()+1;
            var year = fechaHoy.getFullYear();
            var hoy = Date.UTC(year,mes,dia);
             

            for(var i in retrasos){
                var retraso = retrasos[i].fecha_retraso;
                var retraso = retraso.split('-');
                retraso = Date.UTC(retraso[0],retraso[1],retraso[2]);
                var dif = hoy - retraso;
                var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
                retrasos[i].dias_retraso = dias+1;
            }

            this.setMensajeRetrasos(retrasos);
		},

		/**Establece el mensaje con las reservas que caducan en el dia actual**/
		setReservasFin(reservas){
			this.reservas_fin = reservas;
		},

		/**Establece el mensaje con los prestamos que caducan en el dia actual**/
		setPrestamosFin(prestamos){
			this.prestamos_fin = prestamos;
		},
		/*Establece un mensaje con los retrasos que tienes*/
		setMensajeRetrasos(retrasos){
			this.mensajes_retrasos = retrasos;	
		},
		
		/**Establece un mensaje con las reservas caducadas**/
		setReservasCaducadas(caducadas){
			var a=0;//Si a es mayor que cero habra retrasos en la tabla y entonces se anularan todas las reservas
			for(var i in caducadas){
				if(caducadas[i].tipo == 'retraso'){
					a++;
				}
			}
			if(a>0){
				this.mensaje_reservas_retrasos = 'Se han eliminado todas tus reservas porque tienes retrasos en tus préstamos';
			}else{
				this.reservas_caducadas = caducadas;
			}
			this.actualizarAvisos();
		},
		/**Actualiza la tabla avisos,estableciendo los mensajes como leidos**/
		actualizarAvisos(){
			axios.put('/actualizar_avisos/'+this.usuario.id)
				.then( response => console.log(response.data))
				.catch( error => console.log(error))
		}
	}

}
</script>
