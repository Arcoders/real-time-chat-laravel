<template lang="pug">
    transition(name='fade')
        #profile_app.right(v-if="showProfile")
            .chat-head

                i.material-icons.big_icon person

                .chat-name
                    h1.font-name Profile
                    p.font-online {{ userInfo.name }}

                router-link(v-if='pathProfile', to='/profile/edit')
                    i.material-icons edit

                router-link(v-if='pathEdit', to='/profile')
                    i.material-icons arrow_back

            .complet-content
                .complete_dynamic_content
                    loading(v-if='loading')
                    .information
                        .widget(v-bind:class="{ widget_100: profileId }")
                            .cover
                                img(:src='userInfo.cover')

                                friendship(v-if='user.id != userInfo.id',
                                            :my_id='user.id',
                                            :profile_user_id='userInfo.id')

                            avatar.photo(:username='userInfo.name',
                                            color='#fff',
                                            :src='userInfo.avatar',
                                            :size='100')

                            h1 {{ userInfo.name }}
                            h2 {{ userInfo.status }}

                        .manage_users(v-if='!profileId')

                            router-view(@previewImage='updateImage', :userInfo='userInfo')

                            div(v-if='pathProfile')
                                .contener_txt(v-for='user in users')

                                    avatar.img-head(:username='user.name',
                                    color='#fff',
                                    :src='user.avatar',
                                    :size='50')

                                    .name
                                        button(v-on:click='getProfile(user.id)')
                                            | {{user.name}}

                                .contener_txt(v-if='!records')

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

    .fade-enter-active, .fade-leave-active {
        transition: opacity 1s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }

</style>

<script>
    export default {

        // ---------------------------------------------------

        data() {
            return {
                user: null,
                showProfile: false,
                users: [],
                records: true,
                userInfo: {},
                profileId: this.$route.params.profile_id,
                loading: false
            }
        },

        // ---------------------------------------------------

        created() {
            this.$eventBus.$on('update' , (data) => {

                if (data.profileId) this.users = this.users.filter(u => u.id !== data.profileId);

            });
        },

        // ---------------------------------------------------

        mounted() {
            this.profileByParameter();
        },

        // ---------------------------------------------------

        methods: {

            // ---------------------------------------------------

            setUserInfo() {
                this.user = this.$store.state.user;

                if (this.profileId) return;

                this.userInfo = {
                    name: this.user.name,
                    status: this.user.status,
                    id: this.user.id,
                    avatar: this.user.avatar,
                    cover: this.checkCover(this.user.cover),
                };

                if (this.userInfo) this.showProfile = true;
            },

            // ---------------------------------------------------

            updateImage(data) {
                if (data.avatar) this.userInfo.avatar = data.avatar;
                if (data.cover) this.userInfo.cover = data.cover;
            },

            // ---------------------------------------------------

            getProfile(id) {
                this.loading = true;
                this.$http.get('/get_profile/' + id).then(res => {

                    if (res.status === 200) {
                        
                        this.userInfo = {
                            name: res.data.name,
                            status: res.data.status,
                            id: res.data.id,
                            avatar: res.data.avatar,
                            cover: this.checkCover(res.data.cover),
                        };

                        this.showProfile = true;

                    } else {
                        this.$router.push('/profile');
                    }

                    this.loading = false;

                }, () => {
                    this.loading = false;
                    this.$router.push('/profile');
                });
            },

            // ---------------------------------------------------

            getUsers() {
                this.$http.get('/get_users/').then(response => {

                    if (response.status === 200) {
                        if (response.data.length === 0) this.records = false;
                        this.users = response.data;
                    }

                });
            },

            // ---------------------------------------------------

            checkCover(cover) {
                return (cover) ? cover : '/images/default/default_cover.jpg';
            },

            // ---------------------------------------------------

            profileByParameter() {

                this.setUserInfo();

                if (this.profileId) {

                    if (!isNaN(this.profileId)) return this.getProfile(this.profileId);
                    this.$router.push('/profile');

                } else {
                    this.getUsers();
                }

            }

            // ---------------------------------------------------


        },
        computed: {

            // ---------------------------------------------------

            pathProfile() {
                return (this.$route.name === 'profile');
            },

            // ---------------------------------------------------

            pathEdit() {
                return (this.$route.name === 'edit_profile');
            },

            // ---------------------------------------------------
        }
    }
</script>
