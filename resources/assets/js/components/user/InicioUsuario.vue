<template>
<div id="tabs-usuario" class="tabs">
	<main id="main-usuario" class="main">
       	<div class="panel-body panel">
       		<!--Tamaño de pantalla > xs pestañas en una linea horizontal -->
              <ul v-if="screenWidth >= 768" class="nav nav-tabs">
			    <li class="active" @click="obtenerDatos(1)"><a data-toggle="tab" href="#datos-tab-user">Libros</a></li>
			    <li @click="obtenerDatos(3)"><a data-toggle="tab" href="#datos-tab-user">Reservas</a></li>
			    <li @click="obtenerDatos(4)"><a data-toggle="tab" href="#datos-tab-user">Prestamos</a></li>
			    <li @click="obtenerDatos(5)"><a data-toggle="tab" href="#datos-tab-user">Retrasos</a></li>
  			</ul>
  			<!-- Tamaño de pantalla xs pestañas colocadas verticalmente-->
            <ul v-else class="nav nav-pills nav-stacked">
  				<li class="active" @click="obtenerDatos(1)"><a data-toggle="tab" href="datos-tab-user">Libros</a></li>
  				<li @click="obtenerDatos(3)"><a data-toggle="tab" href="datos-tab-user">Reservas</a></li>
  				<li @click="obtenerDatos(4)"><a data-toggle="tab" href="datos-tab-user">Prestamos</a></li>
  				<li @click="obtenerDatos(5)"><a data-toggle="tab" href="datos-tab-user">Retrasos</a></li>
  				<!--Tipo de objeto que estamos mostrando-->
  				<div id="tipo-objeto-user" class="titulo-objetos"><h2>{{tipo}}</h2></div>
			</ul>

			<!--Div que contiene la tabla con los datos-->
            <div class="tab-content">
               <div class="tab-pane active" id="datos-tab-user">
               		<!--Componente de vue que renderiza la tabla de forma dinamica con los datos que recibe-->
               			<!-- usuario: objeto con los datos del usuario, que es siempre el mismo-->
               			<!-- tipo: tipo de datos a mostrar(libros,reservas,retrasos,prestamos)-->
               			<!-- columnas: array con las columnas de la tabla-->
               			<!-- datos: objeto con los datos(libros , reservas, prestamos, retrasos) -->
               			<!-- actualizarDatos: metodo que recargara los datos en el caso de que haya alguna modificacion de ellos en la pestaña que se está mostrando-->
               		<datosusuario 
	               		:usuario="usuario"
	               		:tipo="tipo" 
	               		:datos="datos" 
	               		:columnas="columnas" 
	               		:actualizarDatos="obtenerDatos">
               		</datosusuario>
               </div>
            </div>
        </div>
    </main>
</div>	
</template>

