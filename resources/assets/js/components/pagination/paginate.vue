<template>
    <div id="paginate_app">

        <div class="pagination">
            <ul class="page-numbers">
                <li>
                    <a href="#"
                       @click="nextPrev($event, source.current_page - 1)"
                       :class="{disable: source.current_page == 1}"
                       class="prev">
                        «
                    </a>
                </li>

                <li v-for="page in pages">
                    <a href="#"
                       @click="navigate($event, page)"
                       :class="{current: source.current_page == page}">
                        {{ page }}
                    </a>
                </li>

                <li>
                    <a href="#"
                       @click="nextPrev($event, source.current_page + 1)"
                       :class="{disable: source.current_page == source.last_page}"
                       class="next">
                        »
                    </a>
                </li>
            </ul>
        </div>

    </div>
</template>

<style lang="scss" scoped>

    a {
        text-decoration:none;
        transition: all .3s ease-out;
    }

    .pagination {
        display: block;
        margin-top: 1em;
        color: white;
        text-align: right;

        .page-numbers li {
            display: inline-block;
            width: 28px;
            height: 28px;

            .disable {
                pointer-events: none;
                box-shadow: none;
                border-radius: 2px;
                color: #aaaaaa;
                border: 1px solid #f5f5f5;
            }

            a,span {
                color: #777777;
                background: white;
                border: 1px solid #cccccc;
                padding: 5px;
                display: block;
                text-align: center;
                border-radius: 2px;
                margin: 2px;
                box-shadow: 0px 0px 1px 0px rgba(119, 119, 119, 0.5);

                &.current {
                    background: #f1f1f1;
                    color: #009688;
                }
            }

            a:hover {
                background: #f1f1f1;
                color: #009688;
                box-shadow: none;
            }

        }
    }


</style>

<script>
    export default {
        props: ['source'],
        data() {
            return {
                pages: []
            }
        },
        watch: {
            source() {
                    this.pages = Array.apply(null, {length: this.source.last_page}).map(function(value, index){
                        return index + 1;
                    });
            }
        },
        mounted() {
            console.log('Paginate ok!');
        },
        methods: {
            navigate(event, page) {
                event.preventDefault();
                this.$emit('navigate', page);
            },
            nextPrev(event, page) {
                if (page == 0 || page == this.source.last_page + 1) return;

                this.navigate(event, page);
            }
        }
    }
</script>
