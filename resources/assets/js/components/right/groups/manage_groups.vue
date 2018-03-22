<template lang="pug">
    #manage_groups_app

        .head

            h1
                i.material-icons group_add

            .info
                p Groups
                p.online You can create public chat rooms for all users...

        .groups_box
            .content

                .groups(v-if="$route.path == '/groups'")
                    .group
                        router-link(to='groups/add', exact-active-class='active') Add groups
                    .group
                        router-link(to='groups/my') My groups

                router-view
</template>

<script>
    export default {
        mounted() {
            console.log('Groups ok!')
        }
    }
</script>
