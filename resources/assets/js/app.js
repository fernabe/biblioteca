
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

//Componentes administrador
Vue.component('inicioadmin', require('./components/admin/Inicioadmin.vue'));
Vue.component('datosadmin', require('./components/admin/Datosadmin.vue'));

Vue.component('addlibro', require('./components/admin/dialogs/Addlibro.vue'));
Vue.component('editarlibro', require('./components/admin/dialogs/Editarlibro.vue'));
Vue.component('eliminarlibro', require('./components/admin/dialogs/Eliminarlibro.vue'));
Vue.component('prestarlibro', require('./components/admin/dialogs/Prestarlibro.vue'));

Vue.component('addusuario', require('./components/admin/dialogs/Addusuario.vue'));
Vue.component('verusuario', require('./components/admin/dialogs/Verusuario.vue'));
Vue.component('eliminarusuario',require('./components/admin/dialogs/Eliminarusuario.vue'));

Vue.component('verreserva', require('./components/admin/dialogs/Verreserva.vue'));
Vue.component('confirmarreserva', require('./components/admin/dialogs/Confirmarreserva.vue'));

Vue.component('devolucionprestamo', require('./components/admin/dialogs/Devolucionprestamo.vue'));
Vue.component('verprestamo', require('./components/admin/dialogs/Verprestamo.vue'));

Vue.component('verretraso', require('./components/admin/dialogs/Verretraso.vue'));
Vue.component('devolucionretraso', require('./components/admin/dialogs/Devolucionretraso.vue'));


Vue.component('crearadmin', require('./components/admin/dialogs/Crearadmin.vue'));

//Componentes usuario

Vue.component('iniciousuario', require('./components/user/Iniciousuario.vue'));

Vue.component('datosusuario', require('./components/user/Datosusuario.vue'));

Vue.component('verlibrouser' , require('./components/user/dialogs/Verlibro.vue'));
Vue.component('reservarlibro', require('./components/user/dialogs/Reservarlibro.vue'));

Vue.component('verreservauser', require('./components/user/dialogs/Verreserva.vue'));
Vue.component('verprestamouser', require('./components/user/dialogs/Verprestamo.vue'));
Vue.component('verretrasouser', require('./components/user/dialogs/Verretraso.vue'));

Vue.component('verperfil', require('./components/user/dialogs/Verperfil.vue'));

Vue.component('mensajes', require('./components/user/mensajes/Mensajes.vue'));

//Componentes comunes
Vue.component('renovarprestamo', require('./components/comunes/Renovarprestamo.vue'));
Vue.component('verlibro', require('./components/comunes/Verlibro.vue'));

const app = new Vue({
    el: '#app'
});