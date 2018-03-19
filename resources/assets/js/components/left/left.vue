<template lang="pug">
    #left_app

        .menu

            avatar.avatar(:username='user.name', color='#fff', :src='user.avatar')

            .name {{ user.name | truncate(15)}}

            .icons

                router-link(to='/profile')
                    i.material-icons person

                router-link(to='/groups')
                    i.material-icons person_add
                    span.step

                a(:data-badge="totalNotifications" v-on:click='showListNotifications').notifications
                    i.material-icons notifications

                loading(:normal='true', v-if='loading')

                a(v-else, v-on:click='logout')
                    i(v-bind:class="[logoutError ? 'error' : '', 'material-icons']") fingerprint

        search

        .filter

            button(@click='changeList(true)', v-bind:class='{ active: myChatList }') Private

            button( @click='changeList(false)', v-bind:class='{ active: !myChatList }') Groups

        .contact-list(v-if="showNotification")
                allnotifications(v-on:updateNotifications="getTotalNotifications")

        .contact-list(v-if="!showNotification")
                list(:showChatList='myChatList')

</template>

<style scoped>
    .contact-list {
        height: calc(98vh - 180px);
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

                (data.type === 'profile') ? this.user = this.$store.state.user : this.listType(data.type);
            });

            this.$pusher.subscribe(`notification${this.user.id}`).bind('updateNotifications', () => this.getTotalNotifications());

            this.$pusher.subscribe(`user${this.user.id}`).bind('updateStatus', (data) => this.listType(data.type));

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
                this.$http.get('/notifications/count').then(res => {

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
