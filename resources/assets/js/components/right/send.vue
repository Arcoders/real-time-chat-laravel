<template>
    <div id="send_app">

        <div class="wrap-message">
            <a href="#" v-on:click="showModal">
                <i class="material-icons">photo_camera</i>
            </a>
            <div class="message">
                <input type="text" class="input-message" placeholder="Escribe un nuevo mensaje">
            </div>
            <i class="material-icons">send</i>
        </div>

    </div>
</template>

<style scoped>
    a {
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    export default {
        props: ['uploadImageState'],
        methods: {
            showModal(event) {
                this.$emit('showUpload', !this.uploadImageState);
            },
        },
        mounted() {
            console.log('Send ok!')
        }
    }
</script>
