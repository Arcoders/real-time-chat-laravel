<template>
    <div id="right_app">

        <bar></bar>

        <div class="wrap-content">

            <div class="dynamic_content chat">

                <messages :user="user"></messages>

            </div>

            <div v-if="uploadImage" class="upload_foto">
                <div class="container_foto font-preview" v-if="!image">
                    <label class="fileContainer">
                        <button>
                            <i class="material-icons">file_upload</i>
                        </button>
                        <input type="file" name="fileInput" v-on:change="onFileChange($event)" ref="fileInput">
                    </label>
                </div>

                <div class="container_foto" v-else>
                    <div class="preview-image">
                        <img alt="profilepicture" :src="image">
                        <a v-on:click="clearImage">
                            <i class="material-icons">clear</i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <send :uploadImageState="uploadImage" @showUpload="showImageModal"></send>

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
                image: null
            }
        },
        mounted() {
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
                    this.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            clearImage() {
                this.image = null;
            }
        }
    }
</script>
