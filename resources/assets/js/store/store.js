import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({

    state: {
        user: null
    },

    getters: {

        // tareasCompletadas: state => state.tareas.filter(tarea => tarea.completado).length

    },

    mutations: {

       updateUser: (state, user) => state.user = user,

    },

    actions: {

        getUsers: ({commit}) => {
            this.$http.get('/get_user').then(response => {

                if (response.status == 200) {

                    if (response.data.length === 0) return;

                    commit('updateUser',response.data);

                } else {
                    // error
                }

            }, () => {
                // error
            });
        },

    }

});