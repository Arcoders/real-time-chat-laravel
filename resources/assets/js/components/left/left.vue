<template>
    <div id="left_app">

        <div class="profile">
            <img src="https://avatars.io/twitter/nada">
            <div class="icons">
                <i class="fa fa-pencil" aria-hidden="true"></i>
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                <i class="fa fa-users" aria-hidden="true"></i>
                <i class="fa fa-cog" aria-hidden="true"></i>
                <i class="fa fa-bell" aria-hidden="true"></i>
                <i class="fa fa-power-off" aria-hidden="true"></i>
            </div>
        </div>

        <search></search>

        <div class="wrap-filter">
            <div class="link_filter">
                <router-link to="/" exact-active-class="active">Private</router-link>
            </div>
            <div class="link_filter">
                <router-link to="/" exact-active-class="active">Groups</router-link>
            </div>
        </div>

        <div class="contact-list">
            <private></private>
        </div>

    </div>
</template>

<style scoped>
    .contact-list {
        height: calc(98vh - 180px);
    }
</style>

<script>
    export default {
        mounted() {
            console.log('Left ok!')
        }
    }
</script>
