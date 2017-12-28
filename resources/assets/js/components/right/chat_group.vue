<template lang="pug">
    #right_app

        .chat-head
            img.img-head(alt='profilepicture', src='https://avatars.io/twitter/maryam')
            .chat-name
                h1.font-name {{ groupName }}
                p.font-online Ismael, Fatima, Admin, Marta, victor...
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
                groupName: this.$route.params.group_name,
                groupId: this.$route.params.group_id,
                uploadImage: false,
                photo: null,
                messages: [],
                messages_ready: false
            }
        },

        // ----------------------------------------------

        mounted() {
            this.allMessages();
            console.log('Right ok!');
        },

        // ----------------------------------------------

        methods: {

            // ----------------------------------------------

            showImageModal(data) {
                this.uploadImage = data;
            },

            // ----------------------------------------------

            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
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
            }

            // ----------------------------------------------

        }
    }
</script>
