import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({

    state: {
        user: null,
        friends: null,
        groups: null
    },

    mutations: {

        updateUser: (state, user) => state.user = user,

        updateFriends: (state, friends) => state.friends = friends,

        updateGroups: (state, groups) => state.groups = groups

    }

});