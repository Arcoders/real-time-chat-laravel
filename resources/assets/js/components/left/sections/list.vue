<template lang="pug">
    #private_app

        loading(v-if='loading', :normal='true')

        .contact(v-if='showChatList', v-for='friend in friends')

            router-link(exact-active-class='active_image', :to="chatLink(friend, 'friend')")
                avatar.chat_avatar(:username='friend.user.name', :src='friend.user.avatar', color='#fff')

            .contact-preview
                .contact-text
                    h1.font-name
                        router-link(exact-active-class='active_chat', :to="chatLink(friend, 'friend')")
                            | {{ friend.user.name }}
                    p.font-preview
                        router-link(exact-active-class='active_message', :to="chatLink(friend, 'friend')")
                            span(v-if="friend.msg")
                                span(v-if="friend.msg.body && friend.msg.photo")
                                    i.material-icons.photo photo
                                    | {{ friend.msg.body | truncate(35) }}
                                span(v-else-if="friend.msg.body") {{ friend.msg.body | truncate(20) }}
                                span(v-else-if="friend.msg.photo")
                                    i.material-icons.photo photo
                                    | a photo has been shared
                            span(v-else) Empty chat...

            .contact-time
                p(v-if="friend.msg") {{ friend.msg.created_at | moment('H:mm') }}
                p(v-else)
                    i.material-icons.time fiber_new

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
                            span(v-if='group.msg')
                                span(v-if='group.msg.body && group.msg.photo')
                                    i.material-icons.photo photo
                                    | {{ group.msg.body | truncate(35) }}
                                span(v-else-if='group.msg.body') {{ group.msg.body | truncate(20) }}
                                span(v-else-if='group.msg.photo')
                                    i.material-icons.photo photo
                                    | a photo has been shared
                            span(v-else) Empty group...


            .contact-time
                p(v-if='group.msg') {{ group.msg.created_at | moment('H:mm') }}
                p(v-else)
                    i.material-icons.time fiber_new

        .contact(v-if='notFoundGroups')
                .contact-preview
                    p.middle group not found

        .contact(v-if='notFoundFriends')
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
    const renameKeys = require('rename-keys');
    const arrayFindIndex = require('array-find-index');

    export default {

        // ----------------------------------------------

        props: ['showChatList'],

        // ----------------------------------------------

        data() {
            return {
                loading: false,
                groups: this.$store.state.groups,
                friends: this.$store.state.friends,
                user: this.$store.state.user,
                chatIds: [],
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
                        this.updatePreview(this.groups, data.groupId, data.message);
                        break;

                    case 'up-chat':
                        this.updatePreview(this.friends, data.chatId, data.message);
                        break;
                }

                if (data.refresh) this.chatsList();
            });

            this.chatsList();
        },

        // ----------------------------------------------

        methods: {

            // ----------------------------------------------

            updatePreview(object, id, message) {
                let chat = arrayFindIndex(object, f => f.id === id);

                if (chat === -1) return;

                let up = object[chat];
                up.msg = message;

                object.splice(chat, 1);
                object.splice(object.filter(f => !f.msg).length, 0, up);
            },

            // ----------------------------------------------

            updateList() {

                this.$pusher.subscribe('user' + this.user.id).bind('updateStatus', () => {
                    this.$eventBus.$emit('update', {refresh: true});
                });

                this.$pusher.subscribe('group_chat').bind('updateList', (data) => {

                    this.$eventBus.$emit('update', {
                        type: 'group',
                        action: 'up',
                        groupId: parseInt(data.message.group_chat),
                        message: data.message
                    });

                });

                this.chatIds.forEach(id => {

                    this.$pusher.subscribe(`friend_chat-${id}`).bind('updateList', (data) => {

                        this.$eventBus.$emit('update', {
                            type: 'friend',
                            action: 'up-chat',
                            chatId: parseInt(data.message.friend_chat),
                            message: data.message
                        });

                    });

                });

            },

            // ----------------------------------------------

            chatsList() {

                this.loading = true;

                this.$http.get('/list/chats').then(res => {

                    this.loading = false;

                    if (res.status === 200) {

                        if (res.data.length === 0) this.notFound = true;
                        this.done(res.data.groups, res.data.friends);
                        this.chatIds = res.data.chatIds;
                        this.updateList();

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

                this.$store.commit('updateGroups', arraySort(this.groups, "msg.created_at").reverse());

                this.friends = friends.map(u => {
                    return renameKeys(u, key =>  (key === 'friend') ? 'user' : key);
                });

                this.$store.commit('updateFriends', arraySort(this.friends, "msg.created_at").reverse());

            },

            // ---------------------------------------------------

            chatLink(chat, type) {
                if (type === 'group') {
                    return {
                        name: 'group_chat',
                        params: {
                            chat_id: window.btoa(chat.id),
                            group_name: chat.name
                        }
                    }
                }
                if (type === 'friend') {
                    return {
                        name: 'friend_chat',
                        params: {
                            chat_id: window.btoa(chat.id),
                            friend_id: window.btoa(chat.user.id),
                            friend_name: chat.user.name
                        }
                    }
                }
            }

            // ----------------------------------------------

        },

        computed: {
            // ----------------------------------------------

            notFoundGroups() {
                return (!this.showChatList && this.groups && this.groups.length === 0);
            },

            // ----------------------------------------------

            notFoundFriends() {
                return (this.showChatList && this.friends && this.friends.length === 0);
            }

            // ----------------------------------------------
        }

    }
</script>
