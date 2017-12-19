<template>
    <div id="right_app">

        <bar></bar>

        <div class="wrap-content">

            <div class="dynamic_content chat">

                <messages :messages="messages" :user="user"></messages>

            </div>

            <div v-if="uploadImage" class="upload_foto">
                <div class="container_foto font-preview" v-if="!photo">
                    <label class="fileContainer">
                        <button>
                            <i class="material-icons">file_upload</i>
                        </button>
                        <input type="file" name="fileInput" v-on:change="onFileChange($event)" ref="fileInput">
                    </label>
                </div>

                <div class="container_foto" v-else>
                    <div class="preview-image">
                        <img alt="profilepicture" :src="photo">
                        <a v-on:click="clearImage">
                            <i class="material-icons">clear</i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <send :user="user"
              :uploadImageState="uploadImage"
              @showUpload="showImageModal"
              :photo="photo"
              @pushMessage="addMessage">
        </send>

    </div>
</template>

<style scoped>
    .dynamic_content {
        height: calc(98vh - 165px);
    }
</style>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                uploadImage: false,
                photo: null,
                messages: [],
                messages_ready: false
            }
        },
        mounted() {
            this.allMessages();
            console.log('Right ok!');
        },
        methods: {
            showImageModal(data) {
                this.uploadImage = data;
            },
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.photo = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            clearImage() {
                this.photo = null;
            },
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
                        id: 2,
                        name: 'Berto Romero',
                        avatar: 'https://avatars.io/twitter/maryam',
                        photo: null,
                        text: 'قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا',
                        time: '23:45'
                    });
            },
            addMessage(new_message) {
                this.messages.push(new_message);
                this.photo = null;
                this.uploadImage = false;
            }
        }
    }
</script>
