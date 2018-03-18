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
                chatIds: null,
                errorLoad: false
            }
        },

        // ----------------------------------------------

        created() {
            this.updateList();
            this.chatsList();
        },

        // ----------------------------------------------

        methods: {

            // ----------------------------------------------

            updateList() {
                this.$eventBus.$on('update' , (data) => {

                    if (data.filter) {
                        this.groups = data.filtered.groups;
                        this.friends = data.filtered.friends;
                    }

                    if (data.refresh) this.chatsList();
                });
            },

            // ----------------------------------------------

            updatePreview(object, id, message) {

                let chat = arrayFindIndex(object, f => f.id === Number(id));
                if (chat === -1) return;

                let obj = object[chat];
                obj.msg = message;

                object.splice(chat, 1);
                object.splice(object.filter(f => !f.msg).length, 0, obj);
            },

            // ----------------------------------------------

            listEvents() {

                this.$pusher.subscribe('user' + this.user.id).bind('updateStatus', (data) => {
                    if (data.type === 'chat' || data.type === 'group') this.chatsList();
                });

                this.$pusher.subscribe('group_chat').bind('updateList', (data) => {

                    this.updatePreview(this.groups, data.message.group_chat, data.message);

                });

                this.chatIds.forEach(id => {

                    this.$pusher.subscribe(`friend_chat-${id}`).bind('updateList', (data) => {

                        this.updatePreview(this.friends, data.message.friend_chat, data.message);

                    });

                });

            },

            // ----------------------------------------------

            chatsList() {

                this.loading = true;

                this.$http.get('/list/chats').then(res => {

                    this.loading = false;

                    (res.status === 200) ? this.done(res.data) : this.errorLoad = true;

                }, () => {

                    this.loading = false;
                    this.errorLoad = true;

                });
            },

            // ---------------------------------------------------

            done(data) {

                this.groups = data.groups;

                this.$store.commit('updateGroups', arraySort(this.groups, "msg.created_at").reverse());

                this.friends = data.friends.map(u => {
                    return renameKeys(u, key =>  (key === 'friend') ? 'user' : key);
                });

                this.$store.commit('updateFriends', arraySort(this.friends, "msg.created_at").reverse());

                this.chatIds = data.chatIds;

                this.listEvents();
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
