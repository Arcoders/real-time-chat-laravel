
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Avatar from 'vue-avatar';
const VueResource = require('vue-resource');

window.Vue.use(VueRouter);
window.Vue.use(VueResource);

// headers

Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementById('csrf-token').getAttribute('content');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Components for left side

Vue.component('left', require('./components/left/left.vue'));
Vue.component('groups', require('./components/left/sections/groups.vue'));
Vue.component('private', require('./components/left/sections/private.vue'));
Vue.component('search', require('./components/left/sections/search.vue'));

// Components for right side

Vue.component('bar', require('./components/right/chat/bar.vue'));
Vue.component('messages', require('./components/right/chat/messages.vue'));
Vue.component('send', require('./components/right/chat/send.vue'));

// Global components

Vue.component('avatar', Avatar);

// Define route components

import right from './components/right/right.vue';
import bienvenido from './components/right/bienvenido.vue';

import profile from './components/right/profile/profile.vue';
import edit_profile from './components/right/profile/edit_profile';

import groups from './components/right/groups/manage_groups.vue';
import all_groups from './components/right/groups/all_groups.vue';
import my_groups from './components/right/groups/my_groups.vue';

// Define some routes

const router = new VueRouter({
    routes: [
        { path: '/', component: bienvenido},
        {
            path: '/profile', component: profile,
            children: [
                { path: 'edit', component: edit_profile }
            ]
        },
        {
            path: '/groups', component: groups,
            children: [
                { path: 'my', component: my_groups },
                { path: 'all', component: all_groups }
            ]
        },
        { path: '/private/:private_id/:user_name', component: right, name: 'private'},
    ]
});


new Vue({
    el: '#app',
    router
}).$mount(this.el);
