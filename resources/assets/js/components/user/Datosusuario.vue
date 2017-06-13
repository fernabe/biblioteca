<template>   
<div id="contenido-user" class="contenido-tab">
<div hidden id="mensajes-objetos-user" class="alert alert-danger alert-success">
    <strong>{{mensaje}}</strong> 
</div>

<div v-if="mostrarPagina">

    <div v-if="tipoMostrar.libros" class="buscador">
        <div class="row">
            <div id="buscardor-user" class="boton-buscar col-xs-12 col-sm-6 pull-right">
                <div class="inner-addon right-addon">
                    <i class="glyphicon glyphicon-search"></i>
                    <input id="buscar-user" type="search" class="form-control" placeholder="Buscar" :disabled="!hayDatos" @keyup="filtrarObjetos" v-model="filtro">
                </div>
            </div>
        </div>
    </div>

    <div v-if="hayCoincidencias" class="table-responsive" style="border-style:none">
        <table v-if="hayDatos" id="tabla-objetos-user" class="table">
            <thead>
                <tr class="cabecera-tabla">
                    <th v-for="columna in columnasMostrar">{{columna}}</th>
                </tr>
            </thead>
                <tbody>

                <tr v-if="tipoMostrar.libros" v-for="libro in objetosMostrar">
                    <td>{{libro.titulo}}</td>
                    <td>{{libro.autor}}</td>
                    <td>{{libro.editorial}}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs" @click="seleccionarLibro(libro.id)" title="Ver libro"data-toggle="modal" data-target="#ver-libro">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        </button>
                        <button type="button" class="btn btn-success btn-xs" @click="seleccionarLibro(libro.id)" data-toggle="modal" data-target="#reservar-libro">Reservar</button>
                    </td>
                </tr>

                <tr v-if="tipoMostrar.reservas" v-for="reserva in objetosMostrar">
                    <td>{{reserva.titulo}}</td>
                    <td>{{reserva.fecha_reserva}}</td>
                    <td>{{reserva.fin_reserva}}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs" @click="seleccionarReserva(reserva)" title="Detalles reserva"data-toggle="modal" data-target="#ver-reserva-user">Detalles reserva</button>
                    </td>
                </tr>

                <tr v-if="tipoMostrar.prestamos" v-for="prestamo in objetosMostrar">
                    <td>{{prestamo.titulo}}</td>
                    <td>{{prestamo.fecha_prestamo}}</td>
                    <td>{{prestamo.fin_prestamo}}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs" @click="seleccionarPrestamo(prestamo)" title="Detalles préstamo"data-toggle="modal" data-target="#ver-prestamo-user">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#renovar-prestamo" @click="seleccionarPrestamo(prestamo)">Renovar</button>
                    </td>
                </tr>

                <tr v-if="tipoMostrar.retrasos" v-for="retraso in objetosMostrar">
                    <td>{{retraso.titulo}}</td>
                    <td>{{retraso.fecha_retraso}}</td>
                    <td>{{retraso.dias_retraso}}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs" @click="seleccionarRetraso(retraso)" title="Detalles retraso"data-toggle="modal" data-target="#ver-retraso-user">Detalles retraso</button>
                    </td>
                </tr>

            </tbody>  
        </table>

        <!--se muestra sino hay datos que mostrar-->
        <div v-else class="alert alert-danger">
            <p><strong>No hay {{tipo}} que mostrar.</strong></p>
        </div> 

    </div>
    <!-- se muestra si al aplicar un filtro no hay coincidencias-->
    <div v-else class="alert alert-danger">
        <p><strong>No hay coincidencias en tu búsqueda.</strong></p>
    </div>

    <!--paginador, solo se muestra si hay mas de una pagina en la tabla-->
    <div v-if="numeroPaginas > 1" id="paginador-usuario">
        <nav aria-label="Navegador usuario" class="pull-right">
            <ul class="pagination pagination-sm">
                <li :value="-1" @click="setPaginaActual($event)" class="page-item">
                  <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>
                <li :value="1" @click="setPaginaActual($event)" class="page-item active"><a class="page-link" href="#">1</a></li>
                <li v-for="i in numeroPaginas-1" :value="i+1" @click="setPaginaActual($event)" class="page-item"><a class="page-link" href="#">{{i+1}}</a></li>
                <li :value="-2"@click="setPaginaActual($event)"class="page-item">
                  <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
            </ul>
        </nav>
    </div>

        <!--Ventanas modales que se muestran por la accion de los botones -->

            <!--Pestaña libros-->
            <verlibro id="ver-libro" tabindex="-1" role="dialog" aria-labelledby="ver-libro" aria-hidden="true" :libro="objetoSeleccionado"></verlibro>
            <reservarlibro id="reservar-libro" tabindex="-1" role="dialog" aria-labelledby="reservar-libro" aria-hidden="true" :usuario="usuario" :libro="objetoSeleccionado" :devolverMensaje="establecerMensaje"></reservarlibro>


            <!--Pestaña usuarios-->
            <addusuario id="add-usuario" tabindex="-1" role="dialog" aria-labelledy="add-usuario" aria-hidden="true" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></addusuario> 
            <verusuario id="ver-usuario" tabindex="-1" role="dialog" aria-labelledy="ver-usuario" aria-hidden="true" :usuario="objetoSeleccionado"></verusuario>
            <eliminarusuario id="eliminar-usuario" tabindex="-1" role="dialog" aria-labelledy="ver-usuario" aria-hidden="true" :usuario="objetoSeleccionado" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></eliminarusuario>

            <!--Pestaña reservas-->
            <verreservauser id="ver-reserva-user" tabindex="-1" role="dialog" aria-labelledby="ver-reserva-user" aria-hidden="true" :reserva="objetoSeleccionado"></verreservauser>
            <confirmarreserva id="confirmar-reserva" tabindex="-1" role="dialog" aria-labelledy="confirmar-reserva" aria-hidden="true" :reserva="objetoSeleccionado" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></confirmarreserva>

            <!--Pestaña prestamos-->
            <verprestamouser id="ver-prestamo-user" tabindex="-1" role="dialog" aria-labelledby="ver-prestamo-user" aria-hidden="true" :prestamo="objetoSeleccionado"></verprestamouser>
            <devolucionprestamo id="devolucion-prestamo" tabindex="-1" role="dialog" aria-labelledy="devolucion-prestamo" aria-hidden="true" :prestamo="objetoSeleccionado" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></devolucionprestamo>
            <renovarprestamo id="renovar-prestamo" tabindex="-1" role="dialog" aria-labelledy="renovar-prestamo" aria-hidden="true" :prestamo="objetoSeleccionado" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></renovarprestamo>

            <!--Pestaña retrasos-->
            <verretrasouser id="ver-retraso-user" tabindex="-1" role="dialog" aria-labelledby="ver-retraso-user" aria-hidden="true" :retraso="objetoSeleccionado"></verretrasouser>
            <devolucionretraso id="devolucion-retraso" tabindex="-1" role="dialog" aria-labelledy="devolucion-prestamo" aria-hidden="true" :retraso="objetoSeleccionado" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></devolucionretraso>

