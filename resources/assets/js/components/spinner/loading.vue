<template>
    <div class="container">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</template>

<style  scoped>

    .container {
        position: absolute;
        top: 10%;
        right: 0;
        transform: translate(-50%, -50%);
    }
    .dot {
        width: 7px;
        height: 7px;
        border: 2px solid #009688;
        border-radius: 50%;
        float: left;
        margin: 0 5px;
        transform: scale(0);
        animation: fx 1000ms ease infinite 0ms;
    }
    .dot:nth-child(2) {
        animation: fx 1000ms ease infinite 300ms;
    }
    .dot:nth-child(3) {
        animation: fx 1000ms ease infinite 600ms;
    }
    @keyframes fx {
        50% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

</style>

<script>
    export default {
        mounted() {
            console.log('Loading ok!');
        }
    }
</script>
