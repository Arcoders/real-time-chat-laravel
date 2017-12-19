<template>
    <div id="bar_app">

        <div class="chat-head">
            <img class="img-head" alt="profilepicture" src="https://avatars.io/twitter/maryam">
            <div class="chat-name">
                <h1 class="font-name">{{ private_name }}</h1>
                <p class="font-online">Ismael, Fatima, Admin, Marta, victor...</p>
            </div>
            <i class="fa fa-whatsapp fa-lg" aria-hidden="true"></i>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                private_name: this.$route.params.user_name,
                private_id: this.$route.params.private_id
            }
        },
        mounted() {
            console.log('Bar ok!');
        }
    }
</script>