</div>
</div>
</template>

<script>

   export default {

        mounted(){
            //Al cargar la pagina nos mostrara los libros
            axios.get('libros')
                .then( response => this.obtenerObjetosInicio(response.data) )
                .catch( error => console.log(error) )
        },

        /*Datos que le enviamos al componente desde <iniciouser>*/
        props: {
            usuario: { required: true, type:Object },
            actualizarDatos: {required: true, type: Function},//Funcion que esta escuchando en el componente padre para actualizar los datos ante cualquier evento que se produzca 
            tipo: { required: true, type: String },//Tipo de objeto que recibiremos para mostrar
            datos: {required: true, type: Array },//Datos de los objetos que recibimos
            columnas: { required:true, type: Array}//Columnas que mostraremos en las tablas de los objetos que recibimos
        },
        /**Escucha los cambios que se producen tanto en los datos que le enviamos como en los propios datos del componente**/
        watch:{
            columnas: function(){
                this.columnasMostrar = this.columnas;//Al cambiar las columnas que enviamos cambia las columnas que tiene que mostrar
            },
            tipo: function(){
                this.mostrarPagina = false;//Ponemos a false para que no se muestre la pagina mientras se estan cargando los datos
                this.establecerTipo();//Establecemos el tipo de objeto a mostrar
            },
            datos: function(){
                this.paginaActual = 1;//Si cambiamos de pestaña mostramos los datos desde el primero
                this.objetosTotales = this.datos;
                this.objetosTabla = this.datos;
                this.objetosMostrar = [];
                this.mostrarPagina = true;//Una vez cargados los datos ya podemos mostrar la página
                if(this.datos.length != 0){
                    this.hayDatos =true;
                    this.setNumeroPaginas(this.datos.length);
                }else{
                    this.hayDatos = false;
                    this.numeroPaginas = 0;
                }
            },
            //Escucha si se cambia de pagina y cambia la pagina activa en el paginador
            paginaActual(){
                this.setPaginaActiva(this.paginaActual);
            }
        },

        data(){
            return{
                mensaje: '',//Mensaje que devuelve el servidor cuando realizamos una accion
                hayDatos: true,//Variable que establece si hay datos que mostrar
                mostrarPagina:true,//Variable que controla que se han cargado los datos recibidos para no renderizar la página hasta entonces
                tipoMostrar: { libros:true, usuarios:false, reservas:false, prestamos:false, retrasos:false },//Variable que establece los datos que se tienen que mostrar, al cargar establecemos que nos muestre los libros
                columnasMostrar: ['Titulo','Autor','Editorial','Acciones'],//Por defecto serán las de los libros que es la tabla que se muestra al cargar la página
                objetoSeleccionado: {},

                /**Datos para la paginacion*/
                objetosTotales: [],//objetos totales que obtenemos del servidor, a los que se les aplicará el filtro
                objetosTabla: [],//objetos que al cargar son los mismos que los objetostotales pero que van variando al aplicar los filtros
                objetosMostrar: [],//Objetos que mostraremos en la pagina actual de la tabla
                objetosPagina: 12,//filas de la tabla por pagina
                numeroPaginas: '',//Variable que establece el numero de paginas de la tabla dependiendo del total de objetos y de los objetos por pagina
                paginaActual: 1,
                filtro: '',
                camposFiltro: ['titulo','autor','editorial','isbn'],
                hayCoincidencias: true,
            }
        },
        methods:{

            obtenerObjetosInicio(objetos){
                this.objetosTotales = objetos;
                this.objetosTabla = objetos;
                this.setNumeroPaginas(objetos.length);
                
            },
            /*Funcion que establece el tipo de objeto que se mostrara en la tabla*/
            establecerTipo(){
                for(var objeto in this.tipoMostrar){
                    if( objeto == this.tipo){
                        this.tipoMostrar[objeto] = true;
                    }else{
                        this.tipoMostrar[objeto] = false;
                    }  
                }
            },
            /**Funcion que recibe como argumento un string con la tabla a actualizar cuando se produce una accion**/
            actualizarTabla(tabla){
                this.actualizarDatos(tabla);
            },
            /**Funcion que nos muestra un mensaje por cada accion que efectuamos*/
            /**El mensaje a mostrar lo recibe de las ventanas modales que son hijas de este componente*/
            establecerMensaje(respuesta){
                
                this.mensaje = respuesta.mensaje;
                
                if(respuesta.correcto){
                    $('#mensajes-objetos-user').removeClass('alert-danger');
                    $('#mensajes-objetos-user').addClass('alert-success');
                }else{
                    $('#mensajes-objetos-user').removeClass('alert-success');
                    $('#mensajes-objetos-user').addClass('alert-danger');
                }
              
                $('#mensajes-objetos-user').show('slow').delay(3000).hide('slow');   
            },

            /**Funcion que selecciona el libro al pulsar en una de las acciones que se pueden hacer sobre el**/
            /**Es necesario obtener los libros de la base de datos para que obtenga el numero de prestamos, reservas y retrasos que tiene**/
            seleccionarLibro(id){
                axios.get('/libros/'+id)
                            .then(response => this.objetoSeleccionado = response.data )
                            .catch(error => console.log('error servidor'))    
            },

            /**Funcion que selecciona la reserva al pulsar en una de las acciones que se pueden hacer sobre el**/
            seleccionarReserva(reserva){
                this.objetoSeleccionado = reserva;
            },
            /**Funcion que selecciona el prestamo al pulsar en una de las acciones que se pueden hacer sobre el**/
            seleccionarPrestamo(prestamo){
                this.objetoSeleccionado = prestamo;
            },
            /**Funcion que selecciona el retraso al pulsar en una de las acciones que se pueden hacer sobre el**/
            seleccionarRetraso(retraso){
                this.objetoSeleccionado = retraso;
            },
            

            /**Funcion que recibe el numero de datos  y establece el numero de paginas en las que se divide la tabla**/
            setNumeroPaginas(numeroDatos){

                if(this.numeroDatos % this.objetosPagina == 0){
                    this.numeroPaginas = numeroDatos / this.objetosPagina;
                }else{
                    this.numeroPaginas = Math.trunc(numeroDatos / this.objetosPagina)+1;
                }
                this.setObjetosMostrar();
            },
            /*Funcion que establece la pagina actual de la tabla al pulsar sobre el paginador*/
            setPaginaActual(event){

                if(event.currentTarget.value == -1){
                    if(this.paginaActual > 1){
                        this.paginaActual -= 1;
                    }else{
                        this.paginaActual = 1
                    } 
                }else if(event.currentTarget.value == -2){
                    if(this.paginaActual< this.numeroPaginas){
                        this.paginaActual += 1;
                    }else{
                        this.paginaActual = this.numeroPaginas
                    }   
                }else{
                    this.paginaActual = event.currentTarget.value;
                }

                this.setObjetosMostrar();
            },
            /**Funcion que establece los objetos que se muestran en la pagina actual de la tabla**/
            setObjetosMostrar(){
                
                var aPartirDe = this.paginaActual * this.objetosPagina - this.objetosPagina;

                this.objetosMostrar = this.objetosTabla.slice(aPartirDe, aPartirDe+this.objetosPagina);   
            },

            /*Funcion que establece la clase de pagina actual como activa*/
            setPaginaActiva(num){
                $('.pagination li').removeClass('active');
                $('.pagination li[value='+num+']').addClass('active');
            },

            /**Filtra los objetos con la cadena de la caja de textos buscandola en los campos del filtro**/
            filtrarObjetos(){

                this.hayCoincidencias= true;
                var cadena = this.limpiarTildes(this.filtro.toLowerCase());
                
                var objetosFiltro = [];
        
                
                for(var i=0; i<this.objetosTotales.length; i++){

                    var objeto = this.objetosTotales[i];
                    var a = true;

                    for(var j=0; j<this.camposFiltro.length && a; j++){
                            
                        var col = this.camposFiltro[j];
                        if( this.limpiarTildes(objeto[col]).toLowerCase().indexOf(cadena) != -1){
                            objetosFiltro.push(objeto);
                            a = false;
                        }
                    }
                }
                this.paginaActual = 1;
                this.objetosTabla = objetosFiltro;  
                if(objetosFiltro.length == 0 ){this.hayCoincidencias = false; } 
                this.setNumeroPaginas(objetosFiltro.length);
            },
            limpiarTildes(cadena){
                cadena = cadena.replace(/á/gi,"a");
                cadena = cadena.replace(/é/gi,"e");
                cadena = cadena.replace(/í/gi,"i");
                cadena = cadena.replace(/ó/gi,"o");
                cadena = cadena.replace(/ú/gi,"u");

                return cadena;
            }
        }
    }
</script>