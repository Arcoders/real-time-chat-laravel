<template lang="pug">
    #paginate_app
        .pagination
            ul.numbers
                li
                    a.prev(@click='nextPrev($event, source.current_page - 1)',
                            :class='{disable: source.current_page == 1}')
                        | «
                li(v-for='page in pages')
                    a(@click='navigate($event, page)',
                        :class='{current: source.current_page == page}')
                        | {{ page }}
                li
                    a.next(@click='nextPrev($event, source.current_page + 1)',
                            :class='{disable: source.current_page == source.last_page}')
                        | »

</template>

<script>
    export default {

        // ----------------------------------------------

        props: ['source'],

        // ----------------------------------------------

        data() {
            return {
                pages: []
            }
        },

        // ----------------------------------------------

        watch: {
            source() {
                this.pages = Array.apply(null, {length: this.source.last_page}).map((value, index) => index + 1);
            }
        },

        // ----------------------------------------------

        mounted() {
            console.log('Paginate ok!');
        },

        // ----------------------------------------------

        methods: {

            // ----------------------------------------------

            navigate(event, page) {
                event.preventDefault();
                this.$emit('navigate', page);
            },

            // ----------------------------------------------

            nextPrev(event, page) {
                if (page === 0 || page === this.source.last_page + 1) return;

                this.navigate(event, page);
            }

            // ----------------------------------------------
        }
    }
</script>
