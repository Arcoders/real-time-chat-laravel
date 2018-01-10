import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({

    state: {
        user: null
    },

    mutations: {
        updateUser: (state, user) => state.user = user
    }

});