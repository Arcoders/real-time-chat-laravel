<template lang="pug">

    .wrap

        router-link.navigate(to='#', @click.native='updateStyles')
            i.material-icons arrow_back

        section.left
            left(v-show='show')

        section.right
            router-view(:key='$route.fullPath', v-show='show')

</template>

<script>

    import {mixin} from '../update_style';

    export default {

        // ---------------------------------------------------

        props: ['auth_user'],

        // ---------------------------------------------------

        mixins: [mixin],

        // ---------------------------------------------------

        created() {
            this.$store.commit('updateUser', this.auth_user);
        },

        // ---------------------------------------------------

        data() {
            return {
                show: false
            }
        },

        // ---------------------------------------------------

        mounted() {
            setTimeout(() => this.show = true, 0);
        },

        // ---------------------------------------------------

    }
</script>
