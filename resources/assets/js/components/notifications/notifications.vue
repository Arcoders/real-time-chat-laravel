<template>
    <div id="vue_notifications">

        <div v-for="notification in vue_notifications" class="global">

            <span v-bind:class="[notification.type , 'notification', 'animateOpen']">
                {{ notification.message }}
            </span>

        </div>

    </div>
</template>

<style  scoped>

    .global {
        width: 100%;
    }

    .notification {
        padding: 5px 10px;
        position: absolute;
        top: 10px;
        right: 0;
        font-size: 12px;
        margin-right: 20px;
        border-radius: 7px;
        background-color: #fff;
        font-weight: bold;
        box-shadow: 0px 0px 6px -3px rgba(73,73,73,1);
    }

    .default {
        color: #777777;
    }

    .done {
        color: #009688;
    }

    .validation {
        color: #FF7043;
    }

    .error {
        color: #E57373;
    }

    .animateOpen {
        -webkit-animation: moveOpen 4s;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-fill-mode: forwards;
    }
    /* Safari and Chrome */
    @-webkit-keyframes moveOpen
    {
        from {-webkit-transform: translate(0,-300px);}
        10% {-webkit-transform: translate(0,20px);}
        12% {-webkit-transform: translate(0,22px);}
        16% {-webkit-transform: translate(0,20px);}
        80% {-webkit-transform: translate(0,20px);}
        85% {-webkit-transform: translate(0,25px);}
        to {-webkit-transform: translate(0, -300px);}
    }

</style>

<script>
    export default {
        props: {
            vue_notifications: {
                type: Array,
                required: true,
            }
        },
        mounted() {
            console.log('Notifications ok!');
        }
    }

</script>
