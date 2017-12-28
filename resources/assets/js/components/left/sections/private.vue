<template lang="pug">
    #private_app

        loading(v-if='loading', :normal='true')

        .contact(v-for='chat in chats')

            router-link(exact-active-class='active_image', :to="chatLink(chat, 'group')")
                avatar.chat_avatar(:username='chat.name', :src='chat.avatar', color='#fff')

            .contact-preview
                .contact-text
                    h1.font-name
                        router-link(exact-active-class='active_chat', :to="chatLink(chat, 'group')")
                            | {{ chat.name }}
                    p.font-preview
                        router-link(exact-active-class='active_message', :to="chatLink(chat, 'group')")
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

        data() {
            return {
                loading: false,
                chats: null,
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
                        this.chats = response.data;

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
                return {
                    name: type,
                    params: {
                        group_id: chat.id,
                        group_name: chat.name
                    }
                }
            }

            // ----------------------------------------------

        }

    }
</script>