<script type="text/javascript">
	
	export default{

		mounted(){
			//Evento que esta escuchando el redimensionado de la pantalla para cambiar las pestañas y adaptarlas al nuevo tamaño
			this.$nextTick(function() {
      			window.addEventListener('resize', this.getWindowWidth);
		      	this.getWindowWidth()
		    })
		},

		props:{
			//El componente recibe el usuario como objeto, para mostrar sus prestamos, reservas y retrasos
			usuario: { required: true, type: Object}
		},

		data(){
			return {
				screenWidth: '',//Almacena el ancho de pantalla, si es mayor o igual a 768px las pestañas se muestran expandidas, sino de forma vertical
				tipo :'libros',//Al cargar la pagina se mostrará siempre la tabla libros
				datos: [],//Datos que enviamos a la tabla para mostrar
				columnas: [],//Columnas que enviamos a la tabla
			}
		},

		methods:{

			getWindowWidth(event) {
				//Obtenemos el tamaño del ancho de pantalla
        		this.screenWidth = document.documentElement.clientWidth;
      		},

      		/**Funcion que recibe un numero al hacer click en cada una de las pestañas y obtiene  los datos correspondientes a ese numero de la base de datos**/
      		/** 1 = libros **/
      		/** 2 = usuarios En este caso no hay dos, porque es la tabla de usuarios, y en la interfaz de usuarios no se muestran**/
      		/** 3 = reservas del usuario**/
      		/** 4 = prestamos del usuario **/
      		/** 5 = retrasos del usuario **/
      		
			obtenerDatos(num){

				switch(num){

					/*Obtenemos los todos los libros de la base de datos*/
					case 1:
						axios.get('/libros')
							.then(response => this.datos = response.data )
							.catch(error => console.log(error))
						this.columnas = ['Titulo','Autor','Libro','Acciones'];
						this.tipo = 'libros';		
					break;

					/**Obtenermos las reservas del usuario, para ello le pasamos en la url el id del usuario que hemos recibido en los props**/
					/**Al obtener las reservas llamamos al metodo setDiasFaltan para establecer los dias que faltan hasta su finalizacion**/
					case 3:
						axios.get('/reservas/'+this.usuario.id)
							.then(response => this.setDiasFaltan(response.data,'reserva'))
							.catch(error => console.log(error))
						this.columnas = ['Libro','Fecha Reserva','Fecha Fin','Acciones'];
						this.tipo = 'reservas';
					break;

					/**Obtenermos los prestamos del usuario, para ello le pasamos en la url el id del usuario que hemos recibido en los props**/
					/**Al obtener los prestamos llamamos al metodo setDiasFaltan para establecer los dias que faltan hasta su finalizacion**/
					case 4:
						axios.get('/prestamos/'+this.usuario.id)
							.then(response => this.setDiasFaltan(response.data,'prestamo') )
							.catch(error => console.log(error))
						this.columnas = ['Libro','Fecha Prestamo','Fecha Fin','Acciones'];
						this.tipo = 'prestamos';	
					break;

					/**Obtenermos los restrasos del usuario, para ello le pasamos en la url el id del usuario que hemos recibido en los props**/
					/**Al obtener los retrasos llamamos al metodo setDiasRetraso para establecer los dias de retraso**/
					case 5:
						axios.get('/retrasos/'+this.usuario.id)
							.then(response => this.setDiasRetraso(response.data) )
							.catch(error => console.log(error))
						this.columnas = ['Libro','Fecha Retraso','Días','Acciones'];
						this.tipo = 'retrasos';
					break;
				}
			},

			/**Funcion que recibe los retrasos como objeto y devuelve el mismo objeto habiendole añadido el campo dias de retraso**/
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
                //Datos que enviamos a la tabla
                this.datos = retrasos;
			},

			/**Funcion que recibe un objeto con los datos  y el tipo de dichos objetos(si es reserva o prestamo) y le añade un campo con los dias que faltan hasta su finalizacion**/
			setDiasFaltan(datos,tipo){
				
				/**Si es reserva el campo que nos interesa para calcular los dias que faltan es 'fin_reserva'**/
				if( tipo == 'reserva'){
					var columna = 'fin_reserva';
				/**Si es prestamo 'fin_prestamo'**/
				}else{
					columna = 'fin_prestamo';
				}
				var fechaHoy = new Date();
				var dia = fechaHoy.getDate();
                var mes = fechaHoy.getMonth()+1;
                var year = fechaHoy.getFullYear();
                var hoy = Date.UTC(year,mes,dia);

                for(var i in datos){
                	
                    var fecha_fin = datos[i][columna];
                    var fecha_fin = fecha_fin.split('-');
                    fecha_fin = Date.UTC(fecha_fin[0],fecha_fin[1],fecha_fin[2]);
                    var dif = fecha_fin - hoy;
                    var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
                   	datos[i].caduca = dias;
                }
                //Datos que enviamos a la tabla
                this.datos = datos;
			}
		}

	}

</script>