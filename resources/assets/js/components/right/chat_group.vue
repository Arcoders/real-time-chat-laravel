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
</style>

<script>
    import {mixin} from './chat_mixins';

    export default {

        // ----------------------------------------------

        mixins: [mixin],

        // ----------------------------------------------

    }
</script>
