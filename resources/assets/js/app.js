
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

import Vue from 'vue';
/*import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css'

Vue.use(VueMaterial);*/

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Components for left side

Vue.component('left', require('./components/left/left.vue'));
Vue.component('search', require('./components/left/search.vue'));
Vue.component('groups', require('./components/left/groups.vue'));
Vue.component('private', require('./components/left/private.vue'));

// Components for right side

Vue.component('right', require('./components/right/right.vue'));
Vue.component('box', require('./components/right/box.vue'));
Vue.component('send', require('./components/right/send.vue'));

const app = new Vue({
    el: '#app'
});
