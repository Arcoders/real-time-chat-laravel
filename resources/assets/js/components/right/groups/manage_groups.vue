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

                    <div class="groups">
                        <div class="group">
                            <router-link to="groups/add" exact-active-class="active">Add groups</router-link>
                        </div>
                        <div class="group">
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
    .groups {
        width: 100%;
        background: #f1f1f1;
        display: flex;
    }

    .group {
        width: 50%;
        height: calc(98vh - 125px);
    }

    .group a{
        width: 100%;
        height: 100%;
        color: #777777;
        font-size: 0.9em;
        font-weight: bold;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .group a:hover{
        color: #009688;
        background-color: #f3f3f3;
    }
</style>

<script>
    export default {
        mounted() {
            console.log('Groups ok!')
        }
    }
</script>
