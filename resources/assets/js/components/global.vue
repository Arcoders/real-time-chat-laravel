<template>
    <div class="wrap">

        <section class="left">

            <left v-show="show"></left>

        </section>


        <section class="right">

            <router-view :key="$route.fullPath" v-show="show"></router-view>

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

        data() {
            return {
                show: false
            }
        },

        // ---------------------------------------------------

        mounted() {
            setTimeout(() => {
                this.show = true;
            }, 1500);
        },

        // ---------------------------------------------------

    }
</script>
