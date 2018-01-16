<template lang="pug">
    transition(name='slide-fade')
        #right_app(v-if='showChat', @mouseleave="mouseLeave", @mouseout="mouseOut")

            .chat-head
                avatar.img-head(:username='friendName', color='#fff', :src='avatar')
                .chat-name
                    h1.font-name {{ friendName }}
                    p.font-online(v-if='onlineUsers')
                        span(v-for='onlineUser in onlineUsers')
                            | {{ onlineUser.name }}
                            span.green_font &#8226;
                    p.font-online(v-else) Online
                        span.red_font &#8226;
                i.fa.fa-whatsapp.fa-lg(aria-hidden='true')

            .wrap-content

                .dynamic_content.chat#chat(v-chat-scroll='')
                    messages(:messages='messages', :user='user', :usersTyping="typing")

                .upload_foto(v-if='uploadImage')

                    .container_foto.font-preview(v-if='!photo')
                        label.fileContainer
                            button
                                i.material-icons file_upload
                            input(type='file',
                                        name='foto',
                                        v-on:change='onFileChange($event)',
                                        ref='fileInput')

                    .container_foto(v-else='')
                        .preview-image
                            img(alt='profilepicture', :src='photo')
                            a(v-on:click='photo = null')
                                i.material-icons clear

            send(:user='user',
                    v-on:errorMessages="pushErrorMessage($event)",
                    v-on:clearPhoto="hideModal",
                    :uploadImageState='uploadImage',
                    @showUpload='showImageModal',
                    :photo='photo',
                    :uploadedPhoto='uploadedPhoto')

</template>

<style scoped>
    .dynamic_content {
        height: calc(98vh - 165px);
    }
    .slide-fade-enter-active {
        transition: all .5s ease;
    }
    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(5px);
        opacity: 0;
    }
    .green_font {
        color: #009688;
        margin: 0 7px;
        font-weight: bold;
    }
    .red_font {
        color: #E57373;
        margin: 0 7px;
        font-weight: bold;
    }

</style>

<script>
    export default {

        // ----------------------------------------------

        data() {
            return {
                user: this.$store.state.user,
                chatId: parseInt(window.atob(this.$route.params.chat_id)),
                friendId: parseInt(window.atob(this.$route.params.friend_id)),
                avatar: null,
                showChat: false,
                uploadImage: false,
                photo: null,
                messages: [],
                messages_ready: false,
                latest: null,
                typing: [],
                hover: true,
                onlineUsers: null
            }
        },

        // ----------------------------------------------

        created() {
            this.getFriend();
            //this.pushRealTimeMessage();
            //this.UpdateOnlineUsers();
            //this.userTyping();
        },

        // ----------------------------------------------

        mounted() {

            this.allMessages();
            //this.GetOnlineUsers();
            console.log('Right ok!');
        },

        // ----------------------------------------------

        methods: {


            // ----------------------------------------------

            pushRealTimeMessage() {
                this.channel = this.$pusher.subscribe('room-' + this.groupId);
                this.channel.bind('pushMessage', (data) => {

                    this.typing = this.typing.filter(t => t.id !== data.user.id);

                    if (this.messages[0]['welcome']) this.messages.shift();

                    this.messages.push({
                        id: data.user.id,
                        name: data.user.name,
                        avatar: data.user.avatar,
                        photo: data.message.photo,
                        text: data.message.body,
                        time: data.message.created_at
                    });

                    this.scrollDown('chat');
                });

            },

            // ----------------------------------------------

            pushErrorMessage(data) {
                this.messages.push(data);
                this.scrollDown('chat');
            },

            // ----------------------------------------------

            userTyping() {
                this.$pusher.subscribe('room-' + this.groupId).bind('userTyping', (data) => {

                    if (this.typing[this.typing.findIndex(t => t.id === data.id)]) return;

                    this.typing.push(data);

                    setTimeout(() => {
                        this.typing = this.typing.filter(t => t.id !== data.id);
                    }, 15000);

                });
            },

            // ----------------------------------------------

            UpdateOnlineUsers() {
                this.channel = this.$pusher.subscribe('room-' + this.groupId);
                this.channel.bind('onlineUsers', (data) => {
                    if (data.length === 0) return this.onlineUsers = null;
                    this.onlineUsers = data;
                });
            },

            // ----------------------------------------------

            GetOnlineUsers() {
                this.$http.get('/get_online_group_users/' + this.groupId).then(response => {
                    if (response.status !== 200) this.onlineUsers = null;
                }, () => this.onlineUsers = null);
            },

            // ----------------------------------------------

            mouseLeave() {
                // this.$http.get('/disconnect_user/' + this.groupId).then(this.hover = true);
            },

            // ----------------------------------------------

            mouseOut() {
                if (this.hover) {
                   // this.GetOnlineUsers();
                    this.hover = false;
                }
            },

            // ----------------------------------------------

            showImageModal(data) {
                this.uploadImage = data;
            },

            // ----------------------------------------------

            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;

                let reader = new FileReader();

                reader.onload = (e) => {
                    this.photo = e.target.result;
                    document.getElementById("inputMessage").focus();
                };

                reader.readAsDataURL(files[0]);
            },

            // ----------------------------------------------

            welcomeMessage() {
                this.messages.push({
                        welcome: true,
                        id: this.$store.state.user.id,
                        name: 'h i...',
                        avatar: null,
                        photo: null,
                        text: 'Be the first person to send a message :)',
                        time: new Date()
                    });
            },

            // ----------------------------------------------

            allMessages() {

                console.log(this.chatId);

                this.$http.get(`/get_latest_messages/${this.chatId}/${this.$route.name}`).then(response => {
                    if (response.status === 200) {

                        if (response.data.length === 0) return this.welcomeMessage();

                        for (let i = 0; i < response.data.length; i++) {
                            this.messages.push({
                                id: response.data[i].user.id,
                                name: response.data[i].user.name,
                                avatar: response.data[i].user.avatar,
                                photo: response.data[i].photo,
                                text: response.data[i].body,
                                time: response.data[i].created_at
                            });
                        }

                    } else {
                        // ...
                    }
                }, () => {
                    // ...
                });

            },

            // ----------------------------------------------

            getFriend() {
                this.$http.get('/get_friend_chat/' + this.friendId).then(response => {

                    if (response.status === 200) {

                        if (response.data === 0 || !response.data) return this.$router.push('/');

                        this.showChat = true;

                        this.friendName = response.data.name;
                        if (response.data.avatar) this.avatar = response.data.avatar;

                    } else {
                        this.$router.push('/');
                    }

                }, () => {
                    this.$router.push('/');
                });
            },

            // ----------------------------------------------

            hideModal() {
                this.photo = null;
                this.uploadImage = false
            },

            // ----------------------------------------------

            scrollDown(id) {
                window.setTimeout( () => {
                    let elem = window.document.getElementById(id);
                    elem.scrollTop = elem.scrollHeight;
                }, 500);
            }

            // ----------------------------------------------

        },
        computed: {

            // ---------------------------------------------------

            uploadedPhoto() {
                if (this.photo) return this.$refs.fileInput.files[0];
            }

            // ---------------------------------------------------

        }
    }
</script>
