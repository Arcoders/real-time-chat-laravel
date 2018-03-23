<template lang="pug">

    .wrap

        router-link.navigate(to='#', @click.native='toggle')
            i.material-icons arrow_back

        section.left
            left(v-show='show')

        section.right
            router-view(:key='$route.fullPath', v-show='show')

</template>

<script>
    export default {

        // ---------------------------------------------------

        props: ['auth_user'],

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
            setTimeout(() => this.show = true, 1000);
        },

        // ---------------------------------------------------

        methods: {

            toggle() {
                document.querySelector(".navigate").style.display = "none";
                document.querySelector(".right").style.display = "none";

                let left = document.querySelector(".left");
                left.style.display = "block";
                left.style.width = "100%";
            }

        }

        // ---------------------------------------------------

    }
</script>
