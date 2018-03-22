<template lang="pug">

    .wrap
        section.left
            left(v-show='show')

        section.right
            router-view(:key='$route.fullPath', v-show='show')

</template>

<script>
    export default {

        // ---------------------------------------------------

        props: ['auth_user'],

        // ---------------------------------------------------

        created() {
            this.$store.commit('updateUser', this.auth_user);
        },

        // ---------------------------------------------------

        data() {
            return {
                show: false
            }
        },

        // ---------------------------------------------------

        mounted() {
            setTimeout(() => this.show = true, 0);
        },

        // ---------------------------------------------------

    }
</script>
