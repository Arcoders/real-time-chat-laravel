<template lang="pug">
    #profile_app.right
        .chat-head

            i.material-icons.big_icon person

            .chat-name
                h1.font-name Profile
                p.font-online {{ userName }}...

            router-link(v-if='pathEdit', to='/profile/edit')
                i.material-icons edit

            router-link(v-else, to='/profile')
                i.material-icons arrow_back

        .complet-content
            .complete_dynamic_content
                .information
                    .widget(v-bind:class="{ widget_100: profileId }")
                        .cover
                            img(:src='cover')

                            friendship(v-if='user.id != userId',
                                        :my_id='user.id',
                                        :profile_user_id='userId')

                        avatar.photo(:username='userName',
                                        color='#fff',
                                        :src='avatar',
                                        :size='100')

                        h1 {{ userName }}
                        h2 FullStack Developer
                        h3 {{ userStatus }}
                        h3 {{ userId }}

                    .manage_users(v-if='!profileId')

                        router-view(:user='user', @previewImage='updateImage', @modelInfo='updateInfo')

                        .contener_txt(v-if='pathEdit', v-for='user in users')

                            avatar.img-head(:username='user.name',
                                            color='#fff',
                                            :src='user.avatar',
                                            :size='50')

                            .name
                                button(v-on:click='getProfile(user.id)')
                                    | {{user.name}}

                        .contener_txt(v-if='!records && pathEdit')

                            avatar.img-head(username='!',
                                            color='#fff',
                                            :size='50',
                                            backgroundColor='#E57373')
                            .name
                                button You are the first user
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
        background-color:#ffffff;
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

        // ---------------------------------------------------

        props: ['user'],

        // ---------------------------------------------------

        data() {
            return {
                users: [],
                records: true,
                userName: this.user.name,
                userStatus: this.user.status,
                userId: this.user.id,
                profileId: this.$route.params.profile_id,
                avatar: this.user.avatar,
                cover: this.checkCover(this.user.cover)
            }
        },

        // ---------------------------------------------------

        mounted() {
            this.profileByParameter();
            console.log('Profile ok!');
        },

        // ---------------------------------------------------

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

                        this.userId = response.data.id;
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
            },

            // ---------------------------------------------------

            profileByParameter() {
                if (this.profileId) return this.getProfile(this.profileId);
                this.getUsers();
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
