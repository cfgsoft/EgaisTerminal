/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import store from './store/store';

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

import { Pagination } from 'bootstrap-vue/es/components';
Vue.use(Pagination);

import App from './components/App.vue';
import Home from './components/Home.vue';
import Hello from './components/Hello.vue';
import Order from './components/Order.vue';
import OrderEdit from './components/OrderEdit.vue';
import OrderError from './components/OrderError.vue';


Vue.use(VueRouter);

export var router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/hello',
            name: 'hello',
            component: Hello
        },
        {
            path: '/order',
            name: 'order',
            component: Order
        },
        {
            path: '/order/:id',
            name: 'orderEdit',
            component: OrderEdit
        },
        {
            path: '/orderError',
            name: 'orderError',
            component: OrderError
        }
    ]
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    router: router,
    store: store,
    render: app => app(App)
});
