<template>   
<div id="contenido-admin" class="contenido-tab">

<div hidden id="mensajes-objetos-admin" class="alert alert-danger alert-success">
    <strong>{{mensaje}}</strong> 
</div>

<div v-if="mostrarPagina">

    <div class="buscador">
        <div class="row">
            <div class="boton-buscar col-xs-12 col-sm-6 pull-left">
                <button v-if="tipoMostrar.libros" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-libro">Añadir libro</button>
                <button v-if="tipoMostrar.usuarios" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-usuario">Añadir usuario</button>
            </div>

            <div id="buscardor-admin" class="boton-buscar col-xs-12 col-sm-6 pull-right">
                <div class="inner-addon right-addon">
                    <i class="glyphicon glyphicon-search"></i>
                    <input id="buscar-admin" type="search" class="form-control" placeholder="Buscar" :disabled="!hayDatos" @keyup="filtrarObjetos" v-model="filtro">
                </div>
            </div>
        </div>
    </div>

    <div v-if="hayCoincidencias" class="table-responsive"  style="border-style:none">
        <table v-if="hayDatos" id="tabla-objetos-admin" class="table">
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
                        <button type="button" class="btn btn-primary btn-xs" @click="seleccionarLibro(libro.id)" title="Editar libro" data-toggle="modal" data-target="#editar-libro">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <button type="button" class="btn btn-danger btn-xs" @click="seleccionarLibro(libro.id)" title="Elminar libro" data-toggle="modal" data-target="#eliminar-libro">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                        <button type="button" class="btn btn-success btn-xs" @click="seleccionarLibro(libro.id)" data-toggle="modal" data-target="#prestar-libro">Prestar</button>
                    </td>
                </tr>

                <tr v-if="tipoMostrar.usuarios" v-for="usuario in objetosMostrar">
                    <td>{{usuario.nombre}}</td>
                    <td>{{usuario.apellido1}}</td>
                    <td>{{usuario.apellido2}}</td>
                    <td>{{usuario.email}}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs" title="Ver usuario" @click="seleccionarUsuario(usuario.id)" data-toggle="modal" data-target="#ver-usuario">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        <button type="button" class="btn btn-danger btn-xs" @click="seleccionarUsuario(usuario.id)" title="Eliminar usuario" data-toggle="modal" data-target="#eliminar-usuario">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </td>
                </tr>

                <tr v-if="tipoMostrar.reservas" v-for="reserva in objetosMostrar">
                    <td>{{reserva.nombre}} {{reserva.apellido1}}</td>
                    <td>{{reserva.titulo}}</td>
                    <td>{{reserva.fecha_reserva}}</td>
                    <td>{{reserva.fin_reserva}}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs" @click="seleccionarReserva(reserva)" title="Detalles reserva" data-toggle="modal" data-target="#ver-reserva">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#confirmar-reserva" @click="seleccionarReserva(reserva)">Confirmar</button>
                    </td>
                </tr>

                <tr v-if="tipoMostrar.prestamos" v-for="prestamo in objetosMostrar">
                    <td>{{prestamo.nombre}} {{prestamo.apellido1}}</td>
                    <td>{{prestamo.titulo}}</td>
                    <td>{{prestamo.fecha_prestamo}}</td>
                    <td>{{prestamo.fin_prestamo}}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs" @click="seleccionarPrestamo(prestamo)" title="Detalles préstamo" data-toggle="modal" data-target="#ver-prestamo">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#renovar-prestamo" @click="seleccionarPrestamo(prestamo)">Renovar</button>
                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#devolucion-prestamo" @click="seleccionarPrestamo(prestamo)">Devolución</button> 
                    </td>
                </tr>

                <tr v-if="tipoMostrar.retrasos" v-for="retraso in objetosMostrar">
                    <td>{{retraso.nombre}} {{retraso.apellido1}}</td>
                    <td>{{retraso.titulo}}</td>
                    <td>{{retraso.fecha_retraso}}</td>
                    <td>{{retraso.dias_retraso}}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs" @click="seleccionarRetraso(retraso)" title="Detalles retraso" data-toggle="modal" data-target="#ver-retraso">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#devolucion-retraso" @click="seleccionarRetraso(retraso)">Devolución</button>
                    </td>
                </tr>

            </tbody>     
        </table>

        <div v-else class="alert alert-danger">
            <p><strong>No hay {{tipo}} que mostrar.</strong></p>
        </div> 
    </div>
    
    <div v-else class="alert alert-danger">
        <p><strong>No hay coincidencias en tu búsqueda.</strong></p>
    </div>
    
    <!--paginador, solo se muestra si hay mas de una pagina en la tabla-->
    <div v-if="numeroPaginas > 1" id="paginador-admin">
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
            <addlibro id="add-libro" tabindex="-1" role="dialog" aria-labelledby="add-libro" aria-hidden="true" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></addlibro>
            <verlibro id="ver-libro" tabindex="-1" role="dialog" aria-labelledby="ver-libro" aria-hidden="true" :libro="objetoSeleccionado"></verlibro>
            <editarlibro id="editar-libro" tabindex="-1" role="dialog" aria-labelledby="editar-libro" aria-hidden="true" :libro="objetoSeleccionado" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></editarlibro>
            <eliminarlibro id="eliminar-libro" tabindex="-1" role="dialog" aria-labelledby="eliminar-libro" aria-hidden="true" :libro="objetoSeleccionado" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></eliminarlibro>
            <prestarlibro id="prestar-libro" tabindex="-1" role="dialog" aria-labelledby="prestar-libro" aria-hidden="true" :libro="objetoSeleccionado" :devolverMensaje="establecerMensaje"></prestarlibro>


            <!--Pestaña usuarios-->
            <addusuario id="add-usuario" tabindex="-1" role="dialog" aria-labelledy="add-usuario" aria-hidden="true" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></addusuario> 
            <verusuario id="ver-usuario" tabindex="-1" role="dialog" aria-labelledy="ver-usuario" aria-hidden="true" :usuario="objetoSeleccionado"></verusuario>
            <eliminarusuario id="eliminar-usuario" tabindex="-1" role="dialog" aria-labelledy="ver-usuario" aria-hidden="true" :usuario="objetoSeleccionado" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></eliminarusuario>

            <!--Pestaña reservas-->
            <verreserva id="ver-reserva" tabindex="-1" role="dialog" aria-labelledy="ver-reserva" aria-hidden="true" :reserva="objetoSeleccionado"></verreserva>
            <confirmarreserva id="confirmar-reserva" tabindex="-1" role="dialog" aria-labelledy="confirmar-reserva" aria-hidden="true" :reserva="objetoSeleccionado" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></confirmarreserva>

            <!--Pestaña prestamos-->
            <devolucionprestamo id="devolucion-prestamo" tabindex="-1" role="dialog" aria-labelledy="devolucion-prestamo" aria-hidden="true" :prestamo="objetoSeleccionado" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></devolucionprestamo>
            <renovarprestamo id="renovar-prestamo" tabindex="-1" role="dialog" aria-labelledy="renovar-prestamo" aria-hidden="true" :prestamo="objetoSeleccionado" :actualizarTabla="actualizarTabla" :devolverMensaje="establecerMensaje"></renovarprestamo>
            <verprestamo id="ver-prestamo" tabindex="-1" role="dialog" aria-labelledy="ver-prestamo" aria-hidden="true" :prestamo="objetoSeleccionado"></verprestamo>
            <!--Pestaña retrasos-->
            <verretraso id="ver-retraso" tabindex="-1" role="dialog" aria-labelledy="ver-retraso" aria-hidden="true" :retraso="objetoSeleccionado"></verretraso>
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
        props: {//Datos que le enviamos a la plantilla desde la plantilla padre
            actualizarDatos: {required: true, type: Function},
            tipo: { required: true, type: String },//Tipo de objeto que recibiremos para mostrar
            datos: {required: true, type: Array },//Datos de los objetos que recibimos
            columnas: { required:true, type: Array},//Columnas que mostraremos en las tablas de los objetos que recibimos
            columnasFiltro: {required: true, type: Array}
        },
        watch:{//Escucha los cambios de los datos que enviamos a la plantilla

            columnas: function(){
                this.columnasMostrar = this.columnas;//Al cambiar las columnas que enviamos cambia las columnas que tiene que mostrar
            },
            columnasFiltro: function(){
                this.camposFiltro = this.columnasFiltro;
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
                objetosTotales: [],
                objetosMostrar: [],//Objetos que mostraremos en la tabla de la pagina, por defecto seran los libros
                objetoSeleccionado: {},

                /**Datos para la paginacion*/
                objetosTabla: [],
                objetosPagina: 12,
                numeroPaginas: '',
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
            establecerMensaje(respuesta){
                
                this.mensaje = respuesta.mensaje;
                
                if(respuesta.correcto){
                    $('#mensajes-objetos-admin').removeClass('alert-danger');
                    $('#mensajes-objetos-admin').addClass('alert-success');
                }else{
                    $('#mensajes-objetos-admin').removeClass('alert-success');
                    $('#mensajes-objetos-admin').addClass('alert-danger');
                }
              
                $('#mensajes-objetos-admin').show('slow').delay(3000).hide('slow');   
            },
            seleccionarLibro(id){
                axios.get('/libros/'+id)
                            .then(response => this.objetoSeleccionado = response.data )
                            .catch(error => console.log('error servidor'))    
            },
            seleccionarUsuario(id){
                axios.get('/usuarios/'+id)
                            .then(response => this.objetoSeleccionado = response.data )
                            .catch(error => console.log('error servidor'))    
            },

            seleccionarReserva(reserva){
                this.objetoSeleccionado = reserva;
            },
            seleccionarPrestamo(prestamo){
                this.objetoSeleccionado = prestamo;
            },
            seleccionarRetraso(retraso){
                this.objetoSeleccionado = retraso;
            },
            /*Metodos para el funcionamiento de la tabla*/

            setNumeroPaginas(numeroDatos){

                if(this.numeroDatos % this.objetosPagina == 0){
                    this.numeroPaginas = numeroDatos / this.objetosPagina;
                }else{
                    this.numeroPaginas = Math.trunc(numeroDatos / this.objetosPagina)+1;
                }
                this.setObjetosMostrar();
            },
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
            setObjetosMostrar(){
                
                var aPartirDe = this.paginaActual * this.objetosPagina - this.objetosPagina;

                this.objetosMostrar = this.objetosTabla.slice(aPartirDe, aPartirDe+this.objetosPagina);   
            },

            setPaginaActiva(num){
                $('.pagination li').removeClass('active');
                $('.pagination li[value='+num+']').addClass('active');
            },

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