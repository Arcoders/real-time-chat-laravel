<template>
    <div id="send_app">

        <div class="wrap-message">
            <form method="POST" class="wrap-message" v-on:submit.prevent=""  enctype="multipart/form-data">
                <button  type="button" class="format_button" v-on:click="showModal">
                    <i v-bind:class="[uploadImageState ? 'green_teal' : '', 'material-icons']">photo_camera</i>
                </button>

                <div class="message">
                    <input @keyup.enter="addMessage"
                           v-model="messageText"
                           type="text"
                           class="input-message"
                           placeholder="Escribe un nuevo mensaje">
                </div>

                <button type="button"
                        @click="addMessage"
                        class="format_button">
                    <i  v-bind:class="[btnSubmit ? '' : 'green_teal', 'material-icons']">send</i>
                </button>
            </form>
        </div>

    </div>
</template>

<style scoped>
    .green_teal {
        color: #009688;
    }
</style>

<script>
    export default {
        props: ['uploadImageState', 'user', 'photo'],
        data() {
          return {
              messageText: ''
          }
        },
        methods: {
            showModal() {
                this.$emit('showUpload', !this.uploadImageState);
            },
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
            }
        },
        mounted() {
            console.log('Send ok!');
        },
        computed: {
            btnSubmit() {
                return ( this.messageText.length < 2);
            }
        }
    }
</script>
