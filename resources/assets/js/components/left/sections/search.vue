<template>
    <div id="search_app">

        <div class="wrap-input">
            <div class="input">
                <i class="material-icons">search</i>
                <input type="text" v-model='name' v-on:keyup="updateGroups" class="input-global" placeholder="Search contact...">
            </div>
        </div>

    </div>
</template>

<script>
    export default {

        data() {
            return {
                groups: null,
                name: ''
            }
        },

        mounted() {
            console.log('Search ok!');
        },

        methods: {

            updateGroups() {

                this.groups = this.$store.state.groups;

                let hola = this.groups.filter(g => g.name.match("/arco/i"));

                console.log(hola);

                //this.$store.commit('updateGroups', this.groups);

            }

        },

        computed: {



        }

    }
</script>
