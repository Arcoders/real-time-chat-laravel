<template>
    <div id="send_app">

        <div class="wrap-message">
            <button class="format_button" v-on:click="showModal">
                <i v-bind:class="[uploadImageState ? 'green_teal' : '', 'material-icons']">photo_camera</i>
            </button>

            <div class="message">
                <input type="text" class="input-message" placeholder="Escribe un nuevo mensaje">
            </div>

            <button class="format_button">
                <i class="material-icons">send</i>
            </button>
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
