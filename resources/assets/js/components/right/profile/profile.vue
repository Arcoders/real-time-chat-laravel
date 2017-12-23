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

<!--                    <div class="information_content">
                        <h1>Name:</h1>
                        <p class="font-preview">{{ user.name }}</p>
                    </div>

                    <div class="information_content">
                        <h1>Statuses:</h1>
                        <p class="font-preview">Don't you wish there were a knob on the...</p>
                    </div>-->



                    <div class="widget">
                        <div class="cover">
                            <img :src="cover" />
                            <div class="cover_effect"></div>
                        </div>

                        <avatar :username="user.name"
                                color="#fff"
                                :src="avatar"
                                :size="100"
                                class="photo">
                        </avatar>

                        <h1>{{ user.name }}</h1>
                        <h2>FullStack Developer</h2>
                        <h3>Don't you wish there were a knob on the</h3>



                    </div>


                    <div class="manage_users">
                        <router-view @previewImage="updateImage"></router-view>
                    </div>

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

    .complet-content {
        background-color: #ffffff;
    }

    .complete_dynamic_content {
        padding: 0;
    }

</style>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                avatar: this.user.avatar,
                cover: "https://www.hdwallpapers.in/thumbs/2017/plane_mountains-t2.jpg"
            }
        },
        mounted() {
            console.log('Profile ok!');
        },
        methods: {
            updateImage(data) {
                if (data.avatar) this.avatar = data.avatar;
                if (data.cover) this.cover = data.cover;
            }
        }
    }
</script>
