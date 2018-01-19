<template lang="pug">

    include chat_box.pug

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

        mixins: [mixin],

        // ----------------------------------------------
    }
</script>
