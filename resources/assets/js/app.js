
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Avatar from 'vue-avatar';
import Multiselect from 'vue-multiselect';
import VueChatScroll from 'vue-chat-scroll';

import VueResource from 'vue-resource';
import VuePusher from 'vue-pusher';
import VueMoment from 'vue-moment';
import VueTruncate from 'vue-truncate-filter';
import {store} from './store/store';

const CSRF = document.getElementById('csrf-token').getAttribute('content');

window.Vue.use(VueRouter);
window.Vue.use(VueResource);
window.Vue.use(VueMoment);
window.Vue.use(VueTruncate);
window.Vue.use(VueChatScroll);

window.Vue.use(VuePusher, {
    api_key: '60efd870de38efff2291',
    options: {
        cluster: 'eu',
        encrypted: true,
    }
});

// headers

Vue.http.headers.common['X-CSRF-TOKEN'] = CSRF;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Global component

Vue.component('global', require('./components/global.vue'));

// Components for left side

Vue.component('left', require('./components/left/left.vue'));
Vue.component('list', require('./components/left/sections/list.vue'));
Vue.component('search', require('./components/left/sections/search.vue'));
Vue.component('allnotifications', require('./components/left/sections/show_notifications.vue'));

// Components for right side

Vue.component('messages', require('./components/right/chat/messages.vue'));
Vue.component('send', require('./components/right/chat/send.vue'));
Vue.component('friendship', require('./components/right/friends/friendship.vue'));

// Global components

Vue.component('avatar', Avatar);
Vue.component('loading', require('./components/spinner/loading.vue'));
Vue.component('notifications', require('./components/notifications/notifications.vue'));
Vue.component('paginate', require('./components/pagination/paginate.vue'));
Vue.component('multiselect', Multiselect);

// Define route components

import chat_group from './components/right/chat_group.vue';
import chat_friends from './components/right/chat_friends.vue';
import welcome from './components/right/welcome.vue';

import profile from './components/right/profile/profile.vue';
import edit_profile from './components/right/profile/edit_profile';

import groups from './components/right/groups/manage_groups.vue';
import my_groups from './components/right/groups/my_groups.vue';
import add_group from './components/right/groups/add_group.vue';
import edit_group from './components/right/groups/edit_group.vue';

// Define some routes

const router = new VueRouter({
    routes: [
        { path: '/', component: welcome},
        {
            path: '/profile/:profile_id?', component: profile, name: 'profile',
            children: [
                { path: 'edit', component: edit_profile, name: 'edit_profile' }
            ]
        },
        {
            path: '/groups', component: groups,
            children: [
                { path: 'my', component: my_groups },
                { path: 'add', component: add_group, name: 'add_group' },
                { path: 'my/:group_id/:group_name', component: edit_group, name: 'edit_group' }
            ]
        },
        { path: '/friend/:chat_id/:friend_name/:friend_id', component: chat_friends, name: 'friend_chat'},
        { path: '/group/:chat_id/:group_name', component: chat_group, name: 'group_chat'},
        { path: '/*', component: welcome }
    ]
});

Vue.prototype.$eventBus = new Vue();

new Vue({
    props: ['auth_user'],
    el: '#app',
    router,
    store,
}).$mount(this.el);
