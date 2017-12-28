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
              groupId: this.$route.params.group_id,
              messageText: '',
              formData: null
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

                this.$emit('pushMessage', this.messageText = {
                    id: this.user.id,
                    name: this.user.name,
                    avatar: this.user.avatar,
                    photo: this.photo,
                    text: this.messageText,
                    time: '08:32'
                });

                this.messageText = '';

                this.formData = {
                    group_id: this.groupId,
                    message: this.messageText,
                    photo: this.photo
                };

                // ....

               /* this.$http.post('/AddMessage', this.formData).then(response => {
                    if (response.body === 200) {
                        // ...
                    } else {
                        // ...
                    }
                }, () => {
                    //...
                });*/
            }

            // ----------------------------------------------

        },
        computed: {

            // ----------------------------------------------

            btnSubmit() {
                if (this.photo) return;
                return ( this.messageText.length < 2);
            }

            // ----------------------------------------------

        }
    }
</script>
