<template>
    <div id="profile_app">

        <div class="chat-head">
            <img alt="profilepicture" src="https://avatars.io/twitter/nada">
            <div class="chat-name">
                <h1 class="font-name">Profile</h1>
                <p class="font-online">Ismael Haytam...</p>
            </div>

            <router-link v-if="$route.path == '/profile'" to="/profile/edit">
                <i class="material-icons">edit</i>
            </router-link>

            <router-link v-if="$route.path == '/profile/edit'" to="/profile">
                <i class="material-icons">arrow_back</i>
            </router-link>
        </div>

        <div class="wrap-content">
            <div class="dynamic_content">

                <div class="information">
                    <div class="information_content">
                        <h1>Name:</h1>
                        <p class="font-preview">Ismael Haytam</p>
                    </div>

                    <div class="information_content">
                        <h1>Statuses:</h1>
                        <p class="font-preview">Don't you wish there were a knob on the...</p>
                    </div>

                    <router-view></router-view>

                </div>

            </div>
        </div>

    </div>
</template>

<style scoped>
    #profile_app {
        background-color: #ffffff;
        border-radius: 2px;
        height: calc(98vh - 25px);
    }
    .dynamic_content {
        padding: 0px;
        background-color: #ffffff;
        height: calc(98vh - 85px);
    }
    a i {
        cursor: pointer;
        text-decoration: none;
    }

    a i:hover {
        color: #009688;
    }

    i_green {
        color: #009688;
    }
</style>

<script>
    export default {
        mounted() {
            console.log('Profile ok!')
        }
    }
</script>
