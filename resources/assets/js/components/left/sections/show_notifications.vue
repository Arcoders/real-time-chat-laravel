<template lang="pug">
    .notifications

        button.mark(@click="markAsRead") Mark all as read

        loading(v-if='loading', :normal='true')

        .contact(v-for='notification in notifications', v-bind:class='{ new_notification: notification.read == null }')

            router-link(:to="{ name: 'profile', params: { profile_id: notification.info.user.id }}")
                avatar.avatar(:username='notification.info.user.name', :src='notification.info.user.avatar', color='#fff')

            .preview
                .text
                    h5
                        router-link(exact-active-class='green_teal', :to="{ name: 'profile', params: { profile_id: notification.info.user.id }}")
                            | {{ notification.info.user.name }}
                    h6   {{ notification.info.msg}}

            .time
                p {{ notification.data.date | moment('H:mm') }}


</template>

<script>

    export default {

        // ----------------------------------------------

        data() {
            return {
                loading: false,
                notifications: null
            }
        },

        // ----------------------------------------------

        mounted() {
            this.getTotalNotifications();
        },

        // ----------------------------------------------

        methods: {

            // ----------------------------------------------

            getTotalNotifications() {

                this.loading = true;

                this.$http.get('/notifications/show').then(res => {

                    if (res.status === 200) this.notifications = res.data;
                    this.loading = false;

                });
            },

            // ----------------------------------------------

            markAsRead() {
                this.loading = true;

                this.$http.get('/notifications/mark_as_read').then(res => {

                    if (res.status === 200) this.$emit('updateNotifications', []);

                    this.loading = false;

                });
            }

            // ----------------------------------------------

        },

    }
</script>
