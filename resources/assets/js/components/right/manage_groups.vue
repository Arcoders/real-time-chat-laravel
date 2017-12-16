<template>
    <div id="manage_groups_app">

        <div class="chat-head">
            <i class="material-icons big_icon">group_add</i>
            <div class="chat-name">
                <h1 class="font-name">Groups</h1>
                <p class="font-online">You can create public chat rooms for all users...</p>
            </div>
            <i class="fa fa-whatsapp fa-lg" aria-hidden="true"></i>
        </div>

        <div class="wrap-content">
            <div class="dynamic_content">

                <div v-if="$route.path == '/groups'">

                    <div class="wrap-filter">
                        <div class="link_filter">
                            <router-link to="groups/all" exact-active-class="active">All groups</router-link>
                        </div>
                        <div class="link_filter">
                            <router-link to="groups/my">My groups</router-link>
                        </div>
                    </div>

                </div>

                <router-view></router-view>

            </div>
        </div>

    </div>
</template>

<style scoped>
    #manage_groups_app {
        background-color: #ffffff;
        border-radius: 2px;
        height: calc(98vh - 25px);
    }
    .big_icon {
        margin: 10px 20px;
        border-radius: 50%;
        font-size: 40px;
        color: #777777;
    }
    .dynamic_content {
        padding: 20px;
        background-color: #ffffff;
        height: calc(98vh - 125px);
    }
</style>

<script>
    export default {
        mounted() {
            console.log('Right ok!')
        }
    }
</script>
