<template>
    <div class="global">
        <span class="nortification animateOpen">Add New Message!</span>
    </div>
</template>

<style  scoped>

    .global {
        width: 100%;
    }

    .nortification {
        padding: 5px 10px;
        position: absolute;
        top: 0;
        right: 0;
        font-size: 12px;
        margin-right: 20px;
        border-radius: 5px;
        background-color: #fff;
        color: #009688;
        font-weight: bold;
        box-shadow: 0px 0px 6px -3px rgba(73,73,73,1);
    }

    .animateOpen {
        -webkit-animation: moveOpen 4s;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-fill-mode: forwards;
    }
    /* Safari and Chrome */
    @-webkit-keyframes moveOpen
    {
        from {-webkit-transform: translate(0,-100px);}
        10% {-webkit-transform: translate(0,20px);}
        12% {-webkit-transform: translate(0,22px);}
        16% {-webkit-transform: translate(0,20px);}
        80% {-webkit-transform: translate(0,20px);}
        85% {-webkit-transform: translate(0,25px);}
        to {-webkit-transform: translate(0,-100px);}
    }

</style>

<script>
    export default {
        props: {
            normal: {
                default: false,
                type: Boolean
            }
        },
        mounted() {
            console.log('Notifications ok!');
        }
    }
</script>
