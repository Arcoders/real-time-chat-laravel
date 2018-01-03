<template lang="pug">
    #messages_app

        div(v-for='message_user in messages',
                v-bind:class="[checkId(message_user.id) ? 'me' : 'you', 'chat-bubble']")

            div(v-bind:class="checkId(message_user.id) ? 'my-mouth' : 'your-mouth'")
                avatar(:username='message_user.name',
                        color='#fff',
                        :size='45',
                        :src='message_user.avatar',
                        v-bind:class="checkId(message_user.id) ? 'me_img' : 'you_img'")

            .content
                div(v-if='message_user.photo')
                    img(:src='message_user.photo')
                |  {{ message_user.text }}

            .time(v-if='!message_user.error') {{ message_user.time | moment("from", "now") }}
            .time(v-else)
                i.material-icons.errorchat error


        div(v-for='userTyping in usersTyping', v-if="userTyping.id != user.id", class="typing-bubble")

            div(class="typing-mouth")
                avatar(:username='userTyping.name',
                color='#fff',
                :size='45',
                :src='userTyping.avatar',
                class="you_img")

            .typing-content
                    span(class="dot")
                    span(class="dot")
                    span(class="dot")

</template>

<script>
    export default {

        // ----------------------------------------------

        props: ['user', 'messages', 'usersTyping'],

        // ----------------------------------------------

        mounted() {
            console.log('Messages ok!');
        },

        // ----------------------------------------------

        methods: {
            checkId(message_user_id) {
                return (this.user.id == message_user_id);
            }
        }

        // ----------------------------------------------

    }
</script>
