<template lang="pug">
    #private_app

        loading(v-if='loading', :normal='true')

        .contact(v-if='showChatList', v-for='friend in friends')

            router-link(exact-active-class='active_image', :to="chatLink(friend, 'friend')")
                avatar.chat_avatar(:username='friend.name', :src='friend.avatar', color='#fff')

            .contact-preview
                .contact-text
                    h1.font-name
                        router-link(exact-active-class='active_chat', :to="chatLink(friend, 'friend')")
                            | {{ friend.name }}
                    p.font-preview
                        router-link(exact-active-class='active_message', :to="chatLink(friend, 'friend')")
                            | Hola muy buenas

            .contact-time
                p 00:24

        .contact(v-if='!showChatList', v-for='group in groups')

            router-link(exact-active-class='active_image', :to="chatLink(group, 'group')")
                avatar.chat_avatar(:username='group.name', :src='group.avatar', color='#fff')

            .contact-preview
                .contact-text
                    h1.font-name
                        router-link(exact-active-class='active_chat', :to="chatLink(group, 'group')")
                            | {{ group.name }}
                    p.font-preview
                        router-link(exact-active-class='active_message', :to="chatLink(group, 'group')")
                            | Hola muy buenas

            .contact-time
                p 00:24

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
</style>

<script>
    export default {

        // ----------------------------------------------

        props: ['showChatList'],

        // ----------------------------------------------

        data() {
            return {
                loading: false,
                groups: null,
                friends: null,
                notFound: false,
                errorLoad: false
            }
        },

        // ----------------------------------------------

        mounted() {
            this.chatsList();
            console.log('Private ok!')
        },

        // ----------------------------------------------

        methods: {

            // ----------------------------------------------

            chatsList() {

                this.loading = true;

                this.$http.get('/chats_list').then(response => {

                    this.loading = false;

                    if (response.status == 200) {

                        if (response.data.length === 0) this.notFound = true;
                        this.groups = response.data.groups;
                        this.friends = response.data.friends;

                    } else {
                        this.errorLoad = true;
                    }

                }, () => {

                    this.loading = false;
                    this.errorLoad = true;

                });
            },

            // ----------------------------------------------

            // ---------------------------------------------------

            chatLink(chat, type) {
                if (type == 'group') {
                    return {
                        name: type,
                        params: {
                            group_id: window.btoa(chat.id),
                            group_name: chat.name
                        }
                    }
                }
                if (type == 'friend') {
                    return {
                        name: type,
                        params: {
                            friend_id: window.btoa(chat.id),
                            friend_name: chat.name
                        }
                    }
                }
            }

            // ----------------------------------------------

        }

    }
</script>
