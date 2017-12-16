<template>
    <div id="bienvenido_app">

        <div class="chat-head">
            <img alt="profilepicture" src="https://avatars.io/twitter/nada">
            <div class="chat-name">
                <h1 class="font-name">Profile</h1>
                <p class="font-online">Ismael, Fatima, Admin, Marta, victor...</p>
            </div>
            <i class="fa fa-whatsapp fa-lg" aria-hidden="true"></i>
        </div>

        <div class="wrap-content">
            <div class="dynamic_content">


            </div>
        </div>

    </div>
</template>

<style scoped>
    #bienvenido {
        background-color: #ffffff;
        border-radius: 2px;
        height: calc(98vh - 25px);
    }
    .dynamic_content {
        padding: 10px;
        background-color: #ffffff;
        height: calc(98vh - 105px);
    }
</style>

<script>
    export default {
        mounted() {
            console.log('Bienvenido ok!')
        }
    }
</script>
