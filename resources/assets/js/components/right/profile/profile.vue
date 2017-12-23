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
                            <img src="https://www.hdwallpapers.in/thumbs/2017/autumn_path_4k-t2.jpg" />
                        </div>
                        <avatar :username="user.name"
                                color="#fff"
                                :src="avatar"
                                :size="100"
                                class="photo">
                        </avatar>
                        <h1>Ryan Boylett</h1>
                        <h2>Web Developer</h2>
                        <h3>Bristol, UK</h3>

                        <router-view @previewImage="updateImage"></router-view>

                    </div>


                    <div class="list_users">
                        abc
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
        padding: 2px;
    }

    .widget
    {
        position: relative;
        background: #f2dede;
        width: 80%;
        height: 100%;
    }

    .cover
    {
        height: 300px;
        width: 100%;
    }

    .cover  img {
        width: 100%;
        height: 100%;
    }

    .widget > .photo
    {
        position: absolute;
        top: 225px;
        left: 50%;
        width: 100px;
        height: 100px;
        margin: 0 0 0 -55px;
        border: 5px solid #FFF;
        border-radius: 50%;
    }

    .widget > h1, .widget > h2, .widget > h3
    {
        display: block;
        margin: 10px 0;
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        font-weight: 300;
        color: #999;
    }

    .widget > h1
    {
        margin: 60px 0 20px;
        font-size: 26px;
        color: #000;
    }

    .widget > h3 { font-size: 12px }





    .list_users {
        background-color: #f0ad4e;
        width: 20%;
        height: 100%;
        min-height: 100%;
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
