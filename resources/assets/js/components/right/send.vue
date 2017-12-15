<template>
    <div id="send_app">

        <div class="wrap-message">
            <i class="fa fa-smile-o fa-lg" aria-hidden="true"></i>
            <div class="message">
                <input type="text" class="input-message" placeholder="Escribe un nuevo mensaje">
            </div>
            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Send ok!')
        }
    }
</script>
