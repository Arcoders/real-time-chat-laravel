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

                let type = 'chat';

                let friends = this.$store.state.friends.filter(g => g.user.name.match(new RegExp(this.name, 'i')));

                let groups = this.$store.state.groups.filter(g => g.name.match(new RegExp(this.name, 'i')));

                type = (groups.length > 0 && groups.length > friends.length) ? 'group' : 'chat';

                if (this.name === '') type = 'chat';

                this.$eventBus.$emit('update', {type, filter: 'true', filtered: {friends, groups}});

            }

        },

        // ----------------------------------------------

    }
</script>
