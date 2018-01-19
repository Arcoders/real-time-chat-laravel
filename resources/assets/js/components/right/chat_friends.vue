<template lang="pug">
    transition(name='slide-fade')
        #right_app(v-if='showChat', @mouseleave="mouseLeave", @mouseout="mouseOut")

            .chat-head
                avatar.img-head(:username='friendName', color='#fff', :src='avatar')
                .chat-name
                    h1.font-name {{ friendName }}
                    p.font-online(v-if='onlineUsers')
                        span(v-for='onlineUser in onlineUsers')
                            | {{ onlineUser.name }}
                            span.green_font &#8226;
                    p.font-online(v-else) Online
                        span.red_font &#8226;
                i.fa.fa-whatsapp.fa-lg(aria-hidden='true')

            .wrap-content

                .dynamic_content.chat#chat(v-chat-scroll='')
                    messages(:messages='messages', :user='user', :usersTyping="typing")

                .upload_foto(v-if='uploadImage')

                    .container_foto.font-preview(v-if='!photo')
                        label.fileContainer
                            button
                                i.material-icons file_upload
                            input(type='file',
                                        name='foto',
                                        v-on:change='onFileChange($event)',
                                        ref='fileInput')

                    .container_foto(v-else='')
                        .preview-image
                            img(alt='profilepicture', :src='photo')
                            a(v-on:click='photo = null')
                                i.material-icons clear

            send(:user='user',
                    v-on:errorMessages="pushErrorMessage($event)",
                    v-on:clearPhoto="hideModal",
                    :uploadImageState='uploadImage',
                    @showUpload='showImageModal',
                    :photo='photo',
                    :uploadedPhoto='uploadedPhoto')

</template>

<style scoped>
    .dynamic_content {
        height: calc(98vh - 165px);
    }
    .slide-fade-enter-active {
        transition: all .5s ease;
    }
    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(5px);
        opacity: 0;
    }
    .green_font {
        color: #009688;
        margin: 0 7px;
        font-weight: bold;
    }
    .red_font {
        color: #E57373;
        margin: 0 7px;
        font-weight: bold;
    }

</style>

<script>

    import {mixin} from './chat_mixins';

    export default {

        // ----------------------------------------------

        mixins: [mixin]

        // ----------------------------------------------

    }
</script>
