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
        width: 30%;
        position: absolute;
        top: 0;
        right: 0;
        font-size: 14px;
        text-align: center;
        margin: 5px;
        border-radius: 0;
        background-color: #fff;
        font-weight: bold;
        box-shadow: 0px 0px 6px -3px rgba(73,73,73,1);
        -webkit-animation-name: anim;
        -webkit-animation-duration: 4s;
        animation-name: anim;
        animation-duration: 4s;
    }

    @-webkit-keyframes anim {
        from {background-color: #fbfbfb;}
        to {background-color: #ffffff;}
    }

    @keyframes anim {
        from {background-color: #fbfbfb;}
        to {background-color: #ffffff;}
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
