<template lang="pug">
    #right_app(v-if='showChat')

        .chat-head
            avatar.img-head(:username='groupName', color='#fff', :src='avatar')
            .chat-name
                h1.font-name {{ groupName }}
                p.font-online Ismael, Fatima, Admin, Marta, victor... {{ groupId }}
            i.fa.fa-whatsapp.fa-lg(aria-hidden='true')

        .wrap-content

            .dynamic_content.chat
                messages(:messages='messages', :user='user')

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
                v-on:updateMessages="pushMessage($event)",
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
                messages_ready: false
            }
        },

        // ----------------------------------------------

        created() {
            this.pushMessage();
        },

        // ----------------------------------------------

        mounted() {
            this.getGroup();
            this.allMessages();
            console.log('Right ok!');
        },

        // ----------------------------------------------

        methods: {


            // ----------------------------------------------

            pushMessage() {
                this.channel = this.$pusher.subscribe('room-' + this.groupId);
                this.channel.bind('pushMessage', (data) => {
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

            BindEvents(name, action, array) {
                this.channel = this.$pusher.subscribe(name);
                this.channel.bind(action, (data) => {
                    array.push(data);
                });
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

            allMessages() {
                this.messages.push({
                        id: this.user.id,
                        name: this.user.name,
                        avatar: this.user.avatar,
                        photo: 'https://avatars.io/twitter/cute',
                        text: 'Hola muy buenas lorem ipsum dolor set amet',
                        time: '15:20'
                    },
                    {
                        id: 562,
                        name: 'Berto Romero',
                        avatar: 'https://avatars.io/twitter/maryam',
                        photo: null,
                        text: 'قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا',
                        time: '23:45'
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

                        if (response.data === 0) return this.$router.push('/');

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
