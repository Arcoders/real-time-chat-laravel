<template lang="pug">
    transition(name='fade')
        #profile_app.right(v-if="showProfile")
            .head

                h1
                    i.material-icons group_add

                .info
                    p Profile
                    p.online {{ userInfo.name }}

                router-link(v-if='pathProfile', to='/profile/edit')
                    i.material-icons edit

                router-link(v-if='pathEdit', to='/profile')
                    i.material-icons arrow_back

            .profile_box
                .content
                    loading(v-if='loading')
                    .information
                        .widget(v-bind:class="{ widget_100: profileId }")
                            .cover
                                img(:src='userInfo.cover')

                                friendship(v-if='user.id != userInfo.id', :my_id='user.id', :profile_user_id='userInfo.id')

                            avatar.photo(:username='userInfo.name', color='#fff', :src='userInfo.avatar', :size='100')

                            h1 {{ userInfo.name }}
                            h2 {{ userInfo.status }}

                        .users(v-if='!profileId')

                            router-view(@previewImage='updateImage', :userInfo='userInfo')

                            div(v-if='pathProfile')
                                .list(v-for='user in users')

                                    avatar.image(:username='user.name', color='#fff', :src='user.avatar', :size='50')

                                    button.name(v-on:click='getProfile(user.id)',
                                                v-bind:class="{ current_user: user.id == userInfo.id }")
                                                | {{user.name}}

                                .list(v-if='!records')

                                    avatar.image(username='!', color='#fff', :size='50', backgroundColor='#E57373')

                                    button.name You are the first user
</template>

<script>
    export default {

        // ---------------------------------------------------

        data() {
            return {
                user: this.$store.state.user,
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
            this.$pusher.subscribe('user' + this.user.id).bind('updateStatus', (data) => {
                this.users = this.users.filter(u => u.id !== Number(data.id));
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
                this.$http.get(`/profile/user/${id}`).then(res => {

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
                this.$http.get('/profile/users').then(response => {

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
