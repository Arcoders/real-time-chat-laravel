<template>
    <div class="right" id="profile_app">

        <div class="chat-head">
            <i class="material-icons big_icon">person</i>
            <div class="chat-name">
                <h1 class="font-name">Profile</h1>
                <p class="font-online">{{ userName }}...</p>
            </div>

            <router-link v-if="pathEdit" to="/profile/edit">
                <i class="material-icons">edit</i>
            </router-link>

            <router-link v-else to="/profile">
                <i class="material-icons">arrow_back</i>
            </router-link>

        </div>

        <div class="complet-content">
            <div class="complete_dynamic_content">

                <div class="information">

                    <div class="widget">
                        <div class="cover">
                            <img :src="cover" />
                            <div class="add_friend style_friend">
                                <button>
                                    <!--<i class="material-icons">person_add</i>-->
                                    <!--<i class="material-icons">people</i>-->
                                    <!--<i class="material-icons">sentiment_very_dissatisfied</i>-->
                                    <!--<i class="material-icons">done_all</i>-->
                                    <!--<i class="material-icons">access_time</i>-->
                                    <i class="material-icons">done_all</i>
                                </button>
                            </div>
                            <div class="delete_friend style_friend">
                                <button>
                                    <i class="material-icons">clear</i>
                                </button>
                            </div>
                        </div>

                        <avatar :username="userName"
                                color="#fff"
                                :src="avatar"
                                :size="100"
                                class="photo">
                        </avatar>

                        <h1>{{ userName }}</h1>
                        <h2>FullStack Developer</h2>
                        <h3>{{ userStatus }}</h3>


                    </div>


                    <div class="manage_users">

                        <router-view :user="user" @previewImage="updateImage" @modelInfo="updateInfo"></router-view>

                        <div v-if="pathEdit" class="contener_txt" v-for="user in users">
                            <avatar :username="user.name"
                                    color="#fff"
                                    :src="user.avatar"
                                    :size="50"
                                    class="img-head">
                            </avatar>
                            <div class="name">
                                <button v-on:click="getProfile(user.id)">
                                    {{user.name}}
                                </button>
                            </div>
                        </div>

                        <div v-if="!records && pathEdit" class="contener_txt">
                            <avatar username="!"
                                    color="#fff"
                                    :size="50"
                                    backgroundColor="#E57373"
                                    class="img-head">
                            </avatar>
                            <div class="name">
                                <button>
                                    You are the first user
                                </button>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
</template>

<style scoped>

    .complete_dynamic_content {
        padding: 0;
    }

    .big_icon {
        margin: 10px 20px;
        border-radius: 50%;
        font-size: 40px;
        color: #777777;
    }

    .contener_txt
    {
        width: 100%;
        height: auto;
        background-color:#fbfbfb;
        box-shadow:1px 1px 2px #777777;
        display: flex;
        text-align: left;
    }

    .name > button {
        color: #777777;
        font-size: 14px;
    }

</style>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                users: [],
                records: true,
                userName: this.user.name,
                userStatus: this.user.status,
                avatar: this.user.avatar,
                cover: this.checkCover(this.user.cover)
            }
        },
        mounted() {
            this.getUsers();
            console.log('Profile ok!');
        },
        methods: {

            // ---------------------------------------------------

            updateImage(data) {
                if (data.avatar) this.avatar = data.avatar;
                if (data.cover) this.cover = data.cover;
            },

            // ---------------------------------------------------

            updateInfo(data) {
                if (data.user) this.userName = data.user;
                if (data.status) this.userStatus = data.status;
            },

            // ---------------------------------------------------

            getProfile(id) {
                this.$http.get('/get_profile/' + id).then(response => {

                    if (response.status == 200) {

                        if (response.data == 0) return this.$router.push('/profile');

                        this.userName = response.data.name;
                        this.userStatus = response.data.status;
                        this.avatar = response.data.avatar;
                        this.cover = this.checkCover(response.data.cover);

                    } else {
                        this.$router.push('/profile');
                    }

                }, () => {
                    this.$router.push('/profile');
                });
            },

            // ---------------------------------------------------

            getUsers() {
                this.$http.get('/get_users/').then(response => {

                    if (response.status == 200) {

                        if (response.data.length == 0) this.records = false;

                        this.users = response.data;

                    } else {
                        // error
                    }

                }, () => {
                    // error
                });
            },

            // ---------------------------------------------------

            checkCover(cover) {
                return (cover) ? cover : '/images/default/default_cover.jpg';
            }

            // ---------------------------------------------------


        },
        computed: {

            // ---------------------------------------------------

            pathEdit() {
                return (this.$route.path == '/profile');
            },

            // ---------------------------------------------------
        }
    }
</script>
