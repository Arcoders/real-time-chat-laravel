<template lang="pug">

        form.send(method='POST', v-on:submit.prevent='', enctype='multipart/form-data')

            button(type='button', v-on:click='showModal')

                i(v-bind:class="[uploadImageState ? 'green' : '', 'material-icons']") photo_camera

            .message
                input(@keyup.enter='addMessage', v-model='messageText', type='text', autocomplete='off', placeholder='Write a new message')

            button(type='button', @click='addMessage')

                i(v-bind:class="[btnSubmit ? '' : 'green', 'material-icons']") send

</template>

<style scoped>

</style>

<script>
    export default {

        // ----------------------------------------------

        props: ['uploadImageState', 'photo', 'uploadedPhoto'],

        // ----------------------------------------------

        data() {
          return {
              chatId: window.atob(this.$route.params.chat_id),
              user: this.$store.state.user,
              messageText: '',
              typing: false
          }
        },

        // ----------------------------------------------

        mounted() {
            console.log('Send ok!');
        },

        // ----------------------------------------------

        methods: {

            // ----------------------------------------------

            showModal() {
                this.$emit('showUpload', !this.uploadImageState);
            },

            // ----------------------------------------------

            addMessage() {
                if (this.btnSubmit) return;

                this.$http.post('/messages/send', this.formData).then(response => {

                    (response.status === 200) ? this.resMessage('done') : this.resMessage('error');

                }, () => {
                    this.resMessage('error');
                });

            },

            // ----------------------------------------------

            resMessage(type) {
                if (type === 'error') this.emitMessage(this.photo, this.messageText);
                this.$emit('clearPhoto');
                this.messageText = '';
                this.typing = false;
            },

            // ----------------------------------------------

            emitMessage(photo, message) {
                return this.$emit('errorMessages', {
                    id: this.user.id,
                    name: this.user.name,
                    avatar: this.user.avatar,
                    photo: photo,
                    text: message,
                    error: true
                });
            },

            // ----------------------------------------------

            typingUsers() {
                this.$http.get(`/messages/typing/${this.chatId}/${this.$route.name}`);
            },

            // ----------------------------------------------

        },
        computed: {

            // ----------------------------------------------

            btnSubmit() {
                if (this.photo) return;

                if (this.messageText.length === 0) this.typing = false;

                if (this.messageText.length === 1) {
                    if (!this.typing) this.typingUsers();
                    this.typing = true;
                }

                return (this.messageText.length < 2);
            },

            // ----------------------------------------------

            formData() {
                let formData = new FormData();

                formData.append('chatId', this.chatId);
                formData.append('messageText', this.messageText);
                formData.append('roomName', this.$route.name);
                if (this.uploadedPhoto) formData.append('photo', this.uploadedPhoto);

                return formData;
            }

            // ----------------------------------------------

        }
    }
</script>
