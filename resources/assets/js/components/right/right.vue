<template>
    <div id="right_app">

        <bar></bar>

        <div class="wrap-chat">

            <div class="chat">

                <messages></messages>

            </div>

            <div class="upload_foto">
                <div class="container_foto font-preview">
                    <p>Subir imagen</p>
                </div>
            </div>

        </div>

        <send></send>

    </div>
</template>

<style scoped>
    .chat {
        height: calc(98vh - 165px);
    }
</style>

<script>
    export default {
        mounted() {
            console.log('Right ok!')
        }
    }
</script>
