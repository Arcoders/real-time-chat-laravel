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
                            span(v-if='group[0]')
                                span(v-if='group[0].body && group[0].photo')
                                    i.material-icons.photo photo
                                    | {{ group[0].body | truncate(35) }}
                                span(v-else-if='group[0].body') {{ group[0].body | truncate(20) }}
                                span(v-else-if='group[0].photo')
                                    i.material-icons.photo photo
                                    | a photo has been shared
                            span(v-else) Empty group...


            .contact-time
                p(v-if='group[0]') {{ group[0].created_at | moment('H:mm') }}
                p(v-else)
                    i.material-icons.time fiber_new

        .contact(v-if='showChatList && groups && groups.length === 0')
                .contact-preview
                    p.middle group not found

        .contact(v-if='!showChatList && friends && friends.length === 0')
            .contact-preview
                p.middle friend not found


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

    const arraySort = require('array-sort');

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

        created() {
            this.$eventBus.$on('update' , (data) => {



                switch (data.action) {

                    case 'filter':
                        this.groups = data.filtered.groups;
                        this.friends = data.filtered.friends;
                        break;

                    case 'up':
                        let group = this.groups.findIndex(g => g.id === data.groupId);
                        if (group < 0) break;

                        let up = this.groups[group];
                        up[0] = data.message;

                        this.groups.splice(group, 1);
                        this.groups.splice(this.groups.filter(g => !g[0]).length, 0, up);
                        break;
                }

                if (data.refresh) this.chatsList();

            });
            this.updateList();
        },

        // ----------------------------------------------

        mounted() {
            this.chatsList();
        },

        // ----------------------------------------------

        methods: {

            // ----------------------------------------------

            updateList() {
                this.channel = this.$pusher.subscribe('room-group');
                this.channel.bind('updateList', (data) => {

                    this.$eventBus.$emit('update', {
                        type: 'group',
                        action: 'up',
                        groupId: parseInt(data.message.group_id),
                        message: data.message
                    });

                });
            },

            // ----------------------------------------------

            chatsList() {

                this.loading = true;

                this.$http.get('/chats_list').then(res => {

                    this.loading = false;

                    if (res.status === 200) {

                        if (res.data.length === 0) this.notFound = true;
                        this.done(res.data.groups, res.data.friends);

                    } else {
                        this.errorLoad = true;
                    }

                }, () => {

                    this.loading = false;
                    this.errorLoad = true;

                });
            },

            // ---------------------------------------------------

            done(groups, friends) {

                this.groups = groups;
                this.friends = friends;
                this.$store.commit('updateGroups', arraySort(this.groups, "0.created_at").reverse());
                this.$store.commit('updateFriends', arraySort(this.friends, "created_at").reverse());
            },

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
