<template lang="pug">
    #send_app
        .wrap-message
            form.wrap-message(method='POST', v-on:submit.prevent='', enctype='multipart/form-data')

                button.format_button(type='button', v-on:click='showModal')
                    i(v-bind:class="[uploadImageState ? 'green_teal' : '', 'material-icons']")
                        | photo_camera

                .message
                    input#inputMessage.input-message(@keyup.enter='addMessage',
                                                        v-model='messageText',
                                                        type='text',
                                                        autocomplete='off',
                                                        placeholder='Write a new message')

                button.format_button(type='button', @click='addMessage')
                    i(v-bind:class="[btnSubmit ? '' : 'green_teal', 'material-icons']") send

</template>

<style scoped>
    .green_teal {
        color: #009688;
    }
</style>

<script>
    export default {

        // ----------------------------------------------

        props: ['uploadImageState', 'user', 'photo'],

        // ----------------------------------------------

        data() {
          return {
              groupId: window.atob(this.$route.params.group_id),
              messageText: '',
              formData: null,
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

                this.formData = {
                    group_id: this.groupId,
                    message: this.messageText,
                    photo: this.photo
                };

                this.$http.post('/send_message_in_group', this.formData).then(response => {
                    if (response.status === 200) {
                        this.typing = false;
                        this.messageText = '';
                    } else {
                        this.emitMessage(this.photo, this.messageText, null);
                        this.messageText = '';
                    }
                }, () => {
                    this.emitMessage(this.photo, this.messageText, null);
                    this.messageText = '';
                });

            },

            // ----------------------------------------------

            emitMessage(photo, message, time) {
                return this.$emit('errorMessages', {
                    id: this.user.id,
                    name: this.user.name,
                    avatar: this.user.avatar,
                    photo: photo,
                    text: message,
                    time: time
                });
            },

            // ----------------------------------------------

            typingUsers() {
                this.$http.get('/user_typing/' + this.groupId);
            },

            // ----------------------------------------------

        },
        computed: {

            // ----------------------------------------------

            btnSubmit() {
                if (this.photo) return;

                if (this.messageText.length === 0) {
                    this.typing = false;
                }

                if (this.messageText.length === 1) {
                    if (!this.typing) this.typingUsers();
                    this.typing = true;
                }

                return (this.messageText.length < 2);
            }

            // ----------------------------------------------

        }
    }
</script>
