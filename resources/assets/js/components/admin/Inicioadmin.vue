<template>
<div id="tabs-admin" class="tabs">

  <crearadmin id="crear-admin" tabindex="-1" role="dialog" aria-labelledby="crear-admin" aria-hidden="true"></crearadmin>

  <div id="admin-creado" hidden class="alert alert-success">
    <p><strong>Se ha creado un nuevo administrador.</strong></p>
  </div>
  
    <main id="main-admin" class="main">
       <div class="panel-body panel">
       	<!--Tamaño de pantalla > xs pestañas en una linea horizontal -->
            <ul v-if="screenWidth > 768" class="nav nav-tabs">
			    <li class="active" @click="obtenerDatos(1)"><a data-toggle="tab" href="#datos-tab-admin">Libros</a></li>
			    <li @click="obtenerDatos(2)"><a data-toggle="tab" href="#datos-tab-admin">Usuarios</a></li>
			    <li @click="obtenerDatos(3)"><a data-toggle="tab" href="#datos-tab-admin">Reservas</a></li>
			    <li @click="obtenerDatos(4)"><a data-toggle="tab" href="#datos-tab-admin">Prestamos</a></li>
			    <li @click="obtenerDatos(5)"><a data-toggle="tab" href="#datos-tab-admin">Retrasos</a></li>
  			</ul>
  			<!-- Tamaño de pantalla xs pestañas colocadas verticalmente-->
            <ul v-else class="nav nav-pills nav-stacked">
  				<li class="active" @click="obtenerDatos(1)"><a data-toggle="tab" href="datos-tab-admin">Libros</a></li>
  				<li @click="obtenerDatos(2)"><a data-toggle="tab" href="datos-tab-admin">Usuarios</a></li>
  				<li @click="obtenerDatos(3)"><a data-toggle="tab" href="datos-tab-admin">Reservas</a></li>
  				<li @click="obtenerDatos(4)"><a data-toggle="tab" href="datos-tab-admin">Prestamos</a></li>
  				<li @click="obtenerDatos(5)"><a data-toggle="tab" href="datos-tab-admin">Retrasos</a></li>
  				<!--Tipo de objeto que estamos mostrando-->
  				<div id="tipo-objeto-admin" class="titulo-objetos"><h2>{{tipo}}</h2></div>
			</ul>

            <div class="tab-content">
                <div class="tab-pane active" id="datos-tab-admin">
	                <!--Componente de vue que renderiza la tabla de forma dinamica con los datos que recibe-->
	               			<!-- usuario: objeto con los datos del usuario, que es siempre el mismo-->
	               			<!-- tipo: tipo de datos a mostrar(libros,reservas,retrasos,prestamos)-->
	               			<!-- datos: objeto con los datos(libros , reservas, prestamos, retrasos) -->
	               			<!-- columnas: array con las columnas de la tabla -->
	               			<!-- columnasFiltro: array con las columnas por las que se podrá filtrar los objetos de la tabla*-->
	               			<!-- actualizarDatos: metodo que recargara los datos en el caso de que haya alguna modificacion de ellos en la pestaña que se está mostrando-->
	                <datosadmin 
		                :tipo="tipo" 
		                :datos="datos" 
		                :columnas="columnas" 
		                :columnasFiltro="columnasFiltro" 
		                :actualizarDatos="obtenerDatos">	
	                </datosadmin>
                </div>
            </div>

         </div>
    </main>
</div>	
</template>

<script type="text/javascript">
	
	export default{

		mounted(){
			this.$nextTick(function() {
      			window.addEventListener('resize', this.getWindowWidth);
		      	this.getWindowWidth()
		    })
		},

		data(){
			return {

				screenWidth: '',
				tipo :'Libros',
				datos: [],
				columnas: [],
				columnasFiltro: [],
			}
		},

		methods:{

			getWindowWidth(event) {
        		this.screenWidth = document.documentElement.clientWidth;
      		},

			obtenerDatos(num){

				switch(num){
					case 1:
						axios.get('/libros')
							.then(response => this.datos = response.data )
							.catch(error => console.log(error))
						this.columnas = ['Título','Autor','Editorial','Acciones'];
						this.columnasFiltro = ['titulo','autor','editorial','isbn'];
						this.tipo = 'libros';		
					break;

					case 2:
						axios.get('/usuarios')
							.then(response => this.datos = response.data )
							.catch(error => console.log(error))
						this.columnas = ['Nombre','Apellido 1', 'Apellido 2','Email','Acciones'];
						this.columnasFiltro = ['nombre','apellido1','apellido2','dni','email'];
						this.tipo = 'usuarios';		
					break;

					case 3:	
						axios.get('/reservas')
							.then(response => this.setDiasFaltan(response.data, 'reserva') )
							.catch(error => console.log(error))
						this.columnas = ['Nombre','Libro','Fecha Reserva','Fecha Fin','Acciones'];
						this.columnasFiltro = ['nombre','apellido1','apellido2','titulo','dni'];
						this.tipo = 'reservas';
					break;

					case 4:
						axios.get('/prestamos')
							.then(response => this.setDiasFaltan(response.data, 'prestamo') )
							.catch(error => console.log(error))
						this.columnas = ['Nombre','Libro','Fecha Prestamo','Fecha Fin','Acciones'];
						this.columnasFiltro = ['nombre','apellido1','apellido2','titulo','dni'],
						this.tipo = 'prestamos';	
					break;

					case 5:
						axios.get('/retrasos')
							.then(response => this.diferenciaDias(response.data) )
							.catch(error => console.log(error))
						this.columnas = ['Nombre','Libro','Fecha Retraso','Días','Acciones'];
						this.columnasFiltro = ['nombre','apellido1','apellido2','titulo','dni'],
						this.tipo = 'retrasos';
					break;
				}
			},

			diferenciaDias(datos){

				var fechaHoy = new Date();
                var dia = fechaHoy.getDate();
                var mes = fechaHoy.getMonth()+1;
                var year = fechaHoy.getFullYear();
                var hoy = Date.UTC(year,mes,dia);
             

                for(var i in datos){
                	
                    var retraso = datos[i].fecha_retraso;
                    var retraso = retraso.split('-');
                    retraso = Date.UTC(retraso[0],retraso[1],retraso[2]);
                    var dif = hoy - retraso;
                    var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
                   	datos[i].dias_retraso = dias+1;
                }

                this.datos = datos;
			},
			setDiasFaltan(datos,tipo){
				
				if( tipo == 'reserva'){
					var columna = 'fin_reserva';
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
                this.datos = datos;
			}
		}
	}
</script>