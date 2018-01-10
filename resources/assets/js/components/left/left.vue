<template lang="pug">
    #left_app

        .profile(v-if='showUser')

            avatar.avatar(:username='user.name', color='#fff', :src='user.avatar')

            .name {{ user.name }}

            .icons

                router-link(to='/profile')
                    i.material-icons person

                router-link(to='/groups')
                    i.material-icons person_add

                loading(:normal='true', v-if='loading')

                a(v-else, v-on:click='logout')
                    i(v-bind:class="[logoutError ? 'error' : '', 'material-icons']") fingerprint

        search

        .wrap-filter

            .link_filter
                a(href='#', @click='changeList(true)', v-bind:class='{ active: myChatList }') Private

            .link_filter
                a(href='#', @click='changeList(false)', v-bind:class='{ active: !myChatList }') Groups

        .contact-list
            list(:showChatList='myChatList')

</template>

<style scoped>
    .contact-list {
        height: calc(98vh - 180px);
    }
    .icons a {
        display: inline-block;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .router-link-active {
        box-shadow: 0px 1px 0px 0px rgba(186,186,186,1);
    }
    .avatar {
        margin: 5px 20px;
    }
    .error {
        color: #E57373;
    }
</style>

<script>

    export default {

        // ----------------------------------------------

        props: ['auth_user'],

        // ----------------------------------------------

        data() {
            return {
                showUser: false,
                user: null,
                logoutError: null,
                loading: false,
                myChatList: true
            }
        },

        // ----------------------------------------------

        created() {
            this.$eventBus.$on('update' , () => {
                this.user = this.$store.state.user;
            });
        },

        // ----------------------------------------------

        mounted() {
            this.userInfo();
        },

        // ----------------------------------------------

        methods: {

            // ----------------------------------------------

            userInfo() {
                this.$store.commit('updateUser', this.auth_user);
                this.user = this.$store.state.user;
                this.showUser = true;
            },

            // ----------------------------------------------

            changeList(value) {
              this.myChatList = value;
            },

            // ----------------------------------------------

            logout() {
                this.$http.post('/logout').then(response => {

                    this.loading = true;

                    if (response.status == 200) {

                        setTimeout(()=>{
                            this.$router.push('/');
                            window.location.reload();
                        }, 2000);

                    } else {
                        this.loading = false;
                        this.logoutError = true;
                    }
                }, () => {
                    this.loading = false;
                    this.logoutError = true;
                });
            }

            // ----------------------------------------------
        }
    }
</script>
