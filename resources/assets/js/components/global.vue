<template>
    <div class="wrap">

        <section class="left">

            <left :auth_user="auth_user"></left>

        </section>


        <section class="right">


            <router-view :key="$route.fullPath"></router-view>


        </section>

    </div>
</template>

<style scoped>

</style>

<script>
    export default {

        // ---------------------------------------------------

        props: ['auth_user'],

        // ---------------------------------------------------

        created() {
            this.$store.commit('updateUser', this.auth_user);
        },

        // ---------------------------------------------------

        mounted() {
            console.log('Global .................');
        }

        // ---------------------------------------------------

    }
</script>
