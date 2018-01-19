const arrayFindIndex = require('array-find-index');

export const mixin = {

// ----------------------------------------------

    data() {
        return {
            user: this.$store.state.user,
            chatId: parseInt(window.atob(this.$route.params.chat_id)),
            chatName: null,
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
        this.getData();
        this.pushRealTimeMessage();
        this.UpdateOnlineUsers();
        this.userTyping();
    },

    // ----------------------------------------------

    mounted() {

        this.allMessages();
        this.GetOnlineUsers();
        console.log('Right ok!');
    },

    // ----------------------------------------------

    methods: {

        // ----------------------------------------------

        pushRealTimeMessage() {
            this.channel = this.$pusher.subscribe(this.pushType + this.chatId);
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
            this.$pusher.subscribe(this.typingType + this.chatId).bind('userTyping', (data) => {

                if (this.typing[arrayFindIndex(this.typing, t => t.id === data.id)]) return;

                this.typing.push(data);

                setTimeout(() => {
                    this.typing = this.typing.filter(t => t.id !== data.id);
                }, 15000);

            });
        },

        // ----------------------------------------------

        UpdateOnlineUsers() {
            this.channel = this.$pusher.subscribe(this.onlineType + this.chatId);
            this.channel.bind('onlineUsers', (data) => {
                if (data.length === 0) return this.onlineUsers = null;
                this.onlineUsers = data;
            });
        },

        // ----------------------------------------------

        GetOnlineUsers() {
            this.$http.get(`/get_online_group_users/${this.chatId}/${this.$route.name}`).then(response => {
                if (response.status !== 200) this.onlineUsers = null;
            }, () => this.onlineUsers = null);
        },

        // ----------------------------------------------

        mouseLeave() {
            this.$http.get(`/disconnect_user/${this.chatId}/${this.$route.name}`).then(this.hover = true);
        },

        // ----------------------------------------------

        mouseOut() {
            if (this.hover) {
                this.GetOnlineUsers();
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

            this.$http.get(`/get_latest_messages/${this.chatId}/${this.$route.name}`).then(response => {
                if (response.status === 200) {

                    if (response.data.length === 0) return this.welcomeMessage();

                    response.data.forEach(data => {
                        this.messages.push({
                            id: data.user.id,
                            name: data.user.name,
                            avatar: data.user.avatar,
                            photo: data.photo,
                            text: data.body,
                            time: data.created_at
                        });
                    });

                }
            });

        },

        // ----------------------------------------------

        getData() {
            this.$http.get(this.dataType).then(response => {

                if (response.status === 200) {

                    if (response.data === 0 || !response.data) return this.$router.push('/');

                    this.showChat = true;

                    this.chatName = response.data.name;
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
        },

        // ---------------------------------------------------

        friendIdType() {
            return (this.$route.name === 'friend') ? parseInt(window.atob(this.$route.params.friend_id)) : null
        },

        // ---------------------------------------------------

        pushType() {
            return (this.$route.name === 'group') ? 'group-' : 'friend-';
        },

        // ---------------------------------------------------

        typingType() {
            return (this.$route.name === 'group') ? 'typing-group-' : 'typing-chat-';
        },

        // ---------------------------------------------------

        onlineType() {
            return (this.$route.name === 'group') ? 'onlineGroup-' : 'onlineChat-'
        },

        // ---------------------------------------------------

        dataType() {
            return (this.$route.name === 'group') ? '/get_group_chat/' + this.chatId : '/get_friend_chat/' + this.friendIdType
        }

        // ---------------------------------------------------

    }

};