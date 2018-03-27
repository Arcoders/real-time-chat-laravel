<template lang="pug">

    #search_app
        .search-container
            .search
                i.material-icons search
                input(type='text', v-model='name', v-on:keyup='updateGroups', placeholder='Search...')


</template>

<script>

    import {mapState} from 'vuex';

    export default {

        data() {
            return {name: ''}
        },

        methods: {

            // ----------------------------------------------

            updateGroups() {

                let type = 'chat';

                let friends = this.friends.filter(g => g.user.name.match(new RegExp(this.name, 'i')));

                let groups = this.groups.filter(g => g.name.match(new RegExp(this.name, 'i')));

                type = (groups.length > 0 && groups.length > friends.length) ? 'group' : 'chat';

                if (this.name === '') type = 'chat';

                this.$eventBus.$emit('update', {type, filter: 'true', filtered: {friends, groups}});

            }

        },

        // ----------------------------------------------

        computed: mapState({
            friends: (state) => state.friends,
            groups: (state) => state.groups
        }),

        // ----------------------------------------------

    }
</script>
