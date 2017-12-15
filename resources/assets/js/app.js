
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

import Vue from 'vue';
import VueRouter from 'vue-router';

/*import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css'

Vue.use(VueMaterial);*/

window.Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Components for left side

Vue.component('left', require('./components/left/left.vue'));
Vue.component('groups', require('./components/left/groups.vue'));
Vue.component('private', require('./components/left/private.vue'));
Vue.component('search', require('./components/left/search.vue'));

// Components for right side

Vue.component('bar', require('./components/right/bar.vue'));
Vue.component('box', require('./components/right/box.vue'));
Vue.component('messages', require('./components/right/messages.vue'));
Vue.component('send', require('./components/right/send.vue'));

// Define route components

import right from './components/right/right.vue';
import bienvenido from './components/right/bienvenido.vue';

// Define some routes

const router = new VueRouter({
    routes: [
        { path: '/', component: bienvenido},
        { path: '/private/:private_id/:name', component: right, name: 'private'}
    ]
});


new Vue({
    el: '#app',
    router
}).$mount(this.el);
