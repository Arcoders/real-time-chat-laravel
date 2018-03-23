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
        this.pushRealTimeMessage();
        this.UpdateOnlineUsers();
        this.userTyping();
    },

    // ----------------------------------------------

    mounted() {
        this.getInformation();
    },

    // ----------------------------------------------

    methods: {

        // ----------------------------------------------

        pushRealTimeMessage() {
            this.$pusher.subscribe(this.dataType.push).bind('pushMessage', (data) => {

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
            this.$pusher.subscribe(this.dataType.typing).bind('userTyping', (data) => {

                if (this.typing[arrayFindIndex(this.typing, t => t.id === data.id)]) return;

                this.typing.push(data);

                setTimeout(() => {
                    this.typing = this.typing.filter(t => t.id !== data.id);
                }, 15000);

            });
        },

        // ----------------------------------------------

        UpdateOnlineUsers() {
            this.$pusher.subscribe(this.dataType.online).bind('onlineUsers', (data) => {
                if (data.length === 0) return this.onlineUsers = null;
                this.onlineUsers = data;
            });
        },

        // ----------------------------------------------

        GetOnlineUsers() {
            this.$http.get(`/online/connected/${this.chatId}/${this.$route.name}`).then(response => {
                if (response.status !== 200) this.onlineUsers = null;
            }, () => this.onlineUsers = null);
        },

        // ----------------------------------------------

        mouseLeave() {
            this.$http.get(`/online/disconnect/${this.chatId}/${this.$route.name}`).then(this.hover = true);
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

            this.$http.get(`/messages/latest/${this.chatId}/${this.$route.name}`).then(res => {
                if (res.status === 200) {

                    if (res.data.length === 0) return this.welcomeMessage();

                    res.data.forEach(data => {
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

        getInformation() {
            this.$http.get(this.dataType.information).then(res => {

                (res.status === 200) ? this.done(res.data) : this.$router.push('/');

            }, () => this.$router.push('/'));
        },

        // ----------------------------------------------

        done(data) {
            this.chatName = data.name;
            if (data.avatar) this.avatar = data.avatar;

            this.allMessages();
            this.GetOnlineUsers();

            this.showChat = true;
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

        roomId() {
            return (this.$route.params.friend_id) ? parseInt(window.atob(this.$route.params.friend_id)) : this.chatId;
        },

        // ---------------------------------------------------

        dataType() {
            return {
                    push: `${this.$route.name}-${this.chatId}`,
                    typing: `typing-${this.$route.name}-${this.chatId}`,
                    online: `online-${this.$route.name}-${this.chatId}`,
                    information: `/access-box/${this.$route.name}/${this.roomId}`
                };
        },

        // ---------------------------------------------------

    }

};