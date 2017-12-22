<template>
    <div id="paginate_app">

        <div class="pagination">
            <ul class="page-numbers">
                <li><a href="" class="prev">«</a></li>
                <li><a href="" class="current">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">4</a></li>
                <li><a href="">5</a></li>
                <li><a href="" class="next">»</a></li>
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

            a,span {
                color: #777777;
                background: white;
                border: 1px solid #cccccc;
                box-shadow: 0px 1px 2px #fff;
                padding: 5px;
                display: block;
                text-align: center;
                border-radius: 2px;
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
        mounted() {
            console.log('Paginate ok!');
        }
    }
</script>
