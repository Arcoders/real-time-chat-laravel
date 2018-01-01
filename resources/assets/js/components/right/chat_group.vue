<template lang="pug">
    transition(name='slide-fade')
        #right_app(v-if='showChat')

            .chat-head
                avatar.img-head(:username='groupName', color='#fff', :src='avatar')
                .chat-name
                    h1.font-name {{ groupName }}
                    p.font-online Ismael, Fatima, Admin, Marta, victor... {{ groupId }}
                i.fa.fa-whatsapp.fa-lg(aria-hidden='true')

            .wrap-content

                .dynamic_content.chat
                    messages(:messages='messages', :user='user', :usersTyping="typing")

                .upload_foto(v-if='uploadImage')

                    .container_foto.font-preview(v-if='!photo')
                        label.fileContainer
                            button
                                i.material-icons file_upload
                            input(type='file',
                                        name='fileInput',
                                        v-on:change='onFileChange($event)',
                                        ref='fileInput')

                    .container_foto(v-else='')
                        .preview-image
                            img(alt='profilepicture', :src='photo')
                            a(v-on:click='clearImage')
                                i.material-icons clear

            send(:user='user',
                    v-on:errorMessages="pushErrorMessage($event)",
                    :uploadImageState='uploadImage',
                    @showUpload='showImageModal',
                    :photo='photo',
                    @pushMessage='addMessage')

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
</style>

<script>
    export default {

        // ----------------------------------------------

        props: ['user'],

        // ----------------------------------------------

        data() {
            return {
                groupId: window.atob(this.$route.params.group_id),
                avatar: null,
                showChat: false,
                uploadImage: false,
                photo: null,
                messages: [],
                messages_ready: false,
                latest: null,
                typing: []
            }
        },

        // ----------------------------------------------

        created() {
            this.getGroup();
            this.pushRealTimeMessage();
            this.userTyping();
        },

        // ----------------------------------------------

        mounted() {
            this.allMessages();
            console.log('Right ok!');
        },

        // ----------------------------------------------

        methods: {


            // ----------------------------------------------

            pushRealTimeMessage() {
                this.channel = this.$pusher.subscribe('room-' + this.groupId);
                this.channel.bind('pushMessage', (data) => {

                    this.typing = this.typing.filter(function (val) {
                        return val['id'] !== data.user.id;
                    });

                    this.messages.push({
                        id: data.user.id,
                        name: data.user.name,
                        avatar: data.user.avatar,
                        photo: data.message.photo,
                        text: data.message.body,
                        time: data.message.created_at
                    });

                });
            },

            // ----------------------------------------------

            pushErrorMessage(data) {
                this.messages.push(data);
            },

            // ----------------------------------------------

            userTyping() {
                this.$pusher.subscribe('room-' + this.groupId).bind('userTyping', (data) => {

                    console.log(this.typing.some(elem => elem === data.id));

                    this.typing.push(data);

                    this.typing = this.removeDuplicates(this.typing, data.name);

                    setTimeout(() => {
                        this.typing = this.typing.filter(function (val) {
                            return val['id'] !== data.id;
                        });
                    }, 15000);

                });
            },

            // ----------------------------------------------

            removeDuplicates( arr, prop ) {
                let obj = {};
                return Object.keys(arr.reduce((prev, next) => {
                    if(!obj[next[prop]]) obj[next[prop]] = next;
                    return obj;
                }, obj)).map((i) => obj[i]);
            },

            // ----------------------------------------------

            showImageModal(data) {
                this.uploadImage = data;
            },

            // ----------------------------------------------

            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;
                this.createImage(files[0]);
            },

            // ----------------------------------------------

            createImage(file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.photo = e.target.result;
                    document.getElementById("inputMessage").focus();
                };
                reader.readAsDataURL(file);
            },

            // ----------------------------------------------

            clearImage() {
                this.photo = null;
            },

            // ----------------------------------------------

            welcomeMessage() {
                this.messages.push({
                        id: this.user.id,
                        name: 'h i...',
                        avatar: null,
                        photo: null,
                        text: 'Be the first to send a message :)',
                        time: 'now'
                    });
            },

            // ----------------------------------------------

            allMessages() {

                this.$http.get('/get_latest_group/' + this.groupId).then(response => {
                    if (response.status == 200) {

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
                }, response => {
                    // ...
                });

            },

            // ----------------------------------------------

            addMessage(new_message) {
                this.messages.push(new_message);
                this.photo = null;
                this.uploadImage = false;
            },

            // ----------------------------------------------

            getGroup() {
                this.$http.get('/get_group_chat/' + this.groupId).then(response => {

                    if (response.status == 200) {

                        if (response.data === 0 || !response.data) return this.$router.push('/');

                        this.showChat = true;

                        this.groupName = response.data.name;
                        if (response.data.avatar) this.avatar = response.data.avatar;

                    } else {
                        this.$router.push('/');
                    }

                }, () => {
                    this.$router.push('/');
                });
            },

            // ----------------------------------------------

        }
    }
</script>
