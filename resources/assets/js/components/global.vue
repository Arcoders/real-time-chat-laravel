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
    export default {

        // ---------------------------------------------------

        props: ['auth_user'],

        // ---------------------------------------------------

        created() {
            this.$store.commit('updateUser', this.auth_user);
            this.resetStyle();
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

            // ---------------------------------------------------

            updateStyles() {
                this.Styles('none', 'none', 'block', '100%')
            },

            // ---------------------------------------------------

            resetStyle() {
                window.addEventListener('resize', () => {
                    if (window.innerWidth > 800) this.Styles('', '', '', '')
                });
            },

            // ---------------------------------------------------

            Styles(displayNavigate, displayRight, displayLeft, widthLeft) {
                document.querySelector(".navigate").style.display = displayNavigate;
                document.querySelector(".right").style.display = displayRight;

                let left = document.querySelector(".left");
                left.style.display = displayLeft;
                left.style.width = widthLeft;
            }

            // ---------------------------------------------------

        }

        // ---------------------------------------------------

    }
</script>
