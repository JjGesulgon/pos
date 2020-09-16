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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './views/layouts/App';
import router from './router';
import store from './store';
import VueSelect from 'vue-select';
import DocumentGenerator from './plugins/document-generator';

// Component to Component Broadcasting
window.Broadcast = new Vue();

// Vue Select
Vue.component('vue-select', VueSelect);

// Document Generator
Vue.use(DocumentGenerator);

// Layouts
Vue.component('navbar', require('./views/layouts/Navbar.vue'));
Vue.component('sidebar', require('./views/layouts/Sidebar.vue'));
Vue.component('search', require('./components/Search.vue'));
Vue.component('pagination', require('./components/Pagination.vue'));
Vue.component('search-modal', require('./components/SearchModal.vue'));
Vue.component('data-table', require('./components/DataTable.vue'));
Vue.component('data-table-row-action', require('./components/DataTableRowAction.vue'));
Vue.component('form-title', require('./components/FormTitle.vue'));
Vue.component('form-create', require('./components/FormCreate.vue'));
Vue.component('form-view', require('./components/FormView.vue'));
Vue.component('form-edit', require('./components/FormEdit.vue'));
Vue.component('breadcrumbs', require('./components/Breadcrumbs.vue'));
Vue.component('line-chart', require('./components/Chart.vue'));

const app = new Vue({
    el: '#app',
    components: { 'app': App },
    store,
    router
});
