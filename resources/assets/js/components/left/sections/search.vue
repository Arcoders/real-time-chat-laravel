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
            return {name: ''}
        },

        methods: {

            // ----------------------------------------------

            updateGroups() {

                this.$eventBus.$emit('update', {
                    type: 'group',
                    action: 'filter',
                    filtered: {
                        friends: this.$store.state.friends.filter(g => g.user.name.match(new RegExp(this.name, 'i'))),
                        groups: this.$store.state.groups.filter(g => g.name.match(new RegExp(this.name, 'i')))
                    }
                });

            }

        },

        // ----------------------------------------------

    }
</script>
