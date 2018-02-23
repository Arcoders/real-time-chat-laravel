<template lang="pug">
    #private_app

        loading(v-if='loading', :normal='true')

        .contact(v-for='notification in notifications')

            a
                avatar.chat_avatar(:username='notification.info.user.name', :src='notification.info.user.avatar', color='#fff')

            .contact-preview
                .contact-text
                    h1.font-name
                        a {{ notification.info.user.name }}
                    p.font-preview
                        a {{ notification.info.msg}}

            .contact-time
                p {{ notification.data.date | moment('H:mm') }}

        .contact(v-for='notification in notifications')

            a
                avatar.chat_avatar(:username='notification.info.user.name', :src='notification.info.user.avatar', color='#fff')

            .contact-preview
                .contact-text
                    h1.font-name
                        a {{ notification.info.user.name }}
                    p.font-preview
                        a {{ notification.info.msg}}

            .contact-time
                p {{ notification.data.date | moment('H:mm') }}

        .contact(v-for='notification in notifications')

            a
                avatar.chat_avatar(:username='notification.info.user.name', :src='notification.info.user.avatar', color='#fff')

            .contact-preview
                .contact-text
                    h1.font-name
                        a {{ notification.info.user.name }}
                    p.font-preview
                        a {{ notification.info.msg}}

            .contact-time
                p {{ notification.data.date | moment('H:mm') }}

        .contact(v-for='notification in notifications')

            a
                avatar.chat_avatar(:username='notification.info.user.name', :src='notification.info.user.avatar', color='#fff')

            .contact-preview
                .contact-text
                    h1.font-name
                        a {{ notification.info.user.name }}
                    p.font-preview
                        a {{ notification.info.msg}}

            .contact-time
                p {{ notification.data.date | moment('H:mm') }}

</template>

<style scoped>
    a {
        text-decoration: none;
        color: #2a2a2a;
    }
    .active_chat {
        color: #009688;
        padding-left: 15px;
    }
    .active_message {
        padding-left: 15px;
        color: #444444;
    }
    .active_image {
        box-shadow: 6px 0px 16px -13px rgba(119,119,119,1);
    }
    .chat_avatar {
        width: 50px;
        height: 50px;
        min-width: 50px;
        min-height: 50px;
        margin: 12px 20px;
        border-radius: 50%;
    }
    .photo {
        margin-right: 5px;
        color: #eeeeee;
        font-size: 15px;
    }
    .time {
        margin-left: 5px;
        color: #009688;
        font-size: 25px;
    }

    .middle {
        margin: auto;
        color: #aaaaaa;
    }
</style>

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

                this.$http.get('/show_notifications').then(res => {

                    if (res.status === 200) this.notifications = res.data;
                    this.loading = false;

                });
            }

            // ----------------------------------------------

        },

    }
</script>
