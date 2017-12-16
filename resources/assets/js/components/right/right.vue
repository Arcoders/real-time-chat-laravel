<template>
    <div id="right_app">

        <bar></bar>

        <div class="wrap-content">

            <div class="dynamic_content chat">

                <messages></messages>

            </div>

            <div v-if="uploadImage" class="upload_foto">
                <div class="container_foto font-preview">
                    <p>Subir imagen</p>
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
        data() {
            return {
                uploadImage: false
            }
        },
        methods: {
            showImageModal(data) {
                this.uploadImage = data;
            }
        },
        mounted() {
            console.log('Right ok!');
        },
    }
</script>
