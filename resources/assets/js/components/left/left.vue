<template>
    <div id="left_app">

        <div class="profile">
            <img src="https://avatars.io/twitter/nada">
            <div class="icons">

                <router-link to="/" exact-active-class="active_icon">
                    <i class="material-icons">person</i>
                </router-link>

                <router-link to="/groups" exact-active-class="active_icon">
                    <i class="material-icons">person_add</i>
                </router-link>

                <router-link to="/2" exact-active-class="active_icon">
                    <i class="material-icons">settings</i>
                </router-link>

            </div>
        </div>

        <search></search>

        <div class="wrap-filter">
            <div class="link_filter">
                <router-link to="/" exact-active-class="active">Private</router-link>
            </div>
            <div class="link_filter">
                <router-link to="/">Groups</router-link>
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
    .icons a {
        display: inline-block;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .active_icon {
        box-shadow: 0px 1px 0px 0px rgba(186,186,186,1);
    }
</style>

<script>
    export default {
        mounted() {
            console.log('Left ok!')
        }
    }
</script>
