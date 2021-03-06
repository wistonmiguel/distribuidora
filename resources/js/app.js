/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('almacen-crud', require('./components/AlmacenComponent.vue').default);
Vue.component('proveedor-crud', require('./components/ProveedorComponent.vue').default);
Vue.component('producto-crud', require('./components/ProductoComponent.vue').default);
Vue.component('inventario-crud', require('./components/InventarioComponent.vue').default);
Vue.component('comprador-crud', require('./components/CompradorComponent.vue').default);
Vue.component('vendedor-crud', require('./components/VendedorComponent.vue').default);
Vue.component('cliente-crud', require('./components/ClienteComponent.vue').default);
Vue.component('tipopago-crud', require('./components/TipoPagoComponent.vue').default);
Vue.component('compra-management', require('./components/CompraComponent.vue').default);
Vue.component('comprasdevolucion-management', require('./components/ComprasDevolucionComponent.vue').default);
Vue.component('pedido-management', require('./components/PedidoComponent.vue').default);
Vue.component('venta-management', require('./components/VentaComponent.vue').default);
Vue.component('ventasdevolucion-management', require('./components/VentasDevolucionComponent.vue').default);
Vue.component('informe-panel', require('./components/InformeComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
