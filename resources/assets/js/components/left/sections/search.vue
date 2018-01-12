<template lang="pug">

    #search_app
        .wrap-input
            .input
                i.material-icons search
                input.input-global(type='text', v-model='name', v-on:keyup='updateGroups', placeholder='Search...')


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

                this.$eventBus.$emit('update', {
                    type: 'group',
                    filtered: this.$store.state.groups.filter(g => g.name.match(new RegExp(this.name, 'i')))
                });

            }

        },

        computed: {



        }

    }
</script>
