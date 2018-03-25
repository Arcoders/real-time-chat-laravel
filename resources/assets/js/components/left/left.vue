<template lang="pug">
    #left_app

        .menu

            router-link(to='/profile')
                avatar.avatar(:username='user.name', color='#fff', :src='user.avatar')

            router-link(to='/profile') {{ user.name | truncate(15)}}

            .icons

                router-link(to='/groups', @click.native='test')
                    i.material-icons person_add
                    span.step

                a(:data-badge="totalNotifications" v-on:click='showListNotifications').notifications
                    i.material-icons notifications

                a(v-on:click='logout')
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

    import {mapState} from 'vuex';

    export default {

        // ----------------------------------------------

        data() {
            return {
                logoutError: null,
                myChatList: true,
                totalNotifications: 0,
                showNotification: false
            }
        },

        // ----------------------------------------------

        created() {

            this.$eventBus.$on('update' , (data) => {

                if (data.type !== 'profile')  this.listType(data.type);
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

            test() {
                if (window.innerWidth <= 1000) {
                    document.querySelector(".navigate").style.display = "block";
                    document.querySelector(".left").style.display = "none";

                    let right = document.querySelector(".right");
                    right.style.width = "100%";
                    right.style.display = "block";
                }
            },

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
                this.$http.post('/logout').then(res => {

                    (res.status === 200) ? window.location.href = '/' : this.logoutError = true;

                }, () => this.logoutError = true);
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
        },

        // ----------------------------------------------

        computed: mapState({
            user: (state) => state.user
        }),

        // ----------------------------------------------

    }
</script>
