<template>
    <div class="right" id="profile_app">

        <div class="chat-head">
            <avatar :username="user.name"
                    color="#fff"
                    :src="avatar"
                    class="img-head">
            </avatar>
            <div class="chat-name">
                <h1 class="font-name">Profile</h1>
                <p class="font-online">{{ user.name }}...</p>
            </div>

            <router-link v-if="$route.path == '/profile'" to="/profile/edit">
                <i class="material-icons">edit</i>
            </router-link>

            <router-link v-if="$route.path == '/profile/edit'" to="/profile">
                <i class="material-icons">arrow_back</i>
            </router-link>
        </div>

        <div class="complet-content">
            <div class="complete_dynamic_content">

                <div class="information">

                    <div class="information_content">
                        <h1>Name:</h1>
                        <p class="font-preview">{{ user.name }}</p>
                    </div>

                    <div class="information_content">
                        <h1>Statuses:</h1>
                        <p class="font-preview">Don't you wish there were a knob on the...</p>
                    </div>

                    <div class="information_content">
                        <h1>Statuses:</h1>
                        <p class="font-preview">Don't you wish there were a knob on the...</p>
                    </div>

                    <div class="information_content">
                        <h1>Statuses:</h1>
                        <p class="font-preview">Don't you wish there were a knob on the...</p>
                    </div>

                    <div class="information_content">
                        <h1>Statuses:</h1>
                        <p class="font-preview">Don't you wish there were a knob on the...</p>
                    </div>

                    <div class="information_content">
                        <h1>Statuses:</h1>
                        <p class="font-preview">Don't you wish there were a knob on the...</p>
                    </div>

                    <router-view @previewImage="updateImage"></router-view>

                </div>

            </div>
        </div>

    </div>
</template>

<style scoped>
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
        props: ['user'],
        data() {
            return {
                avatar: this.user.avatar
            }
        },
        mounted() {
            console.log('Profile ok!');
        },
        methods: {
            updateImage(data) {
                this.avatar = data;
            }
        }
    }
</script>
