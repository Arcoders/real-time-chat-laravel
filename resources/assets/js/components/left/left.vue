<template lang="pug">
    #left_app

        .profile

            avatar.avatar(:username='user.name', color='#fff', :src='user.avatar')

            .name(v-if="totalNotifications == 0") {{ user.name }}

            .icons

                router-link(to='/profile')
                    i.material-icons person

                router-link(to='/groups')
                    i.material-icons person_add
                    span.step

                a(v-if="totalNotifications > 0", :data-badge="totalNotifications" v-on:click='showListNotifications').notif
                    i.material-icons notifications

                loading(:normal='true', v-if='loading')

                a(v-else, v-on:click='logout')
                    i(v-bind:class="[logoutError ? 'error' : '', 'material-icons']") fingerprint


        search

        .wrap-filter

            .link_filter
                a(href='#', @click='changeList(true)', v-bind:class='{ active: myChatList }') Private

            .link_filter
                a(href='#', @click='changeList(false)', v-bind:class='{ active: !myChatList }') Groups

        section(v-if="showNotification")
            .contact-list
                allnotifications(v-on:updateNotifications="getTotalNotifications")

        section(v-show="!showNotification")

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
    .notif {
        position: relative;
    }
    .notif[data-badge]:after {
        content: attr(data-badge);
        position:absolute;
        top: 10px;
        right: 5px;
        font-size: 12px;
        background: white;
        color: #009688;
        width: 20px;
        height: 20px;
        text-align: center;
        border-radius: 50%;
        box-shadow: 0 0 1px #fff;
        font-weight: bold;
        line-height: 22px;
    }
</style>

<script>

    export default {

        // ----------------------------------------------

        data() {
            return {
                user: this.$store.state.user,
                logoutError: null,
                loading: false,
                myChatList: true,
                totalNotifications: 0,
                showNotification: false
            }
        },

        // ----------------------------------------------

        created() {

            this.$eventBus.$on('update' , (data) => {
                if (data.type === 'profile') this.user = this.$store.state.user;
            });

            this.$pusher.subscribe(`notification${this.user.id}`).bind('updateNotifications', () => this.getTotalNotifications());

            this.$pusher.subscribe(`user${this.user.id}`).bind('updateStatus', (data) => this.listType(data.type));

            this.$eventBus.$on('update' , (data) => this.listType(data.type));

        },

        // ----------------------------------------------

        mounted() {
            this.getTotalNotifications();
        },

        // ----------------------------------------------

        methods: {

            // ----------------------------------------------

            showListNotifications() {
                this.showNotification = !this.showNotification;
            },

            // ----------------------------------------------

            changeList(value) {
              this.myChatList = value;
              this.showNotification = false;
            },

            // ----------------------------------------------

            listType(type) {
                if (type === 'group') this.myChatList = false;
                if (type === 'chat') this.myChatList = true;
            },

            // ----------------------------------------------

            logout() {
                this.$http.post('/logout').then(response => {

                    this.loading = true;

                    if (response.status === 200) {

                        this.$router.push('/');
                        window.location.reload();

                    } else {
                        this.loading = false;
                        this.logoutError = true;
                    }
                }, () => {
                    this.loading = false;
                    this.logoutError = true;
                });
            },

            // ----------------------------------------------

            getTotalNotifications() {
                this.$http.get('/count_notifications').then(res => {

                    if (res.status === 200) {
                        this.totalNotifications = res.data.total_notifications;
                        this.showNotification = false;
                    }

                });
            }

            // ----------------------------------------------
        }
    }
</script>
