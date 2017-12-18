<template>
    <div id="left_app">

        <div class="profile">
            <avatar :username="user.name"
                    color="#fff"
                    :src="user.avatar"
                    class="avatar">
            </avatar>
            <span>{{ user.name }}</span>
            <div class="icons">

                <router-link to="/profile">
                    <i class="material-icons">person</i>
                </router-link>

                <router-link to="/groups">
                    <i class="material-icons">person_add</i>
                </router-link>

            </div>
        </div>

        <search></search>

        <div class="wrap-filter">
            <div class="link_filter">
                <router-link to="/">Private</router-link>
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
    .router-link-active {
        box-shadow: 0px 1px 0px 0px rgba(186,186,186,1);
    }
    span {
        margin: auto;
        color: #777777;
    }
    .avatar {
        margin: 5px 20px;
    }
</style>

<script>
    export default {
        props: ['user'],
        mounted() {
            console.log('Left ok!');
        }
    }
</script>
