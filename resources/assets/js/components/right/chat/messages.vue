<template>
    <div id="messages_app">

        <div v-for="message_user in messages"
             v-bind:class="[checkId(message_user.id) ? 'me' : 'you', 'chat-bubble']">

            <div v-bind:class="checkId(message_user.id) ? 'my-mouth' : 'your-mouth'">
                <avatar :username="message_user.name"
                        color="#fff"
                        :src="message_user.avatar"
                        v-bind:class="checkId(message_user.id) ? 'me_img' : 'you_img'">
                </avatar>
            </div>

            <div class="content">{{ message_user.text }}</div>
            <div class="time">{{ message_user.time }}</div>

        </div>

    </div>
</template>

<script>
    export default {
        props: ['user', 'messages'],
        mounted() {
            console.log('Messages ok!');
        },
        methods: {
            checkId(message_user_id) {
                return (this.user.id == message_user_id);
            }
        }
    }
</script>
